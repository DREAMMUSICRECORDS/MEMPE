<?php

session_start();
require_once 'conexion.php';


if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}


$id_usuario = $_SESSION['usuario_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nuevo_nombre'];
    $correo = $_POST['nuevo_correo'];
    $contrasena = $_POST['nueva_contrasena'] ?? '';
   $confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';
    $actualizar = "UPDATE usuarios SET 
                   nombre_completo = '$nombre', 
                   correo = '$correo',
                   contrasena = '$contrasena', 
                   confirmar_contrasena = '$confirmar_contrasena',
                   WHERE id = $id_usuario";
    

    if ($conn->query($actualizar)) {
   
        $_SESSION['usuario_nombre'] = $nombre;
       
        header("Location: calendarioAdmin.php?actualizado=ok");
        exit;
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
}

$conn->close();
?>