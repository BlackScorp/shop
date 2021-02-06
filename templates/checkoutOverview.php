<?php
require_once __DIR__ . '/header.php' ?>

<section id="overview" class="container">
	<div clas="row">
		<h2>Bestellübersicht</h2>
	</div>
    <?php
    foreach ($cartItems as $cartItem): ?>
		<div class="row cartItem">
            <?php
            include __DIR__ . '/cartItem.php'; ?>
		</div>
    <?php
    endforeach; ?>
	<div class="row">
		<div class="col-12 text-right">
			Summe (<?= $countCartItems ?> Artikel): <span class="price"><?= convertToMoney($cartSum) ?></span> €
		</div>
	</div>
	</div>
	<div class="row">
		<a class="btn btn-danger" href="index.php">Abbrechen</a>
		<a class="btn btn-success" href="index.php/completeOrder">Kostenpflichtig bestellen</a>
	</div>
</section>

<?php
require_once __DIR__ . '/footer.php' ?>
