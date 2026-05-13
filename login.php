<?php
session_start();
require_once 'conexion.php';
$conn = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    $correo = isset($_POST['correo']) ? $conn->real_escape_string($_POST['correo']) : '';
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';

    if (!empty($correo) && !empty($contrasena)) {
        $sql = "SELECT id, nombre_completo, contrasena FROM usuarios WHERE correo = '$correo'";
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();
           
            if (password_verify($contrasena, $usuario['contrasena']) || $contrasena == $usuario['contrasena']) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre_completo'];
                header("Location: index.php");
                exit();
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "El correo no está registrado.";
        }
    } else {
        $error = "Por favor, llena todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MEMPE - Login</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #fdf6ff; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%; max-width: 350px; }
        h2 { color: #7b2cbf; text-align: center; }
        input { width: 100%; padding: 12px; margin: 10px 0; border-radius: 10px; border: 1px solid #ddd; box-sizing: border-box; }
        button { width: 100%; padding: 12px; border-radius: 10px; border: none; background: #7b2cbf; color: white; font-weight: bold; cursor: pointer; }
        .error { color: red; font-size: 0.8rem; text-align: center; }
    </style>
</head>
<body>

<div class="login-card">
    <h2>Iniciar Sesión</h2>
    
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST" action="login.php">
        <input type="email" name="correo" placeholder="Correo electrónico" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <button type="submit">Entrar</button>
    </form>
    
    <p style="text-align:center; font-size: 0.8rem; margin-top: 15px;">
        ¿No tienes cuenta? <a href="registro.php" style="color: #ff4d8d;">Regístrate aquí</a>
    </p>
</div>

</body>
</html>