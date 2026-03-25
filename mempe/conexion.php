<?php
$host = "localhost";      
$usuario = "root";        
$password = "";           
$basedatos = "mempe";    


$conn = new mysqli($host, $usuario, $password, $basedatos);


if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");

echo "Conexión exitosa";
?>