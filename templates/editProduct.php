<?php require_once __DIR__.'/header.php'?>
<section id="newProduct" class="container"> 
    <form action="index.php/product/edit/<?=$slug ?>" class="droppable" method="POST" enctype="multipart/form-data">
    <div class="card">
        <div class="card-header">
          Produkt bearbeiten
</div>
<div class="card-body">

<?php require_once __DIR__.'/flashMessage.php' ?>
<?php require_once __DIR__.'/errorMessages.php'?>
<div class="alert alert-danger" id="uploadFailed"  style="display: none;" role="alert">
    <p>Upload fehlgeschlagen</p>
</div>
<div class="alert alert-success" id="uploadSuccess" style="display: none;" role="alert">
    <p>Upload erfolgreich</p>
</div>
    <div class="form-group">
        <label for="name">Produkt Name</label>
        <input type="text" value="<?=escape($productName)?>" name="name" id="name" class="form-control">
    </div>
    <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" value="<?=escape($slug)?>" name="slug" id="slug" class="form-control">
    </div>
    <div class="form-group">
        <label for="description">Produkt Beschreibung</label>
        <textarea class="form-control" id="description" name="description" rows="3"><?=escape($description)?></textarea>
    </div>
    <div class="form-group">
        <label for="price">Price</label>
        <input type="text" value="<?=escape($price)?>" name="price" id="price" class="form-control">
    </div>
    <div class="form-group">
        <div class="drop-zone form-control text-center">
        <?php require_once __DIR__.'/ajaxLoader.php' ?>
        <label for="picture">Wähle bild aus<span class="advanced"> oder drage und drope hier rein</span></label>
        <input type="file" name="picture[]" id="picture" class="form-control-file">
        </div>
    
    </div>
    <div class="form-group" id="pictures">
        <div class="row">
        <?php foreach($prorductImages as $image):?>
            <div class="col-3">
                <img src="index.php/product/image/<?=escape($slug)?>/<?=$image?>" class="img-thumbnail">
            </div>
        <?php endforeach;?>
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
<?php require_once __DIR__.'/footer.php'?>