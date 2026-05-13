<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];
$conn = conectar();

// Consulta de datos del usuario incluyendo el ROL
$res = $conn->query("SELECT nombre_completo, correo, biografia, foto, rol FROM usuarios WHERE id = $id_usuario");
$user_data = $res->fetch_assoc();

$foto_perfil = !empty($user_data['foto']) ? "uploads/" . $user_data['foto'] : "https://cdn-icons-png.flaticon.com/512/3135/3135715.png";
$es_admin = ($user_data['rol'] === 'admin');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEMPE - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --p-rosa: #ff4d8d; --p-morado: #7b2cbf; --blanco: #ffffff; --shadow: 0 10px 40px rgba(0,0,0,0.08); }
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #fdf6ff 0%, #e1bee7 100%); margin: 0; padding: 10px; display: flex; justify-content: center; min-height: 100vh; }
        .contenedor-app { width: 100%; max-width: 500px; position: relative; }
        
        /* HEADER */
        .header-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-perfil-abrir { background: white; border: 2px solid white; width: 50px; height: 50px; border-radius: 50%; cursor: pointer; box-shadow: var(--shadow); overflow: hidden; }
        .btn-perfil-abrir img { width: 100%; height: 100%; object-fit: cover; }

        /* PANEL PERFIL */
        .panel-perfil { position: fixed; top: 0; right: -100%; width: 100%; max-width: 400px; height: 100%; background: white; z-index: 1000; box-shadow: -10px 0 30px rgba(0,0,0,0.1); transition: 0.4s; padding: 30px; box-sizing: border-box; overflow-y: auto; }
        .panel-perfil.abierto { right: 0; }

        /* NAVEGACIÓN TABS */
        .tabs-navegacion { display: flex; background: rgba(255,255,255,0.5); padding: 5px; border-radius: 50px; margin-bottom: 20px; }
        .tab-nav { flex: 1; padding: 12px; border-radius: 40px; border: none; background: transparent; font-weight: 600; color: var(--p-morado); cursor: pointer; }
        .tab-nav.activo { background: var(--p-morado); color: white; }

        /* TARJETAS */
        .card { background: white; border-radius: 25px; padding: 20px; margin-bottom: 15px; box-shadow: var(--shadow); }
        .input-moderno { width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #eee; margin: 8px 0; box-sizing: border-box; font-family: inherit; }
        .btn-accion { background: var(--p-morado); color: white; border: none; padding: 12px; border-radius: 12px; cursor: pointer; width: 100%; font-weight: 600; }
        
        /* CALENDARIO PERIODO */
        .grid-calendario { display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px; margin-top: 15px; text-align: center; }
        .dia { aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: 10px; background: #fafafa; font-size: 0.9rem; }
        .dia-predicho { background: var(--p-rosa); color: white; font-weight: bold; }

        /* DISEÑO EMBARAZO */
        .hero-embarazo { text-align: center; padding: 30px; background: linear-gradient(135deg, #7b2cbf, #9d4edd); color: white; border-radius: 25px; margin-bottom: 15px; }
        .cita-item { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f0f0f0; padding: 10px 0; }
        .btn-borrar { color: #ff4d4d; border: none; background: none; cursor: pointer; font-size: 0.8rem; }
        
        /* BOTÓN ADMIN */
        .btn-admin { display: block; background: #333; color: white; text-align: center; padding: 15px; border-radius: 15px; text-decoration: none; font-weight: 600; margin-top: 20px; }
    </style>
</head>
<body>

<div id="panelPerfil" class="panel-perfil">
    <button onclick="togglePerfil()" style="float:right; border:none; background:none; font-size:1.5rem; cursor:pointer;">✕</button>
    <h2 style="color: var(--p-morado);">Mi Cuenta</h2>
    
    <form action="actualizar_perfil.php" method="POST" enctype="multipart/form-data">
        <center>
            <img src="<?php echo $foto_perfil; ?>" style="width:110px; height:110px; border-radius:50%; object-fit:cover; border:3px solid var(--p-morado);">
            <br>
            <label style="font-size:0.8rem; color:var(--p-morado); cursor:pointer; text-decoration:underline;">
                Cambiar foto
                <input type="file" name="foto_perfil" style="display:none;" onchange="this.form.submit()">
            </label>
        </center>
        <br>
        <label>Nombre</label>
        <input type="text" name="nuevo_nombre" class="input-moderno" value="<?php echo htmlspecialchars($user_data['nombre_completo']); ?>">
        <label>Correo</label>
        <input type="email" name="nuevo_correo" class="input-moderno" value="<?php echo htmlspecialchars($user_data['correo']); ?>">
        <label>Sobre mí</label>
        <textarea name="biografia" class="input-moderno" placeholder="Escribe algo sobre ti..."><?php echo htmlspecialchars($user_data['biografia']); ?></textarea>
        
        <button type="submit" class="btn-accion">Guardar Cambios</button>
    </form>

    <?php if ($es_admin): ?>
        <a href="admin.php" class="btn-admin">⚙️ Panel Administrador</a>
    <?php endif; ?>

    <div style="margin-top: 30px; text-align: center;">
        <a href="logout.php" style="color: #ff4d4d; text-decoration: none; font-size: 0.9rem;">Cerrar Sesión</a>
    </div>
</div>

<div class="contenedor-app">
    <div class="header-top">
        <h2 style="margin:0; color: var(--p-morado);">MEMPE</h2>
        <button class="btn-perfil-abrir" onclick="togglePerfil()">
            <img src="<?php echo $foto_perfil; ?>">
        </button>
    </div>

    <div class="tabs-navegacion">
        <button class="tab-nav activo" id="btn-per" onclick="cambiarModo('periodo')">Menstruación</button>
        <button class="tab-nav" id="btn-emb" onclick="cambiarModo('embarazo')">Embarazo</button>
    </div>

    <div id="vista-periodo">
        <div class="card" style="border: 1px dashed var(--p-rosa);">
            <div style="display:flex; gap:10px;">
                <input type="date" id="fur-p" class="input-moderno" onchange="calcP()">
                <input type="number" id="ciclo" value="28" class="input-moderno" style="width:80px;" onchange="calcP()">
            </div>
        </div>
        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <button onclick="muev(-1)" style="border:none; cursor:pointer; background:none; font-size:1.2rem;">❮</button>
                <b id="mes-txt" style="color: var(--p-morado);"></b>
                <button onclick="muev(1)" style="border:none; cursor:pointer; background:none; font-size:1.2rem;">❯</button>
            </div>
            <div class="grid-calendario" id="grid-p"></div>
        </div>
    </div>

    <div id="vista-embarazo" style="display:none;">
        <div class="card" style="border: 1px dashed var(--p-morado);">
            <label style="font-size:0.8rem;">Fecha inicio embarazo (FUR):</label>
            <input type="date" id="fur-e" class="input-moderno" onchange="calcE()">
        </div>
        
        <div class="hero-embarazo">
            <h1 id="sem-txt" style="font-size:4.5rem; margin:0;">--</h1>
            <p id="tri-txt">Calculando semanas...</p>
        </div>

        <div class="card">
            <h4 style="margin:0 0 10px 0; color: var(--p-morado);">Agendar Nueva Cita</h4>
            <input type="text" id="cita-titulo" class="input-moderno" placeholder="Ej: Control con Ginecólogo">
            <input type="datetime-local" id="cita-fecha" class="input-moderno">
            <button onclick="agendarCita()" class="btn-accion">Guardar Cita</button>
        </div>

        <div class="card">
            <h4 style="margin:0 0 10px 0; color: var(--p-morado);">Próximas Citas</h4>
            <div id="lista-citas"></div>
        </div>
    </div>
</div>

<script>
let fPeriodo = [];
let fHoy = new Date();

function togglePerfil() { document.getElementById('panelPerfil').classList.toggle('abierto'); }

function cambiarModo(m) {
    document.getElementById('vista-periodo').style.display = m === 'periodo' ? 'block' : 'none';
    document.getElementById('vista-embarazo').style.display = m === 'embarazo' ? 'block' : 'none';
    document.getElementById('btn-per').classList.toggle('activo', m === 'periodo');
    document.getElementById('btn-emb').classList.toggle('activo', m === 'embarazo');
}

// LÓGICA CALENDARIO
function calcP() {
    const fur = document.getElementById('fur-p').value;
    const dur = parseInt(document.getElementById('ciclo').value) || 28;
    if(!fur) return;
    fPeriodo = [];
    let s = new Date(fur);
    s.setMinutes(s.getMinutes() + s.getTimezoneOffset());
    for(let i=0; i<365; i+=dur) {
        let p = new Date(s);
        p.setDate(s.getDate() + i);
        fPeriodo.push(p.toDateString());
    }
    render();
}

function render() {
    const g = document.getElementById('grid-p');
    const l = document.getElementById('mes-txt');
    g.innerHTML = "";
    const mes = fHoy.getMonth();
    const año = fHoy.getFullYear();
    const meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
    l.innerText = `${meses[mes]} ${año}`;
    const pD = new Date(año, mes, 1).getDay();
    const tD = new Date(año, mes + 1, 0).getDate();
    for(let i=0; i<pD; i++) g.innerHTML += `<div></div>`;
    for(let d=1; d<=tD; d++) {
        const act = new Date(año, mes, d).toDateString();
        const sel = fPeriodo.includes(act) ? 'dia-predicho' : '';
        g.innerHTML += `<div class="dia ${sel}">${d}</div>`;
    }
}

// LÓGICA EMBARAZO
function calcE() {
    const furInput = document.getElementById('fur-e').value;
    if(!furInput) return;
    let inicio = new Date(furInput);
    inicio.setMinutes(inicio.getMinutes() + inicio.getTimezoneOffset());
    let semanas = Math.floor((new Date() - inicio) / (1000 * 60 * 60 * 24 * 7));
    document.getElementById('sem-txt').innerText = semanas >= 0 ? semanas : "0";
    document.getElementById('tri-txt').innerText = semanas < 13 ? "Primer Trimestre" : (semanas < 27 ? "Segundo Trimestre" : "Tercer Trimestre");
}

// GESTIÓN DE CITAS
function agendarCita() {
    const tit = document.getElementById('cita-titulo').value;
    const fec = document.getElementById('cita-fecha').value;
    if(!tit || !fec) return alert("Por favor, completa los datos de la cita.");
    const fd = new FormData(); fd.append('titulo', tit); fd.append('fecha', fec);
    fetch('guardar_cita.php', { method: 'POST', body: fd }).then(() => {
        document.getElementById('cita-titulo').value = "";
        document.getElementById('cita-fecha').value = "";
        cargarCitas();
    });
}

function cargarCitas() {
    fetch('obtener_citas.php').then(r => r.json()).then(data => {
        const div = document.getElementById('lista-citas');
        div.innerHTML = data.length ? "" : "<p style='font-size:0.8rem; color:#999;'>No hay citas guardadas.</p>";
        data.forEach(c => {
            const fechaLabel = new Date(c.fecha_cita).toLocaleString('es-CO', { day:'numeric', month:'short', hour:'2-digit', minute:'2-digit'});
            div.innerHTML += `
                <div class="cita-item">
                    <div><b>${c.titulo}</b><br><small style="color:var(--p-morado);">${fechaLabel}</small></div>
                    <button class="btn-borrar" onclick="borrarCita(${c.id})">Eliminar</button>
                </div>`;
        });
    });
}

function borrarCita(id) {
    if(confirm("¿Estás segura de eliminar esta cita?")) {
        fetch('borrar_cita.php?id='+id).then(() => cargarCitas());
    }
}

function muev(n) { fHoy.setMonth(fHoy.getMonth() + n); render(); }
window.onload = () => { render(); cargarCitas(); };
</script>
</body>
</html>