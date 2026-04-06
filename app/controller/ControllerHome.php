<?php
require_once __DIR__ . '/../model/ModelObj.php';
require_once __DIR__ . '/../../config/db-connection.php';

//agafar 4 articles
$featuredArticles = selectRandomArticles(4, $conn);

//Generar la url de la imatge de la api
foreach ($featuredArticles as &$art) {
    $objName = strtolower(str_replace(' ', '-', $art['titol']));
    $art['url_foto'] = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/{$objName}.png";
}
unset($art); 

$isLogged = isset($_SESSION['user']);
?>