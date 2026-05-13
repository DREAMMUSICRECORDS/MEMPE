<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Configuración del Perfil</title>
<link rel="stylesheet" href="css/estilos.css">
</head>

<body>

<div class="overlay" id="modalPerfil" style="display: none;">
    <div class="modal">
        <div class="modal-header">
            <h2>Configuración de Perfil</h2>
            <p>Actualiza tu información personal</p>
            <span class="cerrar" onclick="cerrarPerfil()">✕</span>
        </div>

        <div class="tabs">
            <button class="tab-modal activo">Perfil Personal</button>
            <button class="tab-modal">Avatar</button>
        </div>

        <div class="perfil-avatar-seccion">
            <div class="circulo-avatar">👤</div>
            <button class="btn-avatar-link">Crear Avatar Personalizado</button>
        </div>

        <form class="form-grid" action="index.php" method="POST">
            <div class="campo">
                <label>Nombre Completo</label>
                <input type="text" name="nuevo_nombre" placeholder="hellen">
            </div>

            <div class="campo">
                <label>Correo Electrónico</label>
                <input type="email" name="nuevo_correo" placeholder="correo@email.com">
            </div>

            <div class="campo">
                <label>Teléfono</label>
                <input type="text" placeholder="+57 300 000 0000">
            </div>

            <div class="campo">
                <label>Fecha de Nacimiento</label>
                <input type="date">
            </div>

            <div class="campo full">
                <label>Biografía</label>
                <textarea placeholder="Cuéntanos sobre ti..."></textarea>
            </div>

            <div class="acciones">
                <button type="submit" class="guardar">Guardar Cambios</button>
                <button type="button" class="cancelar" onclick="cerrarPerfil()">Cancelar</button>
            </div>
        </form>
    </div>
</div>