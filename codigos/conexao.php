<?php
$host = "localhost";
$usuario = "root";
$senha = '$uper1Toby';
$banco = "trabalho_bd";

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
