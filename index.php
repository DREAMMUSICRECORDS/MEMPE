<?php
session_start();
require_once 'registro.php';

if(isset($_POST['accion']) && $_POST['accion'] == 'registro') {
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $correo = $_POST['email'];
        $contrasena = $_POST['password'];
        $confirmar_contrasena = $_POST['confirm_password'];

        if($contrasena !== $confirmar_contrasena) {
            $mensaje_error = "Las contraseñas no coinciden";
            return;
        }

        $resultado = registrarUsuario($nombre, $correo, $contrasena);

        if ($resultado === true) {
            header("Location: index.php?registro=ok");
            exit;
        } else {
            $mensaje_error = $resultado;
        }

    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Calendario Menstrual</title>
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

        <div id="form-login" class="form-content active">
           
            <?php if (isset($mensaje_error) and $mensaje_error != ''): ?>
                <div class="error"><?php echo $mensaje_error; ?></div>
            <?php endif; ?>
          
            <?php if (isset($_GET['registro']) && $_GET['registro'] == 'ok'): ?>
                <div class="success">Registro exitoso. Por favor, inicia sesión.</div>
            <?php endif; ?>
            
           
            <form action="index.php" method="POST">
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

        <div id="form-registro" class="form-content">
         
            <?php if (isset($mensaje_error) and $mensaje_error != ''): ?>
                <div class="error"><?php echo $mensaje_error; ?></div>
            <?php endif; ?>
            
     
            <form action="index.php" method="POST">
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
                <button type="submit" class="btn-principal">Crear Cuenta</button>
                <input type="hidden" name="accion" value="registro">
            </form>
        </div>

        <p class="terminos">
            Al continuar, aceptas nuestros términos y condiciones
        </p>
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