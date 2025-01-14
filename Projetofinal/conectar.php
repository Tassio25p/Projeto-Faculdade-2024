<?php
$username = "root";
$password = "";
try {
    $conecta = new PDO("mysql:host=localhost;dbname=financas", $username, $password);
    $conecta->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
