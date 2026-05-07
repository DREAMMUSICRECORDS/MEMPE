<?php
session_start();
require_once 'conexion.php';

// 1. Verificación de seguridad[cite: 3, 8]
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];
$conn = conectar();

// 2. Carga de datos del usuario desde la DB actualizada
$sql = "SELECT nombre_completo, correo, telefono, biografia FROM usuarios WHERE id = $id_usuario";
$res = $conn->query($sql);
$user_data = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEMPE - Dashboard</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        :root {
            --p-rosa: #ff4d8d;
            --p-morado: #7b2cbf;
            --glass: rgba(255, 255, 255, 0.8);
        }
        body {
            background: linear-gradient(135deg, #fce4ec 0%, #f3e5f5 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .contenedor-principal {
            width: 95%;
            max-width: 1100px;
            background: var(--glass);
            backdrop-filter: blur(15px);
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.3);
        }
        .header-app {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .perfil-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .foto-perfil {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        .foto-perfil:hover { transform: scale(1.1); }
        
        .nav-modos {
            display: flex;
            background: rgba(0,0,0,0.05);
            padding: 5px;
            border-radius: 50px;
            gap: 5px;
        }
        .btn-tab {
            padding: 10px 25px;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            background: transparent;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-tab.active {
            background: white;
            color: var(--p-rosa);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn-logout {
            background: #ff4d4d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 15px;
            cursor: pointer;
            font-weight: bold;
        }
        .calendario-card {
            background: white;
            border-radius: 25px;
            padding: 25px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }
        .grid-dias {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-top: 20px;
        }
        .dia-caja {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border-radius: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: 0.2s;
        }
        .dia-caja:hover { background: var(--p-rosa); color: white; }
        .dia-caja.hoy { background: var(--p-morado); color: white; }

        .zona-embarazo {
            display: none;
            animation: fadeIn 0.5s;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>

<div class="contenedor-principal">
    <div class="header-app">
        <div class="perfil-info">
            <div class="foto-perfil" onclick="document.getElementById('subir-foto').click()">
                🌸
                <input type="file" id="subir-foto" style="display:none">
            </div>
            <div>
                <h2 style="margin:0; color: var(--p-morado);">¡Hola, <?php echo explode(' ', $user_data['nombre_completo'])[0]; ?>!</h2>
                <p style="margin:0; color: #888; font-size: 0.9em;">Panel de Control MEMPE</p>
            </div>
        </div>
        
        <div class="nav-modos">
            <button id="tab-p" class="btn-tab active" onclick="cambiarVista('periodo')">Periodo</button>
            <button id="tab-e" class="btn-tab" onclick="cambiarVista('embarazo')">Embarazo</button>
        </div>

        <button class="btn-logout" onclick="window.location.href='logout.php'">Cerrar Sesión</button>
    </div>

    <!-- VISTA PERIODO -->
    <div id="vista-periodo" class="calendario-card">
        <div style="display:flex; justify-content: space-between; align-items:center;">
            <h3 id="nombre-mes" style="margin:0; color: var(--p-rosa);">Mes Año</h3>
            <div>
                <button class="btn-tab" onclick="moverMes(-1)">◀</button>
                <button class="btn-tab" onclick="moverMes(1)">▶</button>
            </div>
        </div>
        <div class="grid-dias" id="contenedor-calendario"></div>
        <button class="btn-logout" style="width:100%; margin-top:20px; background:var(--p-rosa)">Guardar Cambios</button>
    </div>

    <!-- VISTA EMBARAZO -->
    <div id="vista-embarazo" class="zona-embarazo">
        <div class="calendario-card" style="border-left: 10px solid #a2d2ff;">
            <h3 style="color: #0077b6;">🤰 Seguimiento de Embarazo</h3>
            <p>Estado: <strong>Desarrollo Normal</strong></p>
            <div style="background:#eee; height:15px; border-radius:10px; overflow:hidden; margin: 15px 0;">
                <div style="background: linear-gradient(to right, #ff4d8d, #a2d2ff); width: 45%; height:100%;"></div>
            </div>
            <p style="font-size:0.9em; color:#555;">Vas por la <strong>Semana 18</strong>. ¡Tu bebé tiene el tamaño de un camote!</p>
            <button class="btn-tab" style="background:#a2d2ff; width:100%;">Registrar Síntoma</button>
        </div>
    </div>
</div>

<script>
let fecha = new Date();

function generarCalendario() {
    const contenedor = document.getElementById('contenedor-calendario');
    const labelMes = document.getElementById('nombre-mes');
    contenedor.innerHTML = '';

    const mes = fecha.getMonth();
    const año = fecha.getFullYear();
    const nombresMeses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    
    labelMes.innerText = `${nombresMeses[mes]} ${año}`;

    const primerDia = new Date(año, mes, 1).getDay();
    const diasMes = new Date(año, mes + 1, 0).getDate();

    for(let i=0; i<primerDia; i++) contenedor.innerHTML += `<div></div>`;

    for(let d=1; d<=diasMes; d++) {
        const esHoy = (d === new Date().getDate() && mes === new Date().getMonth() && año === new Date().getFullYear()) ? 'hoy' : '';
        contenedor.innerHTML += `<div class="dia-caja ${esHoy}">${d}</div>`;
    }
}

function moverMes(n) {
    fecha.setMonth(fecha.getMonth() + n);
    generarCalendario();
}

function cambiarVista(modo) {
    const vP = document.getElementById('vista-periodo');
    const vE = document.getElementById('vista-embarazo');
    const tP = document.getElementById('tab-p');
    const tE = document.getElementById('tab-e');

    if(modo === 'embarazo') {
        vP.style.display = 'none';
        vE.style.display = 'block';
        tE.classList.add('active');
        tP.classList.remove('active');
    } else {
        vP.style.display = 'block';
        vE.style.display = 'none';
        tP.classList.add('active');
        tE.classList.remove('active');
    }
}

generarCalendario();
</script>
</body>
</html>