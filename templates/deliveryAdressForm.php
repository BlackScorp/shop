<form method="POST" action="index.php/deliveryAddress/add">
	<div class="card">
		<div class="card-header">
			Neue Adresse eintragen
		</div>
		<div class="card-body">
            <?php
            require_once __DIR__ . '/errorMessages.php' ?>
			<div class="form-group">
				<label for="recipient">Empfänger</label>
				<input name="recipient" value="<?= escape($recipient) ?>" class="form-control<?= $recipientIsValid ? '' : ' is-invalid' ?>" id="recipient">
			</div>
			<div class="form-group">
				<label for="city">Stadt</label>
				<input name="city" value="<?= escape($city) ?>" class="form-control<?= $cityIsValid ? '' : ' is-invalid' ?>" id="city">
			</div>
			<div class="form-group">
				<label for="zipCode">PLZ</label>
				<input name="zipCode" value="<?= escape($zipCode) ?>" class="form-control<?= $zipCodeIsValid ? '' : ' is-invalid' ?>" id="zipCode">
			</div>
			<div class="form-group">
				<label for="street">Strasse</label>
				<input name="street" value="<?= escape($street) ?>" class="form-control<?= $streetIsValid ? '' : ' is-invalid' ?>" id="street">
			</div>
			<div class="form-group">
				<label for="streetNumber">Hausnummer(ggf. Zusatz)</label>
				<input name="streetNumber" value="<?= escape($streetNumber) ?>" class="form-control<?= $streetNumberIsValid ? '' : ' is-invalid' ?>" id="streetNumber">
			</div>
		</div>
		<div class="card-footer">
			<button class="btn btn-success">Speichern</button>
		</div>
	</div>
</form>
