<?php require_once __DIR__ . '/header.php' ?>
<?php require_once __DIR__ . '/ajaxLoader.php' ?>
<section class="container" id="dashboard">
    <div class="row">
		<h2>Bestellungen</h2>
	</div>
	<div class="row">
	<form method="POST" style="width: 100%;"  action="index.php/orders/changeStatus" class="ajax-form">
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
				<td><?=$order['id']?><input type="hidden" name="order[<?=$order['id']?>][id]" value="<?=$order['id']?>"></td>
				<td><?=$order['orderDate']?></td>
				<td><?=$order['deliveryDate']?></td>
				<td>
					<select class="form-select oderStatus" name="order[<?=$order['id']?>][status]">
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
	</form>
	</div>

	
</section>
<?php require_once __DIR__ . '/footer.php' ?>