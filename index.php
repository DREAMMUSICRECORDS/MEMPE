<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Mi Calendario</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<div class="contenedor-dashboard">
    <header class="header-app">
        <div class="logo">
            <h1 style="margin:0">❤️ MI MEMPE</h1>
            <p style="margin:0; opacity:0.8">Hellen | pequeositA@gmail.com</p>
        </div>
        <button class="btn-accion" style="width:auto; padding: 10px 20px;">Cerrar Sesión</button>
    </header>

    <main class="grid-principal">
        <section class="card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2 style="margin:0">Febrero 2026</h2>
                <button style="background:none; border:1px solid #ddd; padding:5px 15px; border-radius:5px; cursor:pointer">Configurar Ciclo</button>
            </div>
            
            <table class="tabla-mes">
                <thead>
                    <tr>
                        <th>LU</th><th>MA</th><th>MI</th><th>JU</th><th>VI</th><th>SÁ</th><th>DO</th>
                    </tr>
                </thead>
                <tbody style="text-align:center">
                    <!-- Filas de ejemplo -->
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
                <h4 style="margin:0; color:var(--secundario)">Estado Actual</h4>
                <h3 style="margin:5px 0">Menstruación</h3>
                <small>Día 3 del periodo</small>
            </div>

            <div class="tarjeta-info" style="border-left-color: #4caf50;">
                <h4 style="margin:0">Próximo Periodo</h4>
                <p><strong>24 de marzo, 2026</strong></p>
            </div>

            <div class="tarjeta-info" style="border-left-color: #9c27b0;">
                <h4 style="margin:0">Ovulación</h4>
                <p><strong>10 de marzo</strong></p>
            </div>
        </aside>
    </main>
</div>

</body>
</html>