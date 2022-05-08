<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llena el Siguiente Formulario para Crear una Cuenta</p>

<?php include __DIR__ . '/../templates/alertas.php'; ?>

<form action="/crear-cuenta" method="POST" class="formulario">
    <div class="campo">
        <label for="nombre">Nombre(s): </label>
        <input type="text" name="nombre" id="nombre" placeholder="Escribe tu Nombre" value="<?php echo $usuario->nombre; ?>">
    </div>

    <div class="campo">
        <label for="apellido">Apellido(s): </label>
        <input type="text" name="apellido" id="apellido" placeholder="Escribe tu Apellido" value="<?php echo $usuario->apellido; ?>">
    </div>

    <div class="campo">
        <label for="telefono">Teléfono: </label>
        <input type="tel" name="telefono" id="telefono" placeholder="Escribe un Número de Contacto (opcional)" value="<?php echo $usuario->telefono; ?>">
    </div>

    <div class="campo">
        <label for="email">Correo Electrónico: </label>
        <input type="email" name="email" id="email" placeholder="Escribe tu Correo Electrónico" value="<?php echo $usuario->email; ?>">
    </div>

    <div class="campo">
        <label for="password">Contraseña: </label>
        <input type="password" name="password" id="password" placeholder="Escribe una Contraseña">
    </div>

    <div class="alinear-derecha">
        <input type="submit" value="Crear Cuenta" class="boton">
    </div>
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>