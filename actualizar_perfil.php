<?php
session_start();
require_once 'conexion.php';
$conn = conectar();

if (!isset($_SESSION['usuario_id'])) { exit; }
$id_usuario = $_SESSION['usuario_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nuevo_nombre']);
    $correo = $conn->real_escape_string($_POST['nuevo_correo']);
    $biografia = $conn->real_escape_string($_POST['biografia']);

    $foto_sql = "";
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
        $dir = "uploads/";
        if (!is_dir($dir)) mkdir($dir, 0777, true);
        
        $ext = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
        $nombre_archivo = "user_" . $id_usuario . "_" . time() . "." . $ext;
        
        if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $dir . $nombre_archivo)) {
            $foto_sql = ", foto = '$nombre_archivo'";
        }
    }

    $sql = "UPDATE usuarios SET 
            nombre_completo = '$nombre', 
            correo = '$correo', 
            biografia = '$biografia' 
            $foto_sql 
            WHERE id = $id_usuario";

    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>