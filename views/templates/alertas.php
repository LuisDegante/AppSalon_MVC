<?php
    // vardumpFormateado($alertas);

    foreach($alertas as $key => $mensajes) :
        // vardumpFormateado($alerta);
        foreach($mensajes as $mensaje):
?>
<div class="alerta <?php echo $key; ?>">
    <?php echo $mensaje; ?>
</div>
<?php            
        endforeach;
    endforeach;