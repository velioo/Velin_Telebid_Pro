<?php require 'header.php'; ?>

<div id="body">
	
<h2>Количка</h2>	
	 <div class="vertical-menu">
	  <a href="<?php echo site_url("users/cart"); ?>" class="active">Количка</a>
	  <a href="<?php echo site_url("users/orders"); ?>">Поръчки</a>
	  <a href="<?php echo site_url("users/payments"); ?>">Плащания</a>	
	  <a href="<?php echo site_url("users/account"); ?>">Настройки</a>
	  <a href="<?php echo site_url("users/details"); ?>">Детайли</a>
	</div>
	
	<div class="account-info">
		<hr>
		<div class="cart_products">
			<?php if($products) { foreach($products as $p) { ?>
				<div class="cart_product">
					<div class="cart_product_image_div"><a href="#"><img src="<?php echo ($p['image'] != '') ? asset_url() . "imgs/" . htmlspecialchars($p['image'], ENT_QUOTES) : ""; ?>" onerror="this.src='<?php echo asset_url() . "imgs/no_image.png" ?>';" class="cart_product_image"></a></div>
					<div class="cart_product_name_div"><h3 class="cart_product_name"><?php echo htmlspecialchars($p['name'], ENT_QUOTES); ?></h3></div>
					<div class="cart_product_price"><p style="font-size: 18px;">Цена: <?php echo htmlspecialchars($p['price_leva'], ENT_QUOTES) . " лв."; ?></p></div>						
				</div>
			<?php } echo '<div class="cart_purchase_div"><h3 class="cart_sum">Обща сума: </h3>' . '<a href="' . site_url("orders/create_order") . '"> <button type="button" class="btn btn-default purchase_button">
						  <span class="glyphicon glyphicon-shopping-cart"></span> Плати</button></a></div>'; } else echo "<h3>Нямате продукти в кошницата</h3>"; ?>
		</div>			
	</div>
</div>

<?php require 'footer.php'; ?>
