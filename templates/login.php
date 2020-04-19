<?php require_once __DIR__.'/header.php'?>
<section class="container" id="loginForm">

<form action="index.php/login" method="POST">
  <div class="card">
    <div class="card-header">
      Login
    </div>
    <div class="card-body">
      <?php if($hasErrors):?>
      <div class="alert alert-danger" role="alert">
        <?php foreach($errors as $errorMessage):?>
            <p><?= $errorMessage?></p>
        <?php endforeach?>
      </div>
    <?php endif;?>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" value="<?=$username?>" name="username" id="username" class="form-control">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" value="<?= $password?>" name="password" id="password" class="form-control">
      </div>
    </div>
    <div class="card-footer">
      <button class="btn btn-success" type="submit">Login</button>
    </div>
  </div>
</form>

</section>
<?php require_once __DIR__.'/footer.php'?>
