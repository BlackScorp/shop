<?php require_once __DIR__.'/header.php'?>
<div class="container">

<h2>Reviews</h2>
<section id="reviews">
<?php if(null === $reviews):?>
<strong>Es gibt noch keine Reviews, sei der Erste</strong>
<?php endif;?>

<?php if($isLoggedIn):?>
<?php require_once __DIR__.'/reviewForm.php';?>
<?php endif;?>

<?php if(null !== $reviews):?>
<?php foreach($reviews as $review):?>
<?=$review['username']?><br/>
<?=$review['value']?><br/>
<?=escape($review ['title'])?><br/>
<?=escape($review ['text'])?><br/>
<?=$review ['created']?><br/>
<?php endforeach;?>
<?php endif;?>
</section>
</div>
<?php require_once __DIR__.'/footer.php'?>