<?php
session_start();
require_once 'conexion.php';
$conn = conectar();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_SESSION['usuario_id'];
    $tit = $conn->real_escape_string($_POST['titulo']);
    $fec = $conn->real_escape_string($_POST['fecha']);
    $conn->query("INSERT INTO citas_embarazo (id_usuario, titulo, fecha_cita) VALUES ('$id', '$tit', '$fec')");
    echo "ok";
}
?>