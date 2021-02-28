<?php
require_once __DIR__ . '/header.php' ?>
	<section id="editProduct" class="container">
		<form action="index.php/product/edit/<?= escape($slug) ?>" class="droppable" method="POST" enctype="multipart/form-data">
			<div class="card">
				<div class="card-header">
					Produkt bearbeiten
				</div>
				<div class="card-body">

                    <?php
                    require_once __DIR__ . '/flashMessage.php' ?>
                    <?php
                    require_once __DIR__ . '/errorMessages.php' ?>
					<div class="alert alert-danger" id="uploadFailed" style="display: none;" role="alert">
						<p>Upload fehlgeschlagen</p>
					</div>
					<div class="alert alert-success" id="uploadSuccess" style="display: none;" role="alert">
						<p>Upload erfolgreich</p>
					</div>
					<div class="form-group">
						<label for="name">Produkt Name</label>
						<input type="text" value="<?= escape($productName) ?>" name="name" id="name" class="form-control">
					</div>
					<div class="form-group">
						<label for="slug">Slug</label>
						<input type="text" value="<?= escape($slug) ?>" name="slug" id="slug" class="form-control">
					</div>
					<div class="form-group">
						<label for="categories">Kategorien</label>
						<ul>
							<li class="row">
								<a href="index.php/category/new/<?= escape($slug) ?>/<?= escape($productCategoryId) ?>">Kategorie anlegen</a>
							</li>
							<li class="row">
								<a href="index.php/category/assign/<?= escape($slug) ?>/0">Alle Kategorien</a>
							</li>
                            <?php
                            foreach ($parentCategories as $category): ?>
								<li class="row">
									<a href="index.php/category/assign/<?= escape($slug) ?>/<?= $category['id'] ?>">
                                        <?= $category['label'] ?>
									</a>
								</li>
                            <?php
                            endforeach ?>
                            <?php
                            foreach ($categories as $category): ?>
								<li class="row">
									
									<a  class="col-8" href="index.php/category/assign/<?= escape($slug) ?>/<?= $category['id'] ?>">
                                        <?php
                                        if ((bool)$category['isPrimary']): ?>
											<strong><?= $category['label'] ?></strong>
                                        <?php
                                        else : ?>
                                            <?= $category['label'] ?>
                                        <?php
                                        endif; ?>
									</a>
									<span class="col-4">
									<a href="index.php/categoryDelete/<?= $category['id'] ?>/<?= escape($slug) ?>" class="btn btn-danger btn-sm">Löschen</a>
									</span>
								</li>
                            <?php
                            endforeach; ?>
						</ul>
					</div>
					<div class="form-group">
						<label for="description">Produkt Beschreibung</label>
						<textarea class="form-control" id="description" name="description" rows="3"><?= escape($description) ?></textarea>
					</div>
					<div class="form-group">
						<label for="price">Price</label>
						<input type="text" value="<?= escape($price) ?>" name="price" id="price" class="form-control">
					</div>
					<div class="form-group">
						<div class="drop-zone form-control text-center">
                            <?php
                            require_once __DIR__ . '/ajaxLoader.php' ?>
							<label for="picture">Wähle bild aus<span class="advanced"> oder drage und drope hier rein</span></label>
							<input type="file" name="picture[]" id="picture" class="form-control-file">
						</div>

					</div>
					<div class="form-group" id="pictures">
						<div class="row">
                            <?php
                            foreach ($prorductImages as $image): ?>
								<div class="col-3">
									<a href="index.php/product/image/select/<?= escape($slug) ?>/<?= $image ?>">
										<img src="index.php/product/image/<?= escape($slug) ?>/<?= $image ?>" class="img-thumbnail">
									</a>
								</div>
                            <?php
                            endforeach; ?>
						</div>
					</div>
					<div class="form-group">
				
							<div class="custom-control custom-switch">
							<input <?=($isLive)?'checked':''?> type="checkbox" class="custom-control-input" name="activate" id="active">
							<label class="custom-control-label" for="active">Live?</label>
							</div>
				
					</div>
							
				</div>
				<div class="card-footer">
					<a href="index.php" class="btn btn-danger">Abbrechen</a>
					<button class="btn btn-success">Speichern</button>
				</div>
			</div>
		</form>
	</section>
	<?php if($showCategoryDeleteModal):?>
	<section id="confirmCategoryDelete">
		<div class="modal" style="display: block;">
			  <div class="modal-dialog">
				 <div class="modal-content">
				 <form action="index.php/category/delete" method="POST">
				   <div class="modal-header">
						<h4 class="modal-title">Löschvorgang bestätigen</h4>
						<a href="btn-close" href="index.php/categoryDelete/cancel">X</a>
				   </div>
				   <div class="modal-body">
				   Soll die Kategorie "<?= $deleteCategoryLabel ?>" wirklich gelöscht werden
				   </div>
				   <div class="modal-footer">
				        <button type="submit" class="btn btn-sm btn-success">Löschen</button>
						<a class="btn btn-sm btn-danger" href="index.php/categoryDelete/cancel">Abbrechen</a>
				   </div>
				 </form>
				</div>
			  </div>				
		</div>
	</section>
	<?php endif;?>
<?php
require_once __DIR__ . '/footer.php' ?>