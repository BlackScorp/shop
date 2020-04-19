<?php require_once __DIR__.'/header.php'?>
<section class="container" id="products">
  <div class="row">
    <?php foreach($products as $product):?>
      <div class="col">
        <?php include 'card.php'?>
      </div>
    <?php endforeach;?>
  </div>
</section>
<?php require_once __DIR__.'/footer.php'?>
