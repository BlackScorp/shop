<!DOCTYPE html>
<html lang="de">
<head>
  <title>Vitalij Fotography</title>
  <base href="<?= $baseUrl ?>">
  <meta charset="utf-8">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<?php include __DIR__.'/navbar.php'?>
<header class="jumbotron">
<div class="container">
<h1>Willkommen auf meinem Online Shop</h1>
</div>
</header>

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
<script src="assets/js/bootstrap.bundle.js"></script>
</body>
</html>
