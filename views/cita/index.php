<?php include_once __DIR__ . '/../templates/barra_usuario_logout.php' ?>
<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige Los Servicios Que Quieras Realizarte</p>

<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Tus Datos y Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige Tus Servicios A Continuación</p>
        <div id="servicios" class="listado-servicios">
            <!-- Aquí se quedó vacío porque el contenido se inyecto desde JavaScript -->
        </div>
    </div>

    <div id="paso-2" class="seccion contenido-cita">
        <h2>Tus Datos y Cita</h2>
        <p class="text-center">Coloca Tus Datos y La Fecha De Tu Cita</p>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" disabled>
            </div>

            <div class="campo">
                <label for="fecha">Fecha Cita: </label>
                <input type="date" name="fecha" id="fecha" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
            </div>

            <div class="campo">
                <label for="hora">Hora Cita: </label>
                <input type="time" name="hora" id="hora" step="1800">
            </div>

            <input type="hidden" id="id" value="<?php echo $id; ?>">
        </form>
    </div>

    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Confirma tu Cita</p>
    </div>

    <div class="paginacion">
        <button class="boton" id="anterior">&laquo; Anterior</button>
        <button class="boton" id="siguiente">Siguiente &raquo;</button>
    </div>
</div>

<?php 
    $script = "
        <script src = '//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src = 'build/js/app.js'></script>
    ";
?>