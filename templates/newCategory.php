<?php require_once __DIR__ . '/header.php' ?>
	<section id="newCategory" class="container">
		<form action="index.php/category/new/<?=escape($slug)?>/<?=escape($categoryId )?>" method="POST">
			<div class="card">
				<div class="card-header">
					Neue Kategorie erstellen
				</div>
				<div class="card-body">
                    <?php require_once __DIR__ . '/flashMessage.php' ?>
                    <?php require_once __DIR__ . '/errorMessages.php' ?>
					<div class="form-group">
						<label for="name">Kategorie Name</label>
						<input type="text" value="<?= escape($categoryName) ?>" name="name" id="name" class="form-control">
					</div>
				</div>
				<div class="card-footer">
					<a href="index.php" class="btn btn-danger">Abbrechen</a>
					<button class="btn btn-success">Speichern</button>
				</div>
			</div>
		</form>
	</section>
<?php require_once __DIR__ . '/footer.php' ?>