<form action="" method="POST" class="form-login">
  <div class="form-group">
    <label for="username">Username: </label>
    <input type="text" class="form-control" name="username" id="username" placeholder="Username">
  </div>
  <div class="form-group">
    <label for="password">Password: </label>
    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
  <?php  
    if (isset($data) && $data != null) {
      echo "<sapn class=\"error\">".$data."</span>";
    }
  ?>
</form>