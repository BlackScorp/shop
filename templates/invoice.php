<div class="pdf-container">
<section class="row" id="companyLogo">
</section>
<section class="row" id="companyDetails">
  <?= COMPANY_NAME ?> | <?= COMPANY_STREET ?> | <?= COMPANY_ZIP ?> <?= COMPANY_CITY?>
</section>
<section class="row" id="invoiceAddress">
</section>
<section class="row" id="invoiceDetails">
</section>
<section class="row" id="invoideHeader">
</section>
<section id="products">
  <?php foreach($orderData['products'] as $order):?>
    <?=$order['title']?>
      <?=$order['quantity']?>
        <?=$order['price']?>
          <?=$order['taxInPercent']?>
  <?php  endforeach; ?>
</section>
<section class="row" id="sum">
</section>
<section class="row" id="invoiceDetailsFooter">
</section>
<section class="row" id="footer">
</section>

</div>
