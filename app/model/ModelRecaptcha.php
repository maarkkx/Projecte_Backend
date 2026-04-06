<?php
function verificarRecaptcha(string $postRecaptcha, string $secretKey): bool {
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
          . $secretKey . '&response=' . $postRecaptcha;

    $response = file_get_contents($url);
    $response = json_decode($response);
    
    return $response->success === true;

}
?>