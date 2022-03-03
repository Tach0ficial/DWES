<form action="" method="POST" class="form-singup">
  <div class="form-group">
    <label for="username">Username: </label>
    <input type="text" class="form-control" name="username" id="username" placeholder="username">
  </div>
  <div class="form-group">
    <label for="nombre">Nombre: </label>
    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="nombre">
  </div>
  <div class="form-group">
    <label for="email">Email: </label>
    <input type="email" class="form-control" name="email" id="email" placeholder="email">
  </div>
  <div class="form-group">
    <label for="password">Contraseña: </label>
    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="re-password">Repite contraseña: </label>
    <input type="password" class="form-control" name="re-password" id="re-password" placeholder="Repite contraseña">
  </div>
  <button type="submit" class="btn btn-primary">Sing Up</button>
  <span class="error"><?php echo isset($data["error"]) ? $data["error"]:"" ?></span>
</form>