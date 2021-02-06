<?php
require_once __DIR__ . '/header.php' ?>
<section class="container" id="products">
    <?php
    require_once __DIR__ . '/flashMessage.php' ?>
	<div class="row">
        <?php
        if ($isAdmin): ?>
			<div class="col">
				<div class="card" id="newProduct">
					<div class="card-body text-center">
						<a href="index.php/product/new">
							<i class="fas fa-plus-square"></i>
						</a>
					</div>
				</div>
			</div>
        <?php
        endif; ?>
        <?php
        foreach ($products as $product): ?>
			<div class="col-3">
                <?php
                include 'card.php' ?>
			</div>
        <?php
        endforeach; ?>
	</div>
</section>
<?php
require_once __DIR__ . '/footer.php' ?>
