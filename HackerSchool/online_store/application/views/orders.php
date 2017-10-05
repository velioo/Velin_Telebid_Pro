<?php require 'header.php'; ?>

<script src="<?php echo asset_url() . "js/user_change_status.js"; ?>"></script>

<script>

	function getDeclineOrderUrl() {
		var url = "<?php echo site_url("orders/decline_order"); ?>";
		return url;
	}

</script>

<div id="body">
	
<h2>Моят профил</h2>	
	 <div class="vertical-menu">
	  <a href="<?php echo site_url("users/cart"); ?>">Количка</a>	 
	  <a href="<?php echo site_url("users/orders"); ?>" class="active">Поръчки</a>
	  <a href="<?php echo site_url("users/payments"); ?>">Плащания</a>	
	  <a href="<?php echo site_url("users/account"); ?>">Настройки</a>
	  <a href="<?php echo site_url("users/details"); ?>">Детайли</a>
	</div>
	<div class="account-info">
	<hr>	
		
	<div class="table-responsive">          
	  <table class="table">
		<thead>
		  <tr>
			<th>Поръчка#</th>
			<th>Създадена на</th>
			<th>Обща сума</th>
			<th>Състояние</th>
			<th>Детайли</th>
			<th>Откажи</th>
		  </tr>
		</thead>
		<tbody>
		<?php foreach($orders as $order) { ?>
		  <tr>
			<td><?php echo htmlspecialchars($order['order_id'], ENT_QUOTES); ?></td>
			<td><?php echo htmlspecialchars($order['order_created_at'], ENT_QUOTES); ?></td>
			<td><?php echo htmlspecialchars($order['amount_leva'], ENT_QUOTES); ?></td>
			<td class="order_status"><?php echo htmlspecialchars($order['status_name'], ENT_QUOTES); ?></td>
			<td><a href="<?php echo site_url("orders/show_order/" . htmlentities($order['order_id'], ENT_QUOTES)); ?>" class="order_details">Детайли</a></td>
			<td><a href="#" data-id="<?php echo htmlspecialchars($order['order_id'], ENT_QUOTES); ?>" class="cancel_order"><?php if((htmlspecialchars($order['status_id'], ENT_QUOTES) != 1) && (htmlspecialchars($order['status_id'], ENT_QUOTES)) != 2 && (htmlspecialchars($order['status_id'], ENT_QUOTES) != 3)) echo "Откажи"; ?></a></td>		
		  </tr>	
		  <?php } ?>
		</tbody>
	  </table>
	</div>
		
	</div>
	
</div>

<?php require 'footer.php'; ?>
