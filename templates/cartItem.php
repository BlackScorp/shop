<div class="col-3">
	<img src="index.php/product/image/<?= $cartItem['slug'] ?>/<?= $cartItem['mainImage'] ?>" class="productPicture" alt="produkt">

</div>
<div class="col-7">
	<div><?= $cartItem['title'] ?></div>
	<div><?= $cartItem['description'] ?></div>
</div>
<div class="col-2 text-right">
	<span class="price"><?= convertToMoney((int)$cartItem['price']) ?> €</div>
</div>
