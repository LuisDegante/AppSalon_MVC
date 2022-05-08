<h1 class="nombre-pagina">Olvide mi Contraseña</h1>
<p class="descripcion-pagina">Restablece tu Contraseña Escribiendo tu Correo Electrónico en el Siguiente Campo</p>

<?php include __DIR__ . '/../templates/alertas.php'; ?>

<form class="formulario" action="/olvide" method="POST">
    <div class="campo">
        <label for="email">Correo Electrónico</label>
        <input type="email" name="email" id="email" placeholder="Escribe tu Correo Electrónico">
    </div>
    <div class="alinear-derecha">
        <input class="boton" type="submit" value="Restablecer Contraseña">
    </div>
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear Una</a>
    <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
</div>