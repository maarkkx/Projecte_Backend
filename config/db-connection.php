<?php
$servername = "localhost";
$username = "root";
$password = "";

//Conexió
try {
  $conn = new PDO("mysql:host=$servername;dbname=pjf_mark_gras", $username, $password);

  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Error conn: " . $e->getMessage();
}
?>