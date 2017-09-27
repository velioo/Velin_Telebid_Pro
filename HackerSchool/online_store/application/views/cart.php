<?php require 'header.php'; ?>

<div id="body">
	
<h2>Количка</h2>	
	 <div class="vertical-menu">
	  <a href="<?php echo site_url("users/cart"); ?>" class="active">Количка</a>
	  <a href="<?php echo site_url("users/orders"); ?>">Поръчки</a>
	  <a href="<?php echo site_url("users/account"); ?>">Настройки</a>
	  <a href="<?php echo site_url("users/details"); ?>">Детайли</a>
	</div>
	
	<div class="account-info">
		<hr>
		<div class="cart_products">
			<?php if(isset($products)) foreach($products as $p) { ?>
				<div class="cart_product">
					<div class="cart_product_image_div"><a href="#"><img src="<?php echo ($p['image'] != '') ? asset_url() . "imgs/" . htmlspecialchars($p['image'], ENT_QUOTES) : ""; ?>" onerror="this.src='<?php echo asset_url() . "imgs/no_image.png" ?>';" class="cart_product_image"></a></div>
					<div class="cart_product_name_div"><h3 class="cart_product_name"><?php echo htmlspecialchars($p['name'], ENT_QUOTES); ?></h3></div>
					<div class="cart_product_price"><p style="font-size: 18px;">Цена: <?php echo htmlspecialchars($p['price_leva'], ENT_QUOTES) . " лв."; ?></p></div>						
				</div>
			<?php } ?>
		</div>	
		<h3 class="cart_sum">Обща сума: </h3>
	</div>
</div>

<?php require 'footer.php'; ?>
