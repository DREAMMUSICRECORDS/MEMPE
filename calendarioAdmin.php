<?php
require_once 'conexion.php'; 

$id_usuario = 1;

$datos_usuario = [
    'nombre_completo' => 'Hellen (Modo Prueba)',
    'correo' => 'hellen.prueba@email.com',
    'telefono' => '+57 300 123 4567',
    'fecha_nacimiento' => '1998-08-20',
    'biografia' => 'Esta es una biografía de prueba porque no hay base de datos.'
];

if (!$datos_usuario) {
    echo "Error: Usuario no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración - Mi Calendario Mi Mempe</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .tabla-mes td { cursor: pointer; position: relative; }
        .tabla-mes td:hover:not(.vacio) { background-color: #f0f0f0; }
        .tabla-mes td.vacio { cursor: default; background-color: transparent !important; }
        .tabla-mes td.hoy { border: 2px solid var(--primario); font-weight: bold; }
        .tabla-mes td.periodo { background-color: var(--secundario) !important; color: white; }
        .tabla-mes td.prediccion { background-color: #ffc1e3 !important; color: #4a148c; }
        .navegacion-mes { display: flex; align-items: center; gap: 10px; }
        .btn-nav { background: #eee; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-nav:hover { background: #ddd; }
        textarea#biografia { width: 100%; height: 100px; border-radius: 8px; border: 1px solid #eee; background: #f4f4f4; padding: 12px; box-sizing: border-box; font-family: inherit; font-size: 14px; }

        .user-avatar-container { display: flex; align-items: center; gap: 15px; }
        .circulo-avatar { width: 40px; height: 40px; background-color: #f0f0f0; background-size: cover; background-position: center; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #999; overflow: hidden; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        #modalPerfil .circulo-avatar { width: 100px; height: 100px; font-size: 50px; margin: 0 auto 15px; }

        .tabs { display: flex; gap: 10px; border-bottom: 2px solid #eee; margin-bottom: 20px; }
        .tab-modal { background: none; border: none; padding: 10px 20px; cursor: pointer; font-weight: bold; color: #666; border-bottom: 2px solid transparent; transition: 0.3s; }
        .tab-modal.activo { color: var(--primario); border-bottom-color: var(--primario); }
        .tab-content { display: none; }
        .tab-content.activo { display: block; }

        .perfil-avatar-seccion { text-align: center; padding: 20px 0; }
        .btn-subir-avatar { background-color: #eee; color: #333; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; margin-top: 10px; display: inline-block; transition: 0.3s; }
        .btn-subir-avatar:hover { background-color: #ddd; }
        #input-file-avatar, #input-file-panza { display: none; }

        .selector-modo {
            display: flex;
            background-color: #f0f0f0;
            border-radius: 20px;
            padding: 5px;
            gap: 5px;
            margin-left: 20px;
        }

        .btn-modo {
            border: none;
            padding: 8px 15px;
            border-radius: 15px;
            cursor: pointer;
            font-weight: bold;
            color: #666;
            background: transparent;
            transition: 0.3s;
        }

        .btn-modo.activo {
            background-color: white;
            color: var(--primario);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        #panel-periodo, #panel-embarazo {
            display: none; 
        }

        #panel-periodo.activo, #panel-embarazo.activo {
            display: block;
        }

        .embarazo-dashboard {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .baby-size-card {
            text-align: center;
            background: linear-gradient(135deg, #e1bee7 0%, #fdf6ff 100%);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .baby-icon {
            font-size: 80px;
            margin: 10px 0;
            display: block;
        }

        .embarazo-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info-mini-card {
            background: white;
            padding: 15px;
            border-radius: 12px;
            border-left: 4px solid var(--primario);
        }

        .seccion-embarazo {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .form-sintomas, .form-citas {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-sintomas input, .form-sintomas select, .form-sintomas textarea,
        .form-citas input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #eee;
            background: #f4f4f4;
            box-sizing: border-box;
        }

        .lista-items {
            list-style: none;
            padding: 0;
            margin-top: 15px;
            max-height: 200px;
            overflow-y: auto;
        }

        .lista-items li {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 5px;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
        }

        .panza-fotos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }

        .foto-panza {
            width: 100%;
            padding-bottom: 100%; 
            background-color: #f0f0f0;
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            position: relative;
        }
        
    </style>
</head>
<body>

<div class="contenedor-dashboard">
    <header class="header-app">
        <div style="display: flex; align-items: center;">
            <div class="user-avatar-container">
                <div class="circulo-avatar" id="header-avatar-img">👤</div>
                <div class="logo">
                    <h1 style="margin:0">❤️ MI MEMPE</h1>
                </div>
            </div>
            <div class="selector-modo">
                <button class="btn-modo activo" id="btn-modo-periodo" onclick="cambiarModoPrincipal('periodo')">Modo Periodo</button>
                <button class="btn-modo" id="btn-modo-embarazo" onclick="cambiarModoPrincipal('embarazo')">Modo Embarazo</button>
            </div>
        </div>
        <div style="display: flex; gap: 10px;">
            <button class="volver" onclick="location.href='index.php'">Ir al Inicio</button>
            <button class="btn-accion" style="width:auto; padding: 10px 20px;" onclick="location.href='index.php'">Cerrar Sesión</button>
        </div>
    </header>

    <div id="panel-periodo" class="activo">
        <main class="grid-principal">
            <section class="card">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                    <div style="display:flex; align-items:center; gap: 15px;">
                        <h2 style="margin:0" id="titulo-mes">Cargando...</h2>
                        <div class="navegacion-mes">
                            <button class="btn-nav" onclick="cambiarMes(-1)">❮ Ant</button>
                            <button class="btn-nav" onclick="cambiarMes(1)">Sig ❯</button>
                        </div>
                    </div>
                    <button class="btn-editar" onclick="abrirPerfil()">Editar Perfil</button> 
                </div>
                
                <div id="contenedor-calendario"></div>
                
                <div style="margin-top: 15px; font-size: 0.9rem; color: #666; display:flex; gap: 15px; justify-content: center;">
                    <div><span style="display:inline-block; width:15px; height:15px; background:var(--secundario); border-radius:3px; vertical-align:middle;"></span> Periodo Real</div>
                    <div><span style="display:inline-block; width:15px; height:15px; background:#ffc1e3; border-radius:3px; vertical-align:middle;"></span> Predicción</div>
                </div>
            </section>

            <aside>
                <div class="tarjeta-info">
                    <h4 style="margin:0; color:var(--secundario)">Resumen Admin</h4>
                    <h3 style="margin:5px 0" id="estado-periodo">Calculando...</h3>
                    <small>Modo prueba: Haz clic para ver cómo se pinta, pero no se guardará.</small>
                </div>

                <div class="tarjeta-info" style="border-left-color: #4caf50;">
                    <h4 style="margin:0">Próxima Predicción</h4>
                    <p><strong id="fecha-proxima-prediccion">--</strong></p>
                </div>
            </aside>
        </main>
    </div>

    <div id="panel-embarazo">
        <main class="embarazo-dashboard">
            <section>
                <div class="baby-size-card">
                    <h2 style="margin:0; color: var(--texto);">¡Hellen, estás embarazada!</h2>
                    <p style="margin: 5px 0 15px 0; color: #666;">Estamos en el <strong id="embarazo-trimestre">--</strong> trimestre.</p>
                    <span class="baby-icon" id="baby-fruit-icon">🍊</span>
                    <h3 style="margin:0;">Tu bebé tiene el tamaño de un <span id="baby-fruit-name">--</span></h3>
                    <p style="font-size: 14px; color: #777;">Aproximadamente <strong id="baby-length">--</strong> y <strong id="baby-weight">--</strong></p>
                </div>

                <div class="seccion-embarazo">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                        <h3 style="margin:0;">Dolores y Síntomas</h3>
                        <button class="btn-subir-avatar" style="margin:0; background:var(--primario); color:white;" onclick="abrirModalSintoma()">+ Registrar Dolor</button>
                    </div>
                    <ul class="lista-items" id="lista-sintomas-simulada">
                        <li><span>Náuseas matutinas</span> <small>12 Feb</small></li>
                        <li><span>Dolor lumbar bajo</span> <small>10 Feb</small></li>
                        <li><span>Acidez</span> <small>09 Feb</small></li>
                    </ul>
                </div>

                <div class="seccion-embarazo">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                        <h3 style="margin:0;">Fotos de tu Pancita</h3>
                        <input type="file" id="input-file-panza" accept="image/*">
                        <button class="btn-subir-avatar" style="margin:0; background:var(--primario); color:white;" onclick="document.getElementById('input-file-panza').click()">+ Subir Foto</button>
                    </div>
                    <div class="panza-fotos-grid" id="fotos-panza-grid-simulada">
                    </div>
                </div>

            </section>

            <aside>
                <div class="embarazo-info-grid">
                    <div class="info-mini-card">
                        <h4 style="margin:0; color:var(--secundario);">Tiempo</h4>
                        <p style="margin:5px 0; font-size: 1.2rem;">Semanas: <strong id="embarazo-semanas">--</strong></p>
                        <p style="margin:0; font-size: 0.9rem;">Meses: <strong id="embarazo-meses">--</strong></p>
                    </div>
                    <div class="info-mini-card">
                        <h4 style="margin:0; color:var(--secundario);">Cuenta Regresiva</h4>
                        <p style="margin:5px 0; font-size: 1.2rem;">Faltan: <strong id="embarazo-cuenta-regresiva">-- días</strong></p>
                        <p style="margin:0; font-size: 0.9rem;">Parto: <strong id="embarazo-fecha-parto">--</strong></p>
                    </div>
                </div>

                <div class="seccion-embarazo" style="margin-top: 20px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                        <h3 style="margin:0;">Citas Médicas</h3>
                        <button class="btn-subir-avatar" style="margin:0; background:var(--secundario); color:white;" onclick="abrirModalCita()">+ Asignar Cita</button>
                    </div>
                    <ul class="lista-items" id="lista-citas-simulada">
                        <li style="border-left: 3px solid #4caf50;"><span>Ecografía 20 semanas</span> <small>22 Mar, 10:00</small></li>
                        <li style="border-left: 3px solid #ff9800;"><span>Control Prenatal</span> <small>28 Feb, 15:30</small></li>
                    </ul>
                </div>

                <div class="tarjeta-info" style="border-left-color: var(--texto); background:#eee; margin-top:20px;">
                    <h4 style="margin:0">Información</h4>
                    <small>Modo prueba: Los datos de embarazo son simulados y se guardan temporalmente en tu navegador.</small>
                    <button class="btn-nav" style="width:100%; margin-top:10px; background:#f4f4f4; color: var(--primario);" onclick="abrirPerfil()">Editar Perfil / Avatar</button>
                </div>
            </aside>
        </main>
    </div>

</div>

<div class="overlay" id="modalPerfil" style="display: none;">
    <div class="modal">
        <div class="modal-header">
            <h2>Configuración de Perfil</h2>
            <p>Actualiza tu información personal</p>
            <span class="cerrar" onclick="cerrarPerfil()">✕</span>
        </div>

        <div class="tabs">
            <button class="tab-modal activo" onclick="cambiarTabModal('perfil')">Perfil Personal</button>
            <button class="tab-modal" onclick="cambiarTabModal('avatar')">Avatar</button>
        </div>

        <div id="tab-perfil-content" class="tab-content activo">
            <form class="form-grid" action="" method="POST" onsubmit="alert('Hiciste clic en Guardar Perfil (Simulado)'); return false;">
                <div class="campo">
                    <label>Nombre Completo</label>
                    <input type="text" name="nuevo_nombre" required value="<?php echo htmlspecialchars($datos_usuario['nombre_completo']); ?>">
                </div>
                <div class="campo">
                    <label>Correo Electrónico</label>
                    <input type="email" name="nuevo_correo" required value="<?php echo htmlspecialchars($datos_usuario['correo']); ?>">
                </div>
                <div class="campo">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" value="<?php echo htmlspecialchars($datos_usuario['telefono']); ?>">
                </div>
                <div class="campo">
                    <label>Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" value="<?php echo htmlspecialchars($datos_usuario['fecha_nacimiento']); ?>">
                </div>
                <div class="campo full">
                    <label>Biografía</label>
                    <textarea id="biografia" name="biografia"><?php echo htmlspecialchars($datos_usuario['biografia']); ?></textarea>
                </div>
                <div class="acciones">
                    <button type="submit" class="guardar">Guardar Cambios</button>
                    <button type="button" class="cancelar" onclick="cerrarPerfil()">Cancelar</button>
                </div>
            </form>
        </div>

        <div id="tab-avatar-content" class="tab-content">
            <div class="perfil-avatar-seccion">
                <div class="circulo-avatar" id="modal-avatar-img">👤</div>
                <p style="font-size: 14px; color: #666; margin-bottom: 15px;">Sube una imagen cuadrada (JPG o PNG) para usar como tu avatar.</p>
                <input type="file" id="input-file-avatar" accept="image/jpeg, image/png">
                <button class="btn-subir-avatar" onclick="document.getElementById('input-file-avatar').click()">Seleccionar Imagen</button>
                <button class="btn-subir-avatar" style="background-color: #ffcdd2; color: #c62828; margin-left: 10px;" onclick="borrarAvatarSimulado()">Borrar</button>
                <div class="acciones" style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                    <button type="button" class="guardar" onclick="alert('Avatar actualizado visualmente (Simulado)'); cerrarPerfil();">Finalizar</button>
                    <button type="button" class="cancelar" onclick="cerrarPerfil()">Cancelar</button>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="overlay" id="modalSintoma" style="display: none;">
    <div class="modal" style="max-width: 400px;">
        <div class="modal-header">
            <h3>Registrar Dolor / Síntoma</h3>
            <span class="cerrar" onclick="cerrarModalSintoma()">✕</span>
        </div>
        <form class="form-sintomas" onsubmit="alert('Síntoma registrado visualmente (Simulado)'); cerrarModalSintoma(); return false;">
            <label>Tipo de Síntoma</label>
            <select required>
                <option value="">Selecciona uno...</option>
                <option>Nauseas / Vómitos</option>
                <option>Dolor Lumbar / Espalda</option>
                <option>Dolor Pélvico / Pubalgia</option>
                <option>Dolor de Cabeza</option>
                <option>Cansancio Extremo</option>
                <option>Acidez / Reflujo</option>
                <option>Hinchazón / Retención</option>
            </select>
            <label>Notas adicionales (Opcional)</label>
            <textarea placeholder="Ej: Fue intenso por la mañana"></textarea>
            <button type="submit" class="guardar" style="background:var(--primario)">Guardar Síntoma</button>
        </form>
    </div>
</div>

<div class="overlay" id="modalCita" style="display: none;">
    <div class="modal" style="max-width: 400px;">
        <div class="modal-header">
            <h3>Asignar Cita Médica</h3>
            <span class="cerrar" onclick="cerrarModalCita()">✕</span>
        </div>
        <form class="form-citas" onsubmit="alert('Cita asignada visualmente (Simulado)'); cerrarModalCita(); return false;">
            <label>Tipo de Cita / Doctor</label>
            <input type="text" placeholder="Ej: Dr. García - Control Prenatal" required>
            <label>Fecha</label>
            <input type="date" required value="2026-02-28">
            <label>Hora</label>
            <input type="time" required value="10:00">
            <button type="submit" class="guardar" style="background:var(--secundario)">Guardar Cita</button>
        </form>
    </div>
</div>

<script>
    let fechaReferencia = new Date(); 
    let fechasPeriodoReal = ['2026-02-15', '2026-02-16', '2026-02-17']; 
    const nombresMeses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    const fechaInicioEmbarazo = new Date('2025-10-01T00:00:00'); 
    
    const guiaTamañosBebe = {
        8: { fruta: '🍊', nombre: 'Mandarina', largo: '1.6 cm', peso: '1 g' },
        12: { fruta: '🍋', nombre: 'Limón', largo: '5.4 cm', peso: '14 g' },
        16: { fruta: '🥑', nombre: 'Aguacate', largo: '11.6 cm', peso: '100 g' },
        20: { fruta: '🍌', nombre: 'Plátano', largo: '25.6 cm', peso: '300 g' },
        24: { fruta: '🌽', nombre: 'Mazorca de Maíz', largo: '30 cm', peso: '600 g' },
        28: { fruta: '🍆', nombre: 'Berenjena', largo: '37.6 cm', peso: '1 kg' },
        32: { fruta: '🎃', nombre: 'Calabaza mediana', largo: '42.4 cm', peso: '1.7 kg' },
        36: { fruta: '🍈', nombre: 'Melón', largo: '47.4 cm', peso: '2.6 kg' },
        40: { fruta: '🍉', nombre: 'Sandía', largo: '51.2 cm', peso: '3.5 kg' }
    };

    function inicializar() {
        renderizarCalendario(); 
        cargarAvatarSimulado(); 
        cargarModoPrincipal(); 
    }

    function cambiarModoPrincipal(modo) {
        try {
            localStorage.setItem('mempe_modo_activo', modo);
        } catch(e) { console.error("Error localStorage lleno"); }
        aplicarModoVisible(modo);
    }

    function cargarModoPrincipal() {
        let modoGuardado = 'periodo';
        try {
            modoGuardado = localStorage.getItem('mempe_modo_activo') || 'periodo'; 
        } catch(e) { console.error("Error localStorage bloqueado"); }
        aplicarModoVisible(modoGuardado);
    }

    function aplicarModoVisible(modo) {
        let btnP = document.getElementById('btn-modo-periodo');
        let btnE = document.getElementById('btn-modo-embarazo');
        let panelP = document.getElementById('panel-periodo');
        let panelE = document.getElementById('panel-embarazo');

        if(!btnP || !btnE || !panelP || !panelE) return;

        btnP.classList.remove('activo');
        btnE.classList.remove('activo');
        panelP.classList.remove('activo');
        panelE.classList.remove('activo');

        if (modo === 'periodo') {
            btnP.classList.add('activo');
            panelP.classList.add('activo');
            renderizarCalendario(); 
        } else {
            btnE.classList.add('activo');
            panelE.classList.add('activo');
            inicializarEmbarazoSimulado(); 
        }
    }

    function inicializarEmbarazoSimulado() {
        try {
            const hoy = new Date();
            const diferenciaTiempo = hoy - fechaInicioEmbarazo;
            if (diferenciaTiempo < 0) { cambiarModoPrincipal('periodo'); return; }

            const diasTotales = Math.floor(diferenciaTiempo / (1000 * 60 * 60 * 24));
            const semanasActuales = Math.floor(diasTotales / 7);
            const diasRestantesSemana = diasTotales % 7;
            const mesesActuales = (diasTotales / 30.41).toFixed(1);

            document.getElementById('embarazo-semanas').innerText = `${semanasActuales}s + ${diasRestantesSemana}d`;
            document.getElementById('embarazo-meses').innerText = `${mesesActuales}`;

            let trimestre = (semanasActuales < 13) ? "1er" : (semanasActuales < 27) ? "2do" : "3er";
            document.getElementById('embarazo-trimestre').innerText = trimestre;

            const fechaParto = new Date(fechaInicioEmbarazo);
            fechaParto.setDate(fechaParto.getDate() + 280);
            document.getElementById('embarazo-fecha-parto').innerText = fechaParto.toLocaleDateString('es-ES', { day: 'numeric', month: 'long', year: 'numeric' });

            const diasParaParto = Math.max(0, Math.ceil((fechaParto - hoy) / (1000 * 60 * 60 * 24)));
            document.getElementById('embarazo-cuenta-regresiva').innerText = `${diasParaParto} días`;

            actualizarTamañoBebeFruta(semanasActuales);
            cargarFotosPanzaSimuladas();
        } catch(e) {
            console.error("Error embarazo simulado, volviendo a periodo", e);
            cambiarModoPrincipal('periodo');
        }
    }

    function actualizarTamañoBebeFruta(semanas) {
        let t = { fruta: '🌱', nombre: 'Embrión p.', largo: '-- cm', peso: '-- g' };
        const sD = Object.keys(guiaTamañosBebe).map(Number).sort((a,b) => b-a); 
        for (let s of sD) { if (semanas >= s) { t = guiaTamañosBebe[s]; break; } }
        document.getElementById('baby-fruit-icon').innerText = t.fruta;
        document.getElementById('baby-fruit-name').innerText = t.nombre;
        document.getElementById('baby-length').innerText = t.largo;
        document.getElementById('baby-weight').innerText = t.peso;
    }

    let inputPanza = document.getElementById('input-file-panza');
    if(inputPanza) {
        inputPanza.addEventListener('change', function(event) {
            const archivo = event.target.files[0];
            if (archivo && archivo.type.startsWith('image/')) {
                const lector = new FileReader();
                lector.onload = function(e) { guardarFotoPanzaEnStorage(e.target.result); }
                lector.readAsDataURL(archivo); 
            }
        });
    }

    function guardarFotoPanzaEnStorage(base64Image) {
        try {
            let f = JSON.parse(localStorage.getItem('mempe_fotos_panza_simuladas')) || [];
            f.unshift(base64Image);
            localStorage.setItem('mempe_fotos_panza_simuladas', JSON.stringify(f));
            cargarFotosPanzaSimuladas(); 
        } catch (error) { alert("Memoria de prueba llena."); }
    }

    function cargarFotosPanzaSimuladas() {
        const grid = document.getElementById('fotos-panza-grid-simulada');
        if(!grid) return;
        let f = [];
        try { f = JSON.parse(localStorage.getItem('mempe_fotos_panza_simuladas')) || []; } catch(e){}
        grid.innerHTML = (f.length === 0) ? '<p style="font-size: 14px; color: #999; grid-column: span 3;">Sin fotos.</p>' : ""; 
        f.forEach((img, i) => {
            const div = document.createElement('div');
            div.className = 'foto-panza'; div.style.backgroundImage = `url(${img})`;
            const span = document.createElement('span');
            span.innerText = '✕'; span.style = 'position: absolute; top: 2px; right: 2px; background: rgba(255,255,255,0.7); color:red; cursor:pointer; padding: 2px 5px; border-radius: 50%; font-size: 10px; font-weight:bold;';
            span.onclick = () => borrarFotoPanzaSimulada(i);
            div.appendChild(span); grid.appendChild(div);
        });
    }

    function borrarFotoPanzaSimulada(index) {
        if(confirm("¿Seguro?")) {
            let f = JSON.parse(localStorage.getItem('mempe_fotos_panza_simuladas')) || [];
            f.splice(index, 1); 
            localStorage.setItem('mempe_fotos_panza_simuladas', JSON.stringify(f));
            cargarFotosPanzaSimuladas(); 
        }
    }

    function renderizarCalendario() {
        const anyo = fechaReferencia.getFullYear();
        const mes = fechaReferencia.getMonth(); 
        const contenedor = document.getElementById('contenedor-calendario');
        const titulo = document.getElementById('titulo-mes');
        if (!contenedor || !titulo) return; 

        titulo.innerText = `${nombresMeses[mes]} ${anyo}`;
        const primerDiaMes = new Date(anyo, mes, 1);
        const diasEnMes = new Date(anyo, mes + 1, 0).getDate();
        let diaSemanaPrimerDia = primerDiaMes.getDay(); 
        diaSemanaPrimerDia = (diaSemanaPrimerDia === 0) ? 6 : diaSemanaPrimerDia - 1;
        const predicciones = calcularPrediccionesBasicas(fechasPeriodoReal);
        let html = `<table class="tabla-mes"><thead><tr><th>LU</th><th>MA</th><th>MI</th><th>JU</th><th>VI</th><th>SÁ</th><th>DO</th></tr></thead><tbody style="text-align:center"><tr>`;
        for (let i = 0; i < diaSemanaPrimerDia; i++) { html += '<td class="vacio"></td>'; }
        const hoy = new Date();
        for (let dia = 1; dia <= diasEnMes; dia++) {
            const fechaLoop = formatearFechaISO(new Date(anyo, mes, dia));
            let clases = (anyo === hoy.getFullYear() && mes === hoy.getMonth() && dia === hoy.getDate()) ? " hoy" : "";
            if (fechasPeriodoReal.includes(fechaLoop)) { clases += " periodo"; } 
            else if (predicciones.includes(fechaLoop)) { clases += " prediccion"; }
            html += `<td class="${clases}" onclick="alternarDiaPeriodo('${fechaLoop}')">${dia}</td>`;
            if ((dia + diaSemanaPrimerDia) % 7 === 0) { html += '</tr><tr>'; }
        }
        html += '</tr></tbody></table>';
        contenedor.innerHTML = html;
        actualizarSidebar(predicciones);
    }

    function alternarDiaPeriodo(fecha) {
        if (new Date(fecha) > new Date()) { alert("No puedes marcar fechas futuras."); return; }
        const index = fechasPeriodoReal.indexOf(fecha);
        if (index > -1) { fechasPeriodoReal.splice(index, 1); } 
        else { fechasPeriodoReal.push(fecha); }
        renderizarCalendario();
    }

    function cambiarMes(delta) { fechaReferencia.setMonth(fechaReferencia.getMonth() + delta); renderizarCalendario(); }
    function calcularPrediccionesBasicas(fR) { if (fR.length === 0) return []; const fO = [...fR].sort(); const uF = new Date(fO[fO.length - 1]); let pF = []; let iS = new Date(uF); for (let i = 0; i < 3; i++) { iS.setDate(iS.getDate() + 28); for (let d = 0; d < 5; d++) { let dP = new Date(iS); dP.setDate(dP.getDate() + d); pF.push(formatearFechaISO(dP)); } } return pF; }
    function actualizarSidebar(p) { const prox = p.sort().find(f => new Date(f) > new Date()); let fechaStr = "--"; if (prox) { fechaStr = new Date(prox + 'T00:00:00').toLocaleDateString('es-ES', { day: 'numeric', month: 'long', year: 'numeric' }); } document.getElementById('fecha-proxima-prediccion').innerText = fechaStr; const hoyISO = formatearFechaISO(new Date()); let estado = "No hay periodo hoy"; if (fechasPeriodoReal.includes(hoyISO)) { estado = "Menstruación Activa (Simulado)"; } else if (p.includes(hoyISO)) { estado = "Menstruación Probable (Predicción)"; } document.getElementById('estado-periodo').innerText = estado; }
    function formatearFechaISO(date) { try { return date.toISOString().split('T')[0]; } catch(e){ return ""; } }

    function abrirPerfil() { document.getElementById('modalPerfil').style.display = 'flex'; cambiarTabModal('perfil'); } 
    function cerrarPerfil() { document.getElementById('modalPerfil').style.display = 'none'; }
    function abrirModalSintoma() { document.getElementById('modalSintoma').style.display = 'flex'; }
    function cerrarModalSintoma() { document.getElementById('modalSintoma').style.display = 'none'; }
    function abrirModalCita() { document.getElementById('modalCita').style.display = 'flex'; }
    function cerrarModalCita() { document.getElementById('modalCita').style.display = 'none'; }

    function cambiarTabModal(tabNombre) {
        document.querySelectorAll('.tab-modal').forEach(btn => btn.classList.remove('activo'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('activo'));
        if (tabNombre === 'perfil') {
            document.querySelector('.tab-modal[onclick*="perfil"]').classList.add('activo');
            document.getElementById('tab-perfil-content').classList.add('activo');
        } else if (tabNombre === 'avatar') {
            document.querySelector('.tab-modal[onclick*="avatar"]').classList.add('activo');
            document.getElementById('tab-avatar-content').classList.add('activo');
        }
    }

    let inputAvatar = document.getElementById('input-file-avatar');
    if(inputAvatar){
        inputAvatar.addEventListener('change', function(event) {
            const archivo = event.target.files[0];
            if (archivo && archivo.type.startsWith('image/')) {
                const lector = new FileReader();
                lector.onload = function(e) { actualizarVisualmenteAvatares(e.target.result); guardarAvatarEnStorage(e.target.result); }
                lector.readAsDataURL(archivo); 
            }
        });
    }

    function actualizarVisualmenteAvatares(img) {
        const hA = document.getElementById('header-avatar-img');
        const mA = document.getElementById('modal-avatar-img');
        if(!hA || !mA) return;
        if (img) { hA.style.backgroundImage = `url(${img})`; hA.innerText = ""; mA.style.backgroundImage = `url(${img})`; mA.innerText = "";
        } else { hA.style.backgroundImage = ""; hA.innerText = "👤"; mA.style.backgroundImage = ""; mA.innerText = "👤"; }
    }

    function guardarAvatarEnStorage(img) { try { localStorage.setItem('mempe_avatar_simulado', img); } catch (e) {} }
    function cargarAvatarSimulado() { try { const sA = localStorage.getItem('mempe_avatar_simulado'); if (sA) actualizarVisualmenteAvatares(sA); } catch(e){} }
    function borrarAvatarSimulado() { if(confirm("¿Seguro?")) { try { localStorage.removeItem('mempe_avatar_simulado'); } catch(e){} actualizarVisualmenteAvatares(null); } }

    window.onload = inicializar;
</script>

</body>
</html>