<?php
include __DIR__ . '/htmlHead.php' ?>
<div class="pdf-container">
	<div class="container-fluid">
		<section class="row" id="companyLogo">
		</section>
		<section class="row" id="companyDetails">
			<div class="col-12"><?= COMPANY_NAME ?> | <?= COMPANY_STREET ?> | <?= COMPANY_ZIP ?> <?= COMPANY_CITY ?></div>
		</section>
		<section class="row" id="invoiceAddress">
			<div class="col-12">
                <?= $orderData['deliveryAddressData']['recipient'] ?>
                <?= $orderData['deliveryAddressData']['streetNumber'] ?>
                <?= $orderData['deliveryAddressData']['city'] ?>
                <?= $orderData['deliveryAddressData']['street'] ?>
                <?= $orderData['deliveryAddressData']['zipCode'] ?>
			</div>
		</section>
		<section class="row" id="invoiceDetails">

			<div class="col-3 offset-3">
				<strong>Kundennummer</strong>
				<p><?= $userData ['customerNumber'] ?></p>
			</div>
			<div class="col-3">
				<strong>Liefer- /Leistungsdatum</strong>
				<p><?= $orderData ['deliveryDateFormatted'] ?></p>
			</div>
			<div class="col-3">
				<strong>Rechnungsdatum</strong>
				<p><?= $orderData ['orderDateFormatted'] ?></p>
			</div>
		</section>
		<section class="row" id="invoiceHeader">
			<h1 class="col-12">Rechnung Nr. <?= $orderData['id'] ?></h1>
		</section>
		<section class="row" id="invoiceHeaderSentence">
			<p class="col-12">
				Wir bedanken uns für die gute Zusammenarbeit und stellen Ihnen vereinbarungsgemäß folgende Lieferungen und Leistungen in Rechnung:
			</p>
		</section>
		<section id="products">
			<table class="table">
				<thead>
				<tr>
					<th>
						Pos.
					</th>
					<th>
						Bezeichnung
					</th>
					<th>
						Menge
					</th>
					<th>
						Einzel (€)
					</th>
					<th>
						Gesamt (€)
					</th>
				</tr>
				</thead>
				<tbody>
                <?php
                foreach ($orderData['products'] as $index => $order): ?>
					<tr>
						<td><?= ++$index ?></td>
						<td><?= $order['title'] ?></td>
						<td> <?= $order['quantity'] ?></td>
						<td><?= convertToMoney($order['price']) ?></td>
						<td><?= convertToMoney($order['price'] * $order['quantity']) ?></td>
					</tr>
                <?php
                endforeach; ?>
				</tbody>
				<tfoot>
				<tr>
					<td colspan="4">Summe Netto</td>
					<td><?= convertToMoney($orderSum['sumNet']) ?>€</td>
				</tr>
				<tr>
					<td colspan="4">Umsatzsteuer 19%</td>
					<td><?= convertToMoney($orderSum['taxes']) ?>€</td>
				</tr>
				<tr class="total">
					<td colspan="4">Rechnungsbetrag</td>
					<td><?= convertToMoney($orderSum['sumBrut']) ?>€</td>
				</tr>
				</tfoot>
			</table>
		</section>

		<section class="row" id="invoiceDetailsFooter">
			<p class="col-12">Zahlung innerhalb von 14 Tagen ab Rechnungseingang ohne Abzüge an die unten angegebene Bankverbindung</p>
		</section>
		<section class="row" id="footer">
		</section>
	</div>
</div>
<?php
require_once __DIR__ . '/footer.php' ?>
