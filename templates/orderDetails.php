<?php require_once __DIR__ . '/header.php' ?>
<section class="container" id="dashboard">
    <div class="row">
		<h2>Bestellübersicht</h2>
	</div>
	<div class="row">
	<a href="index.php/orders">Zurück zur Übersicht</a>
	</div>
	<div class="row">
	<table class="col-6 table table-striped">
			<tbody>
				<tr>
					<th>Bestell Status:</th>
					<td><?=$orderDetails['status']?></td>
				</tr>
				<tr>
					<th>Bestelldatum:</th>
					<td><?=$orderDetails['orderDateFormatted']?></td>
				</tr>
				<tr>
					<th>Lieferdatum:</th>
					<td><?=$orderDetails['deliveryDateFormatted']?></td>
				</tr>
				<tr>
					<th>Kunden Name:</th>
					<td><?=$customer['username']?></td>
				</tr>
				<tr>
					<th>Kunden Nr:</th>
					<td><?=$customer['customerNumber']?></td>
				</tr>
				<tr>
					<th>Kunden Mail:</th>
					<td><?=$customer['email']?></td>
				</tr>
			</tbody></table>
	<table class="col-6 table table-striped">
			<tbody>
			<tr>
			<th colspan="2">Lieferaddresse</th>
			</tr>
				<tr>
					<th>Empfänger:</th>
					<td><?=$orderDetails['deliveryAddressData']['recipient']?></td>
				</tr>
				<tr>
					<th>Straße :</th>
					<td><?=$orderDetails['deliveryAddressData']['street']?> <?=$orderDetails['deliveryAddressData']['streetNumber']?></td>
				</tr>
				<tr>
				<th>Stadt: </th>
				<td><?=$orderDetails['deliveryAddressData']['city']?></td>
				</tr>
				<tr>
				<th>PLZ: </th>
				<td><?=$orderDetails['deliveryAddressData']['zipCode']?></td>
				</tr>
				<tr>
				<td><a class="btn btn-primary" href="<?= $invoiceLink?>" target="_blank" >Rechnung Downloaden</a></td>
				</tr>
				</tbody>
		</table>
	</div>
	<div class="row">
	<table class="table table-striped">
	<thead>
	<tr>
	<th>Produkt Name</th>
	<th>Anzahl</th>
	<th>Stückpreis(Netto)</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($orderDetails['products'] as $product):?>
		<tr>
			<td>
			<?=$product['title']?>
			</td>
			<td>
			<?=$product['quantity']?>
			</td>
			<td>
			<?=$product['price']?>
			</td>
		</tr>
	<?php endforeach;?>
	</tbody>

	</table>
	</div>

	</div>


	
</section>
<?php require_once __DIR__ . '/footer.php' ?>