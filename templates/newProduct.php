<?php
require_once __DIR__ . '/header.php' ?>
	<section id="newProduct" class="container">
		<form action="index.php/product/new" method="POST">
			<div class="card">
				<div class="card-header">
					Neues Produkt erstellen
				</div>
				<div class="card-body">
                    <?php
                    require_once __DIR__ . '/flashMessage.php' ?>
                    <?php
                    require_once __DIR__ . '/errorMessages.php' ?>
					<div class="form-group">
						<label for="name">Produkt Name</label>
						<input type="text" value="<?= escape($productName) ?>" name="name" id="name" class="form-control">
					</div>
					<div class="form-group">
						<label for="slug">Slug</label>
						<input type="text" value="<?= escape($slug) ?>" name="slug" id="slug" class="form-control">
					</div>
					<div class="form-group">
						<label for="description">Produkt Beschreibung</label>
						<textarea class="form-control" id="description" name="description" rows="3"><?= escape($description) ?></textarea>
					</div>
					<div class="form-group">
						<label for="price">Preis</label>
						<input type="text" value="<?= escape($price) ?>" name="price" id="price" class="form-control">
					</div>
				</div>
				<div class="card-footer">
					<a href="index.php" class="btn btn-danger">Abbrechen</a>
					<button class="btn btn-success">Speichern</button>
				</div>
			</div>
		</form>
	</section>
<?php
require_once __DIR__ . '/footer.php' ?>