<?php
session_start();
require_once 'conexion.php';
$conn = conectar();

if (!isset($_SESSION['usuario_id'])) { header("Location: login.php"); exit(); }

$id_usuario = $_SESSION['usuario_id'];
$res_admin = $conn->query("SELECT rol FROM usuarios WHERE id = $id_usuario");
$user_check = $res_admin->fetch_assoc();

if ($user_check['rol'] !== 'admin') {
    echo "<h1>Acceso Denegado</h1>";
    exit();
}

// ESTADÍSTICAS
$total_users = $conn->query("SELECT COUNT(*) as total FROM usuarios")->fetch_assoc()['total'];
$total_citas = $conn->query("SELECT COUNT(*) as total FROM citas_embarazo")->fetch_assoc()['total'];

// LISTA DE USUARIOS
$todos_usuarios = $conn->query("SELECT id, nombre_completo, correo, rol FROM usuarios ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MEMPE - Panel Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f0f2f5; margin: 0; padding: 20px; }
        .admin-container { max-width: 1000px; margin: auto; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); text-align: center; }
        .stat-card h3 { margin: 0; color: #7b2cbf; font-size: 2rem; }
        .main-card { background: white; padding: 30px; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; color: #666; font-weight: 600; }
        .badge { padding: 5px 10px; border-radius: 5px; font-size: 0.75rem; font-weight: bold; }
        .badge-admin { background: #7b2cbf; color: white; }
        .badge-user { background: #e2e2e2; color: #666; }
        .btn { padding: 8px 12px; border-radius: 8px; border: none; cursor: pointer; text-decoration: none; font-size: 0.8rem; transition: 0.3s; }
        .btn-del { background: #ffebee; color: #c62828; }
        .btn-del:hover { background: #c62828; color: white; }
        .btn-rol { background: #f3e5f5; color: #7b2cbf; margin-right: 5px; }
        .btn-rol:hover { background: #7b2cbf; color: white; }
    </style>
</head>
<body>

<div class="admin-container">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
        <h1>Control MEMPE</h1>
        <a href="index.php" style="color: #7b2cbf; text-decoration: none; font-weight: 600;">← Volver a la App</a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3><?php echo $total_users; ?></h3>
            <p>Usuarias Registradas</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $total_citas; ?></h3>
            <p>Citas Agendadas</p>
        </div>
        <div class="stat-card">
            <h3>v1.0</h3>
            <p>Versión del Sistema</p>
        </div>
    </div>

    <div class="main-card">
        <h3>Gestión de Usuarios</h3>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($u = $todos_usuarios->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($u['nombre_completo']); ?></td>
                    <td><?php echo htmlspecialchars($u['correo']); ?></td>
                    <td>
                        <span class="badge <?php echo $u['rol'] == 'admin' ? 'badge-admin' : 'badge-user'; ?>">
                            <?php echo strtoupper($u['rol']); ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($u['id'] != $id_usuario): ?>
                            <a href="acciones_admin.php?accion=cambiar_rol&id=<?php echo $u['id']; ?>&actual=<?php echo $u['rol']; ?>" class="btn btn-rol">Cambiar Rol</a>
                            <a href="acciones_admin.php?accion=eliminar&id=<?php echo $u['id']; ?>" class="btn btn-del" onclick="return confirm('¿Seguro que quieres borrar a este usuario?')">Eliminar</a>
                        <?php else: ?>
                            <small style="color:#aaa;">(Tú)</small>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>