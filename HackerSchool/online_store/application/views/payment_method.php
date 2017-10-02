<?php require 'header.php'; ?>

<div id="body">
	
<h2>Изберете метод за плащане</h2>	
	 <div class="vertical-menu">
	  <a href="<?php echo site_url("users/cart"); ?>">Количка</a>
	  <a href="<?php echo site_url("users/orders"); ?>">Поръчки</a>
	  <a href="<?php echo site_url("users/payments"); ?>" class="active">Плащания</a>	  
	  <a href="<?php echo site_url("users/account"); ?>">Настройки</a>
	  <a href="<?php echo site_url("users/details"); ?>">Детайли</a>
	</div>
	
	<div class="account-info">
		<hr>
		<form action="<?php echo site_url("orders/select_payment"); ?>" method="post" class="form-horizontal login_register_form">
		<div class="cart_products">								
			<?php if($payment_methods) { foreach($payment_methods as $p) { if($p['id'] != 3) {?>
				<div class="radio">
				<img src="<?php echo asset_url() . "imgs/" . $p['image']; ?>" class="payment_image">
				  <label><input type="radio" value="<?php echo $p['id']; ?>" name="payment_method"><?php echo htmlentities($p['name'], ENT_QUOTES); ?></label>
				</div>
			<?php }}} ?>
		
		</div>	
		<div class="form-group form_submit">
			<button type="submit" value="Избери" id="paymentSubmit" name="paymentSubmit" class="btn btn-primary form_submit_button register">Избери</button>
        </div>  
		</form>		
	</div>
</div>

<?php require 'footer.php'; ?>
