<h1 class="nombre-pagina">Restablecer Contraseña</h1>
<p class="descripcion-pagina">Llena el Siguiente Formulario para Restablecer tu Contraseña</p>

<?php include __DIR__ . '/../templates/alertas.php'; ?>

<?php if($error) return ?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Contraseña Nueva</label>
        <input type="password" id="password" placeholder="Ingresa tu Nueva Contraseña" name="password">
    </div>

    <div class="alinear-derecha">
        <input class="boton" type="submit" value="Restablecer Contraseña">
    </div>
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear Una</a>
    <a href="/">¿Ya Tienes una Cuenta? Iniciar Sesión</a>
</div>