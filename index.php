<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Calendario Menstrual</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .form-content { display: none; }
        .form-content.active { display: block; }
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
            <button class="tab-btn activo" id="btn-calendarioAdmin" onclick="mostrarTab('calendarioAdmin')">Iniciar Sesión</button>
            <button class="tab-btn" id="btn-registro" onclick="mostrarTab('registro')">Registrarse</button>
        </div>

        <div id="form-login" class="form-content active">
            <form action="index.php" method="POST">
                <div class="input-group">
                    <label> Correo Electrónico</label>
                    <input type="email" name="email" placeholder="tu@email.com" required>
                </div>
                <div class="input-group">
                    <label> Contraseña</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-principal">Entrar</button>
            </form>
        </div>

        <div id="form-registro" class="form-content">
            <form action="index.php" method="POST">
                <div class="input-group">
                    <label> Nombre</label>
                    <input type="text" name="nombre" placeholder="Tu nombre" required>
                </div>
                <div class="input-group">
                    <label> Correo Electrónico</label>
                    <input type="email" name="email" placeholder="tu@email.com" required>
                </div>
                <div class="input-group">
                    <label> Contraseña</label>
                    <input type="password" name="password" placeholder="****" required>
                </div>
                <div class="input-group">
                    <label> Confirmar Contraseña</label>
                    <input type="password" name="confirm_password" placeholder="*****" required>
                </div>
                <button type="submit" class="btn-principal">Crear Cuenta</button>
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