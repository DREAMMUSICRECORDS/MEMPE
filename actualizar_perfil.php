<?php
session_start();
require_once 'conexion.php';
$conn = conectar();


if (!isset($_SESSION['usuario_id'])) exit();
$id_admin = $_SESSION['usuario_id'];
$res = $conn->query("SELECT rol FROM usuarios WHERE id = $id_admin");
$admin_data = $res->fetch_assoc();

if ($admin_data['rol'] !== 'admin') exit("No autorizado");


if (isset($_GET['accion']) && isset($_GET['id'])) {
    $id_target = intval($_GET['id']);
    $accion = $_GET['accion'];

    if ($accion === 'eliminar') {
        $conn->query("DELETE FROM usuarios WHERE id = $id_target");
    } 
    
    if ($accion === 'cambiar_rol') {
        $rol_actual = $_GET['actual'];
        $nuevo_rol = ($rol_actual === 'admin') ? 'user' : 'admin';
        $conn->query("UPDATE usuarios SET rol = '$nuevo_rol' WHERE id = $id_target");
    }

  
    header("Location: admin.php");
    exit();
}
?>