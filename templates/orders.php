<?php require_once __DIR__ . '/header.php' ?>
<section class="container" id="dashboard">
    <div class="row">
		<h2>Bestellungen</h2>
	</div>
	<div class="row">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Bestelldatum</th>
				<th>Lieferdatum</th>
				<th>Status</th>
				<th>Aktionen</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($orders as $order):?>
			<tr>
				<td><?=$order['id']?></td>
				<td><?=$order['orderDate']?></td>
				<td><?=$order['deliveryDate']?></td>
				<td>
					<select class="form-select">
					<?php foreach($orderStatus as $orderStatus):
						$isSelected = $order['status'] === $orderStatus;
						?>
						<option<?=$isSelected?' selected':''?>><?=$orderStatus ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td>
					<a class="btn btn-primary btn-sm" href="index.php/orders/details/<?=$order['id']?>">Details</a>
			
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	</div>

	
</section>
<?php require_once __DIR__ . '/footer.php' ?>