<?php require_once __DIR__.'/htmlHead.php'?>
<section id="activationMail" class="container">
Vielen dank für die Registrierung <?= $username ?><br/>

Um die account aktivierung abzuschließen benuzten Sie bitte folgenden Link.

<a class="btn btn-success" href="<?= $acitvationLink ?>" target="_blank" >Account aktivieren</a>
</section>
<?php require_once __DIR__.'/footer.php'?>