<?php
require_once 'conexion.php';

$id_usuario = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nuevo_nombre']);
    $correo = $conn->real_escape_string($_POST['nuevo_correo']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $fecha_nac = $conn->real_escape_string($_POST['fecha_nacimiento']);
    $biografia = $conn->real_escape_string($_POST['biografia']);

    $sql = "UPDATE usuarios SET 
            nombre_completo = ?, 
            correo = ?, 
            telefono = ?, 
            fecha_nacimiento = ?, 
            biografia = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nombre, $correo, $telefono, $fecha_nac, $biografia, $id_usuario);

    if ($stmt->execute()) {
        header("Location: calendarioAdmin.php?actualizado=true");
        exit();
    } else {
        echo "Error al actualizar el perfil: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>