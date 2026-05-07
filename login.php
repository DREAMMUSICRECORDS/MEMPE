<?php
session_start();
require_once 'registro.php';
require_once 'conexion.php';

// Si ya hay una sesión activa, redirigir al tablero principal
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$mensaje_error = "";

// Lógica de Registro
if(isset($_POST['accion']) && $_POST['accion'] == 'registro') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['email'];
    $contrasena = $_POST['password'];
    $confirmar_contrasena = $_POST['confirm_password'];

    if($contrasena !== $confirmar_contrasena) {
        $mensaje_error = "Las contraseñas no coinciden";
    } else {
        $resultado = registrarUsuario($nombre, $correo, $contrasena);
        if ($resultado === true) {
            header("Location: login.php?registro=ok");
            exit;
        } else {
            $mensaje_error = $resultado;
        }
    }
}

// Lógica de Inicio de Sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['accion'])) {
    $email = $_POST['email']; // <--- REVISA QUE LA LÍNEA ANTERIOR TENGA EL ;
    $password = $_POST['password'];
    
    $conn = conectar();
    // Importante: Asegúrate de que los nombres de las columnas coincidan con tu DB
    $sql = "SELECT id, nombre_completo FROM usuarios WHERE correo = '$email' AND contrasena = '$password'";
    $resultado = $conn->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre_completo'];
        header("Location: index.php"); 
        exit;
    } else {
        $mensaje_error = "Correo o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso - Mi Calendario Menstrual</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .form-content { display: none; }
        .form-content.active { display: block; }
        .error { color: #d32f2f; background: #ffebee; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        .success { color: #388e3c; background: #e8f5e9; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="contenedor-auth">
    <div class="titulo-principal">
        <span class="icono-corazon">❤️</span>
        <h1>Mi Calendario Menstrual</h1>
        <p>Tu compañera de salud femenina</p>
    </div>

    <div class="card">
        <h3>Bienvenida</h3>
        <p class="subtitulo" id="texto-bienvenida">Inicia sesión para continuar</p>

        <div class="tabs-registro">
            <button class="tab-btn activo" id="btn-login" onclick="mostrarTab('login')">Iniciar Sesión</button>
            <button class="tab-btn" id="btn-registro" onclick="mostrarTab('registro')">Registrarse</button>
        </div>

        <!-- Formulario de Login -->
        <div id="form-login" class="form-content active">
            <?php if ($mensaje_error != ''): ?>
                <div class="error"><?php echo $mensaje_error; ?></div>
            <?php endif; ?>
            <?php if (isset($_GET['registro']) && $_GET['registro'] == 'ok'): ?>
                <div class="success">Registro exitoso. ¡Inicia sesión!</div>
            <?php endif; ?>
            
            <form action="login.php" method="POST">
                <div class="input-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" placeholder="tu@email.com" required>
                </div>
                <div class="input-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-principal">Entrar</button>
            </form>
        </div>

        <!-- Formulario de Registro -->
        <div id="form-registro" class="form-content">
            <form action="login.php" method="POST">
                <div class="input-group">
                    <label>Nombre Completo</label>
                    <input type="text" name="nombre" placeholder="Tu nombre" required>
                </div>
                <div class="input-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" placeholder="tu@email.com" required>
                </div>
                <div class="input-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <div class="input-group">
                    <label>Confirmar Contraseña</label>
                    <input type="password" name="confirm_password" placeholder="••••••••" required>
                </div>
                <input type="hidden" name="accion" value="registro">
                <button type="submit" class="btn-principal">Crear Cuenta</button>
            </form>
        </div>
    </div>
</div>

<script>
function mostrarTab(tipo) {
    document.getElementById('form-login').classList.remove('active');
    document.getElementById('form-registro').classList.remove('active');
    document.getElementById('btn-login').classList.remove('activo');
    document.getElementById('btn-registro').classList.remove('activo');
    if (tipo === 'login') {
        document.getElementById('form-login').classList.add('active');
        document.getElementById('btn-login').classList.add('activo');
        document.getElementById('texto-bienvenida').innerText = 'Inicia sesión para continuar';
    } else {
        document.getElementById('form-registro').classList.add('active');
        document.getElementById('btn-registro').classList.add('activo');
        document.getElementById('texto-bienvenida').innerText = 'Crea tu cuenta ahora';
    }
}
</script>
</body>
</html>