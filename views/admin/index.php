<h1 class="nombre-pagina">Panel de Administración</h1>

<?php include_once __DIR__ . '/../templates/barra_usuario_logout.php' ?>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
        </div>
    </form>
</div>

<?php  
    if(count($citas) === 0) {
        echo "<h2>No Tienes Citas Para Esta Fecha</h2>";
    }
?>

<div class="citas-admin">
    <ul class="citas">
        <?php
            // vardumpFormateado($citas);
            $idCita = 0;

            foreach($citas as $key => $cita) :

                // vardumpFormateado($key);
                if($idCita !== $cita->id) :
                    $totalPagar = 0;
                    $idCita = $cita->id;
        ?>
        <li>
            <p>ID: <span><?php echo $cita->id; ?></span></p>
            <p>Hora: <span><?php echo $cita->hora; ?></span></p>
            <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
            <p>Correo Electrónico: <span><?php echo $cita->email; ?></span></p>
            <p>Número de Contacto: <span><?php echo $cita->telefono; ?></span></p>

            <h3>Servicios</h3>
            <?php 
                endif; 
                $totalPagar += $cita->precio;
            ?>

            <p class="servicio"><?php echo $cita->servicio . ' $' . $cita->precio; ?></p>
            <?php
                $registroActual = $cita->id;
                $registroProximo = $citas[$key + 1]->id ?? 0;

                if(esUltimo($registroActual, $registroProximo)) { ?>
                    <p class="total">Total a Pagar: <span>$ <?php echo $totalPagar; ?></span></p>

                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                        <input type="submit" class="boton-eliminar" name="eliminar" value="Eliminar Cita">
                    </form>
            <?php        
                }
            ?>
        <?php endforeach; ?>
    </ul>
</div>

<?php
    $script = "<script src='build/js/buscador.js'></script>";
?>