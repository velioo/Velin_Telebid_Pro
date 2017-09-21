<?php include 'dashboard_header.php'; ?>

<div id="body" style="width: 100%;">

<div class="vertical-menu employee">
	  <a href="<?php echo site_url("employees/dashboard"); ?>" class="active">Всички продукти</a>
	  <a href="<?php echo site_url("employees/add_product"); ?>" >Добави продукт</a>
</div>

<div class="account-info">
	<div class="profile_tab_title">Всички продукти</div>
	<hr>
	
	<?php
		if(!empty($this->session->userdata('success_msg'))){
			echo '<p class="statusMsg">' . $this->session->userdata('success_msg') . '</p>';
			$this->session->unset_userdata('success_msg');
		} elseif(!empty($this->session->userdata('error_msg'))) {
			echo '<p class="statusMsg">' . $this->session->userdata('error_msg') . '</p>';
			$this->session->unset_userdata('error_msg');
		}
		
	?>
	
	<div class="table-responsive">          
	  <table class="table">
		<thead>
		  <tr>
			<th>Име</th>
			<th>Категория</th>
			<th>Цена</th>
			<th>Наличност</th>
			<th>Създаден на</th>
			<th>Последна промяна</th>
			<th>Редактирай</th>
			<th>Изтрии</th>
		  </tr>
		</thead>
		<tbody>
		<?php foreach($products as $product) { ?>
		  <tr>
			<td><?php echo htmlentities($product['name']); ?></td>
			<td><?php echo htmlentities($product['category']); ?></td>
			<td><?php echo htmlentities($product['price_leva']); ?></td>
			<td><?php echo htmlentities($product['available']); ?></td>
			<td><?php echo htmlentities($product['created_at']); ?></td>
			<td><?php echo htmlentities($product['updated_at']); ?></td>
			<td><a href="<?php echo site_url("employees/update_product/{$product['id']}"); ?>">Редактирай</a></td>
			<td><a href="<?php echo site_url("employees/delete_product/{$product['id']}"); ?>">Изтрий</a></td>
		  </tr>
		  <?php } ?>
		</tbody>
	  </table>
	</div>
	
</div>

</div>

<?php include 'dashboard_footer.php'; ?>


