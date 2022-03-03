<h1>Editar el superheroe <?php echo $data->getNombre() ?></h1>
<form action="" method="post">
    <label>Nombre:
        <input type="text" name="nombre" id="nombre" value="<?php echo $data->getNombre() ?>">
    </label><br>
    <label>Velocidad:
        <input type="text" name="velocidad" id="velocidad" value="<?php echo $data->getVelocidad() ?>">
    </label><br>
    <input type="submit" value="Editar">
</form>