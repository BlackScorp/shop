<!DOCTYPE html>
<html lang="de" class="no-js">
<head>
  <title>Vitalij Fotography</title>
  <base href="<?= $baseUrl ?>">
  <meta charset="utf-8">
  <?php if(false === $isEmail):?>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/fontawesome.min.css">
  <link rel="stylesheet" href="assets/css/styles.css">
  <?php endif;?>

  <?php if(true === $isEmail):?>
    <style>
      <?= file_get_contents(ASSETS_DIR.'/css/bootstrap.min.css')?>
      <?= file_get_contents(ASSETS_DIR.'/css/styles.css')?>
    </style>
  <?php endif;?>
</head>
<body>
