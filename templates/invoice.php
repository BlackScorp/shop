<?php include __DIR__.'/htmlHead.php'?>
<div class="pdf-container">
<section class="row" id="companyLogo">
</section>
<section class="row" id="companyDetails">
  <?= COMPANY_NAME ?> | <?= COMPANY_STREET ?> | <?= COMPANY_ZIP ?> <?= COMPANY_CITY?>
</section>
<section class="row" id="invoiceAddress">
  <div>
    <?= $orderData['deliveryAddressData']['recipient']?>
    <?= $orderData['deliveryAddressData']['streetNumber']?>
    <?= $orderData['deliveryAddressData']['city']?>
    <?= $orderData['deliveryAddressData']['street']?>
    <?= $orderData['deliveryAddressData']['zipCode']?>
  </div>
</section>
<section class="row" id="invoiceDetails">

  <div class="col-2 offset-2">
    <strong>Kundennummer</strong>
    <p><?= $userData ['customerNumber']?></p>
  </div>
  <div class="col-2">
    <strong>Liefer- /Leistungsdatum</strong>
    <p><?= $orderData ['deliveryDateFormatted']?></p>
  </div>
  <div class="col-2">
    <strong>Rechnungsdatum</strong>
    <p><?= $orderData ['orderDateFormatted']?></p>
  </div>
</section>
<section class="row" id="invoideHeader">
</section>
<section id="products">
  <?php foreach($orderData['products'] as $order):?>
    <div>
    <?=$order['title']?>
      <?=$order['quantity']?>
        <?=$order['price']?>
          <?=$order['taxInPercent']?>
        </div>
  <?php  endforeach; ?>
</section>
<section class="row" id="sum">
</section>
<section class="row" id="invoiceDetailsFooter">
</section>
<section class="row" id="footer">
</section>

</div>
<?php require_once __DIR__.'/footer.php'?>
