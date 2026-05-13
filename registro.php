<?php
require_once 'conexion.php';
$conn = conectar();

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $pass = $_POST['contrasena'];
    
    // Encriptamos la contraseña por seguridad
    $pass_encriptada = password_hash($pass, PASSWORD_DEFAULT);

    // Verificamos si el correo ya existe
    $check = $conn->query("SELECT id FROM usuarios WHERE correo = '$correo'");
    
    if ($check->num_rows > 0) {
        $mensaje = "<p style='color:red;'>Este correo ya está registrado.</p>";
    } else {
        $sql = "INSERT INTO usuarios (nombre_completo, correo, contrasena, rol) 
                VALUES ('$nombre', '$correo', '$pass_encriptada', 'user')";
        
        if ($conn->query($sql)) {
            $mensaje = "<p style='color:green;'>¡Registro exitoso! <a href='login.php'>Inicia sesión aquí</a></p>";
        } else {
            $mensaje = "<p style='color:red;'>Error al registrar: " . $conn->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MEMPE - Registro</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #fdf6ff; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%; max-width: 350px; }
        h2 { color: #ff4d8d; text-align: center; }
        input { width: 100%; padding: 12px; margin: 10px 0; border-radius: 10px; border: 1px solid #ddd; box-sizing: border-box; }
        button { width: 100%; padding: 12px; border-radius: 10px; border: none; background: #ff4d8d; color: white; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Crear Cuenta</h2>
        <?php echo $mensaje; ?>
        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit">Registrarme</button>
        </form>
        <p style="text-align:center; font-size: 0.8rem; margin-top: 15px;">
            ¿Ya tienes cuenta? <a href="login.php" style="color: #7b2cbf;">Inicia sesión</a>
        </p>
    </div>
</body>
</html>