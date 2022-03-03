<form action="" method="POST" class="form-add" enctype="multipart/form-data">
  <div class="form-group">
    <label for="username">Username: </label>
    <input type="text" class="form-control" name="username" id="username" placeholder="username">
  </div>
  <div class="form-group">
    <label for="nombre">Nombre: </label>
    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="nombre">
  </div>
  <div class="form-group">
    <label for="password">Contraseña: </label>
    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="re-password">Repite contraseña: </label>
    <input type="password" class="form-control" name="re-password" id="re-password" placeholder="Repite contraseña">
  </div>
  <?php
  foreach ($data as $habilidad) {
    echo "<input type=\"checkbox\" name=\"habilidades[]\" value=\"" . $habilidad['id'] . "\" id=\"" . $habilidad['nombre'] . "\">";
    echo "<label for=\"" . $habilidad['nombre'] . "\">" . $habilidad['nombre'] . "</label>";
    echo ", ";
    echo "<label for=\"" . $habilidad['nombre'] . "\">Valor: </label>";
    echo "<input type=\"number\" name=\"" . $habilidad['id'] . "Valor\" id=\"" . $habilidad['id'] . "Valor\">";
    echo "<br>";
  }
  ?>
  <label for="file">foto de perfil</label>
  <input type="file" name="file" id="file"><br>
  <button type="submit" class="btn btn-primary">Añadir</button>
</form>