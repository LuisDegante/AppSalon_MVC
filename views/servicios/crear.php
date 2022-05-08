<h1 class="nombre-pagina">Crear Nuevo Servicio</h1>

<?php
    include_once __DIR__ . '/../templates/barra_usuario_logout.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form action="/servicios/crear" method="POST" class="formulario">
    <?php include_once __DIR__ . '/formulario.php'; ?>

    <input type="submit" value="Crear Servicio" class="boton">
</form>