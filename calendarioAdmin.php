<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración - Mi Calendario</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<div class="contenedor-dashboard">
    <header class="header-app">
        <div class="logo">
            <h1 style="margin:0">❤️ MI MEMPE</h1>
            <p style="margin:0; opacity:0.8">Panel Administrativo | Hellen</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <button class="volver" onclick="location.href='index.php'">Ir al Inicio</button>
            <button class="btn-accion" style="width:auto; padding: 10px 20px;" onclick="location.href='index.php'">Cerrar Sesión</button>
        </div>
    </header>

    <main class="grid-principal">
        <section class="card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2 style="margin:0">Gestión de Ciclo - Febrero 2026</h2>
                <button class="btn-editar" onclick="abrirPerfil()">Editar Perfil</button> 
            </div>
            
            <table class="tabla-mes">
                <thead>
                    <tr>
                        <th>LU</th><th>MA</th><th>MI</th><th>JU</th><th>VI</th><th>SÁ</th><th>DO</th>
                    </tr>
                </thead>
                <tbody style="text-align:center">
                    <tr>
                        <td style="color:#ccc">26</td><td style="color:#ccc">27</td><td style="color:#ccc">28</td><td style="color:#ccc">29</td><td style="color:#ccc">30</td><td style="color:#ccc">31</td><td>1</td>
                    </tr>
                    <tr>
                        <td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td>
                    </tr>
                    <tr>
                        <td>9</td><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td>
                    </tr>
                    <tr>
                        <td>16</td><td>17</td><td>18</td><td>19</td><td>20</td><td>21</td><td>22</td>
                    </tr>
                    <tr>
                        <td class="periodo">23</td><td class="periodo">24</td><td class="periodo">25</td><td class="periodo">26</td><td class="periodo">27</td><td class="periodo">28</td><td>1</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <aside>
            <div class="tarjeta-info">
                <h4 style="margin:0; color:var(--secundario)">Resumen Admin</h4>
                <h3 style="margin:5px 0">Menstruación Activa</h3>
                <small>Sistema funcionando correctamente</small>
            </div>

            <div class="tarjeta-info" style="border-left-color: #4caf50;">
                <h4 style="margin:0">Próxima Predicción</h4>
                <p><strong>24 de marzo, 2026</strong></p>
            </div>

            <div class="tarjeta-info" style="border-left-color: #9c27b0;">
                <h4 style="margin:0">Día Fértil</h4>
                <p><strong>10 de marzo</strong></p>
            </div>
        </aside>
    </main>
</div>

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

        <div class="perfil-avatar-seccion" style="text-align:center; margin: 20px 0;">
            <div class="circulo-avatar" style="font-size: 40px; background:#f0f0f0; width:80px; height:80px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin: 0 auto;">👤</div>
            <button class="btn-avatar-link" style="background:none; border:none; color:#e91e63; cursor:pointer; margin-top:10px;">Crear Avatar Personalizado</button>
        </div>

        <form class="form-grid" action="calendarioAdmin.php" method="POST">
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
                <textarea placeholder="Cuéntanos sobre ti..." style="width:100%; border-radius:8px; border:1px solid #ddd; padding:10px;"></textarea>
            </div>
            <div class="acciones">
                <button type="submit" class="guardar">Guardar Cambios</button>
                <button type="button" class="cancelar" onclick="cerrarPerfil()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function abrirPerfil() {
        document.getElementById('modalPerfil').style.display = 'flex';
    }

    function cerrarPerfil() {
        document.getElementById('modalPerfil').style.display = 'none';
    }
</script>

</body>
</html>