<div class="pdf-container">
<section id="products">
  <?php foreach($orderData['products'] as $order):?>
    <?=$order['title']?>
      <?=$order['quantity']?>
        <?=$order['price']?>
          <?=$order['taxInPercent']?>
  <?php  endforeach; ?>
</section>
</div>
