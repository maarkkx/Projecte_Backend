<?php
require_once __DIR__ . '/../../config/oauth.php';
require_once __DIR__ . '/../model/ModelLogin.php';

//url posada a github
$redirect_uri = GITHUB_REDIRECT_URI;


//login github
if (isset($_GET['action']) && $_GET['action'] === 'login') {

    //Proteccio CSRF
    $state = bin2hex(random_bytes(16));
    $_SESSION['oauth_state'] = $state;

    //crear la url de github
    $params = [
        'client_id' => GITHUB_CLIENT_ID,
        'redirect_uri' => $redirect_uri,
        'scope' => 'user:email',
        'state' => $state
    ];

    //redireccio a la url
    $url = "https://github.com/login/oauth/authorize?" . http_build_query($params);

    header("Location: $url");
    exit();
}


//agafar el que retorna github
if (isset($_GET['code'])) {

    //comprovacio de seguretat
    if (!isset($_GET['state']) || $_GET['state'] !== $_SESSION['oauth_state']) {
        die("Error");
    }

    $code = $_GET['code'];

    //agafar l'acces token
    $token_url = "https://github.com/login/oauth/access_token";

    //Post a github amb el client y el secret
    $post_data = [
        'client_id' => GITHUB_CLIENT_ID,
        'client_secret' => GITHUB_CLIENT_SECRET,
        'code' => $code,
        'redirect_uri' => $redirect_uri
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $token_url, //la url que cridem
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true, //metode post
        CURLOPT_POSTFIELDS => http_build_query($post_data), //dades amb el github_client_id y secret
        CURLOPT_HTTPHEADER => ['Accept: application/json'] //demanar un json
    ]);

    $response = curl_exec($ch); //guardem la resposta

    if (curl_errno($ch)) {
        die("Error CURL: " . curl_error($ch));
    }

    curl_close($ch); //tanquem conexio

    $token_data = json_decode($response, true); //transformem la resposta en una array

    //llençar error si no tenim l'access token
    if (!isset($token_data['access_token'])) {
        die("Error getting access token");
    }

    $access_token = $token_data['access_token'];


    //creem un altre conexio per agafar les dades del usuari
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://api.github.com/user",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $access_token",
            "User-Agent: Projecte-Backend-Mark",
            "Accept: application/json"
        ]
    ]);

    $user_json = curl_exec($ch);
    curl_close($ch);

    $user_data = json_decode($user_json, true);


    //agafar email
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://api.github.com/user/emails",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $access_token",
            "User-Agent: Projecte-Backend-Mark",
            "Accept: application/json"
        ]
    ]);

    $emails_json = curl_exec($ch);
    curl_close($ch);

    $emails = json_decode($emails_json, true);

    //agafar l'email
    $primary_email = null;
    foreach ($emails as $email) {
        if ($email['primary'] && $email['verified']) {
            $primary_email = $email['email'];
            break;
        }
    }
    
//buscar user
$user = getUserByOAuth("github", $user_data['id'], $conn);

if (!$user) {
    //generar user
    $username = generarUsernameUnico($user_data['login'], $conn);

    crearUsuariOAuth(
        $username,
        $primary_email,
        "github",
        $user_data['id'],
        $conn
    );

    $user = getUserByOAuth("github", $user_data['id'], $conn);
}

//creem la sesió
$_SESSION['user']  = $user['user'];
$_SESSION['admin'] = $user['admin'];

header("Location: index.php");
exit();
}