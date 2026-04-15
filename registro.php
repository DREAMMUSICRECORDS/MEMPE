<?php

include("conexion.php");

function registrarUsuario($nombre, $email, $contrasena) {
    $conn = conectar();

    // Verificar si el correo ya existe
    $verificar = "SELECT id FROM usuarios WHERE correo = '$email'";
    $resultado = $conn->query($verificar);

    if ($resultado->num_rows > 0) {
        return "El correo ya está registrado";
    }

    // Insertar nuevo usuario
    $insertar = "INSERT INTO usuarios (nombre_completo, correo, contrasena) VALUES ('$nombre', '$email', '$contrasena')";
    
    if ($conn->query($insertar) === TRUE) {
        return true;
    } else {
        return "Error: " . $conn->error;
    }
}