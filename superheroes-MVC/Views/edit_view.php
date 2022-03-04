<h1>Editar el superheroe <?php echo ($data->getNombre()) ?></h1>
<form action="" method="POST" class="form-add" enctype="multipart/form-data">
  <div class="form-group">
    <label for="nombre">Nombre: </label>
    <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo ($data->getNombre()) ?>" placeholder="nombre">
  </div>
  <label for="file">foto de perfil</label>
  <input type="file" name="file" id="file"><br>
  <button type="submit" class="btn btn-primary">Editar</button>
</form>