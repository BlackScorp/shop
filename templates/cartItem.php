<div class="col-3">
<img class="productPicture" src="https://placekitten.com/286/180">
</div>
<div class="col-7">
<div><?= $cartItem['title']?></div>
<div><?= $cartItem['description']?></div>
</div>
<div class="col-2 text-right">
  <span class="price"><?= number_format($cartItem['price']/100,2,","," ") ?> €</div>
</div>
