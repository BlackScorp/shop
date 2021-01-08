<?php require_once __DIR__.'/header.php'?>
<section class="container" id="productDetails">
<div class="card">
    <div class="card-header">
    <h2><?=$product['title']?></h2>
    </div>
    <div class="card-body">
    <div class="row">
        <div class="col-4">
        <img src="index.php/product/image/<?= $product['slug']?>/<?= $product['mainImage']?>" class="card-img-top" alt="produkt">
  

        </div>
        <div class="col-8">
        <div >Preis: <b><?= convertToMoney($product['price']) ?></b></div>
        <hr/>
        <div><?= $product['description'] ?></div>
        </div>
    </div>
    </div>
    <div class="card-footer">
    <a href="index.php" class="btn btn-primary btn-sm">Zurück zum Schop</a>
   
    <a href="index.php/cart/add/<?= $product['id']?>" class="btn btn-success btn-sm">In den Warenkorb</a>
    </div>
</div>
</section>
<?php require_once __DIR__.'/footer.php'?>