<?php
session_start();
require_once 'conexion.php';
$conn = conectar();
$id_cita = $_GET['id'];
$id_user = $_SESSION['usuario_id'];
$conn->query("DELETE FROM citas_embarazo WHERE id = $id_cita AND id_usuario = $id_user");
echo "ok";
?>