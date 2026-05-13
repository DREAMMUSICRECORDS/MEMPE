<?php
function conectar()
{
    $host = "localhost";
    $usuario = "root";
    $password = "";
    $basedatos = "mempe";

    $conexion = new mysqli($host, $usuario, $password, $basedatos);

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    return $conexion;
}

function cerrarConexion($conexion)
{
    $conexion->close();
}