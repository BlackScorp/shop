<?php require_once __DIR__.'/header.php'?>
<section class="container" id="products">
  <?php if($hasFlashMessages):?>
  <div class="alert alert-success" role="alert">
    <?php foreach($flashMessages as $message):?>
        <p><?= $message?></p>
    <?php endforeach?>
  </div>
<?php endif;?>
  <div class="row">
  <?php if($isAdmin):?>
    <div class="col">
    <div class="card" id="newProduct">
    <div class="card-body text-center">
    <a href="index.php/product/new">
    <i class="fas fa-plus-square"></i>
  </a> 
    </div>
    </div>
    </div>
  <?php endif;?>
    <?php foreach($products as $product):?>
      <div class="col">
        <?php include 'card.php'?>
      </div>
    <?php endforeach;?>
  </div>
</section>
<?php require_once __DIR__.'/footer.php'?>
