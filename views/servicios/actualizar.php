<h1 class="nombre-pagina">Actualizar Servicios</h1>
<p class="descripcion-pagina">Actualiza la Información de un Servicio</p>

<?php
    include_once __DIR__ . '/../templates/barra_usuario_logout.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form method="POST" class="formulario">
    <?php include_once __DIR__ . '/formulario.php'; ?>

    <input type="submit" value="Actualizar Servicio" class="boton">
</form>