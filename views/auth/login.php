<h1 class="nombre-pagina">Bienvenido(a) a App Salón</h1>

<p class="descripcion-typed">Contamos Con Los Siguientes Servicios Para <br> Tí: <span id="typed"></span></p>

<p class="descripcion-pagina">Iniciar Sesión</p>

<?php include __DIR__ . '/../templates/alertas.php'; ?>

<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" placeholder="Ingresa tu Correo Electrónico" name="email" value="<?php echo sanitizar($auth->email); ?>">
    </div>

    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" placeholder="Ingresa tu Contraseña" name="password">
    </div>

    <div class="alinear-derecha">
        <input class="boton" type="submit" value="Iniciar Sesión">
    </div>
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear Una</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>

<?php
    "<script src='build/js/typed.js'></script>";
    "<script src='build/js/scripttyped.js'></script>";
?>