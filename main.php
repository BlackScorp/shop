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

<section class="container" id="products">
  <div class="row">
    <?php foreach($products as $product):?>
      <div class="col">
        <?php include 'card.php'?>
      </div>
    <?php endforeach;?>
  </div>


</section>
<script src="assets/js/bootstrap.bundle.js"></script>
</body>
</html>
