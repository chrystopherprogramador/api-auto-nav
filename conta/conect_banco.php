<?php

$host = 'localhost';
$dbname = 'samos';
$user = 'drink';
$pass = '123';

try {
    // Conectar ao MySQL usando PDO
    $bd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

    // Configurar o PDO para lançar exceções em caso de erro
    $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
