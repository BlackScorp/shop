<!DOCTYPE html>
<html lang="de">
<head>
  <title>Vitalij Fotography</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<header class="jumbotron">
<div class="container">
<h1>Willkommen auf meinem Online Shop</h1>
</div>
</header>
<section class="container" id="products">
  <div class="row">
    <?php while($row = $result->fetch()):?>
      <div class="col">
        <?php include 'card.php'?>
      </div>
    <?php endwhile;?>
  </div>


</section>
<script src="assets/js/bootstrap.bundle.js"></script>
</body>
</html>
