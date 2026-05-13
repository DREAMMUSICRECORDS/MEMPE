<?php
session_start();
require_once 'conexion.php';
$conn = conectar();
$id = $_SESSION['usuario_id'];
$res = $conn->query("SELECT id, titulo, fecha_cita FROM citas_embarazo WHERE id_usuario = $id ORDER BY fecha_cita ASC");
$data = [];
while($f = $res->fetch_assoc()) { $data[] = $f; }
header('Content-Type: application/json');
echo json_encode($data);
?>