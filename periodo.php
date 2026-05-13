<?php

header('Content-Type: application/json; charset=utf-8');

require_once 'conexion.php';

$id_usuario = $_GET['id_usuario'] ?? null;

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo == 'GET') {
    
    $obtener = "SELECT fecha FROM fechas_periodo WHERE id_usuario = $id_usuario";
    $resultado = $conn->query($obtener);
    

    $fechas = array();
    while ($fila = $resultado->fetch_assoc()) {
        $fechas[] = $fila['fecha'];
    }
    

    echo json_encode(array(
        'estatus' => 'ok',
        'fechas' => $fechas
    ));
}


elseif ($metodo == 'POST') {
    
  
    $datos = json_decode(file_get_contents('php://input'), true);
    

    if (!isset($datos['fecha'])) {
        echo json_encode(array(
            'estatus' => 'error',
            'mensaje' => 'Debes enviar una fecha'
        ));
        exit;
    }
    
    $fecha = $datos['fecha'];
    

    $buscar = "SELECT id FROM fechas_periodo WHERE id_usuario = $id_usuario AND fecha = '$fecha'";
    $resultado = $conn->query($buscar);
    
    if ($resultado->num_rows > 0) {
        $eliminar = "DELETE FROM fechas_periodo WHERE id_usuario = $id_usuario AND fecha = '$fecha'";
        $conn->query($eliminar);
        
        echo json_encode(array(
            'estatus' => 'ok',
            'mensaje' => 'Fecha eliminada'
        ));
    } else {
        
        $guardar = "INSERT INTO fechas_periodo (id_usuario, fecha) VALUES ($id_usuario, '$fecha')";
        
        if ($conn->query($guardar)) {
            echo json_encode(array(
                'estatus' => 'ok',
                'mensaje' => 'Fecha guardada'
            ));
        } else {
            echo json_encode(array(
                'estatus' => 'error',
                'mensaje' => 'Error al guardar: ' . $conn->error
            ));
        }
    }
}

else {
    echo json_encode(array(
        'estatus' => 'error',
        'mensaje' => 'Método no permitido'
    ));
}

$conn->close();
?>