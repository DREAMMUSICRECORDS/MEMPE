<?php
require_once 'conexion.php';

echo "Inicializando base de datos...\n\n";

// Crear tabla usuarios si no existe
$sql_usuarios = "
CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre_completo VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    fecha_nacimiento DATE,
    biografia TEXT,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_usuarios)) {
    echo "✓ Tabla 'usuarios' creada/verificada\n";
} else {
    echo "✗ Error en tabla 'usuarios': " . $conn->error . "\n";
}

// Crear tabla fechas_periodo si no existe
$sql_fechas_periodo = "
CREATE TABLE IF NOT EXISTS fechas_periodo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    fecha DATE NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_fecha (id_usuario, fecha)
)";

if ($conn->query($sql_fechas_periodo)) {
    echo "✓ Tabla 'fechas_periodo' creada/verificada\n";
} else {
    echo "✗ Error en tabla 'fechas_periodo': " . $conn->error . "\n";
}

// Crear tabla sintomas si no existe
$sql_sintomas = "
CREATE TABLE IF NOT EXISTS sintomas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    tipo VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    descripcion TEXT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
)";

if ($conn->query($sql_sintomas)) {
    echo "✓ Tabla 'sintomas' creada/verificada\n";
} else {
    echo "✗ Error en tabla 'sintomas': " . $conn->error . "\n";
}

// Crear tabla citas si no existe
$sql_citas = "
CREATE TABLE IF NOT EXISTS citas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    descripcion VARCHAR(200),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
)";

if ($conn->query($sql_citas)) {
    echo "✓ Tabla 'citas' creada/verificada\n";
} else {
    echo "✗ Error en tabla 'citas': " . $conn->error . "\n";
}

echo "\n✓ Base de datos inicializada correctamente\n";

// Crear usuario de prueba
$email_prueba = 'prueba@email.com';
$sql_check = "SELECT id FROM usuarios WHERE correo = ?";
$stmt_check = $conn->prepare($sql_check);

if ($stmt_check) {
    $stmt_check->bind_param("s", $email_prueba);
    $stmt_check->execute();
    $resultado = $stmt_check->get_result();
    
    if ($resultado->num_rows === 0) {
        $nombre_prueba = 'Usuario Prueba';
        $password_prueba = '123456';
        $sql_insert = "INSERT INTO usuarios (nombre_completo, correo, contrasena) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        
        if ($stmt_insert) {
            $stmt_insert->bind_param("sss", $nombre_prueba, $email_prueba, $password_prueba);
            
            if ($stmt_insert->execute()) {
                echo "\n✓ Usuario de prueba creado:\n";
                echo "  Correo: prueba@email.com\n";
                echo "  Contraseña: 123456\n";
            } else {
                echo "\n✗ Error al crear usuario de prueba: " . $conn->error . "\n";
            }
            $stmt_insert->close();
        }
    } else {
        echo "\nℹ Usuario de prueba ya existe\n";
    }
    
    $stmt_check->close();
} else {
    echo "\n✗ Error en preparación de consulta: " . $conn->error . "\n";
}
$conn->close();

echo "\nPuedes eliminar este archivo (init_database.php) después de usar.\n";
?>
