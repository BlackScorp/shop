<?php require_once __DIR__ . '/flashMessage.php' ?>
<?php require_once __DIR__ . '/errorMessages.php' ?>
<form method="POST" action="index.php/reviews/<?= $slug ?>">
    <?php for ($value = 1; $value <= $maxRating; $value++) : 
        $isSelected = ($rating && $value === $rating)?' checked':'';
        ?>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="rating" id="rating<?= $value ?>"<?=$isSelected?> value="<?= $value ?>" >
            <label class="form-check-label" for="rating<?= $value ?>"><?= $value ?></label>
        </div>
    <?php endfor; ?>
    <div class="form-group">
        <label for="title">Titel</label>
        <input type="text" value="<?= escape($title) ?>" name="title" id="title" class="form-control">
    </div>

    <div class="form-group">
        <label for="text">Text</label>
        <textarea class="form-control" id="text" name="text" rows="3"><?= escape($text) ?></textarea>
    </div>
    <button class="btn btn-success">Bewertung abgeben</button>
</form>