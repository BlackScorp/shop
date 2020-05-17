<?php require_once __DIR__.'/header.php'?>

<section class="container" id="selectPaymentMethod">
  <form method="POST" action="index.php/selectPayment">
    <div class="form-check">
      <input type="radio" class="form-check-input" name="paymentMethod" id="paymentPaypal" value="paypal">
      <label class="form-check-label" for="paymentPaypal">
        paypal
      </label>
    </div>
    <button type="submit" class="btn btn-primary">Weiter zur Bezahlung</button>
  </form>
</section>

<?php require_once __DIR__.'/footer.php'?>
