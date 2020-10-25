<div class="card <?=$product['status']?>">
  <div class="card-title"><?= $product['title']?></div>
  <img src="https://placekitten.com/286/180" class="card-img-top" alt="produkt">
  <div class="card-body">
    <?= $product['description'] ?>
    <hr>
    <?= $product['price'] ?>
  </div>
  <div class="card-footer">
    <a href="index.php/product/<?= $product['slug']?>" class="btn btn-primary btn-sm">details</a>
    <a href="index.php/cart/add/<?= $product['id']?>" class="btn btn-success btn-sm">In den Warenkorb</a>
    <?php if($isAdmin):?>
      <a href="index.php/product/edit/<?= $product['slug']?>" class="btn btn-primary btn-sm">bearbeiten</a>
    <?php endif;?>
  </div>
</div>
