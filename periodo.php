<?php
header('Content-Type: application/json');
require_once 'conexion.php';

$id_usuario = 1; 
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        $sql = "SELECT fecha FROM fechas_periodo WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $fechas = [];
        while ($fila = $resultado->fetch_assoc()) {
            $fechas[] = $fila['fecha'];
        }
        echo json_encode(['status' => 'success', 'fechas' => $fechas]);
        $stmt->close();
        break;

    case 'POST':
        $datos = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($datos['fecha'])) {
            echo json_encode(['status' => 'error', 'message' => 'Fecha no proporcionada']);
            exit;
        }

        $fecha = $datos['fecha'];

        $sql_check = "SELECT id FROM fechas_periodo WHERE id_usuario = ? AND fecha = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("is", $id_usuario, $fecha);
        $stmt_check->execute();
        $resultado_check = $stmt_check->get_result();

        if ($resultado_check->num_rows > 0) {
            $sql_action = "DELETE FROM fechas_periodo WHERE id_usuario = ? AND fecha = ?";
            $mensaje = "Fecha eliminada";
        } else {
            $sql_action = "INSERT INTO fechas_periodo (id_usuario, fecha) VALUES (?, ?)";
            $mensaje = "Fecha guardada";
        }
        $stmt_check->close();

        $stmt_action = $conn->prepare($sql_action);
        $stmt_action->bind_param("is", $id_usuario, $fecha);
        
        if ($stmt_action->execute()) {
            echo json_encode(['status' => 'success', 'message' => $mensaje]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
        }
        $stmt_action->close();
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
        break;
}

$conn->close();
?>