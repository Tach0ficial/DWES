<form action="" method="POST" class="form-peticion">
  <div class="form-group">
    <label for="titulo">Titulo: </label>
    <input type="text" class="form-control" name="titulo" id="titulo" placeholder="titulo">
  </div>
  <div class="form-group">
    <label for="descripcion">Descripcion: </label>
    <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="descripcion">
  </div>
  <button type="submit" class="btn btn-primary">Enviar petición</button>
  <span class="error"><?php echo isset($data["error"]) ? $data["error"]:"" ?></span>
</form>