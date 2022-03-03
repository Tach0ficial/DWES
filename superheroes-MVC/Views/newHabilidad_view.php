<h1>Agregar nueva habilidad</h1>
<form action="" method="POST" class="form-newHabilidad">
  <div class="form-group">
    <label for="nombre">Nombre: </label>
    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">
  </div>
  <div class="form-group">
    <label for="valor">Valor: </label>
    <input type="number" class="form-control" name="valor" id="valor" placeholder="Valor">
  </div>
  <button type="submit" class="btn btn-primary">Agregar habilidad</button>
  <?php  
    if (isset($data) && $data != null) {
      echo "<sapn class=\"error\">".$data."</span>";
    }
  ?>
</form>