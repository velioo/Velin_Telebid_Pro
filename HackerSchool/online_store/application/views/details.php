<?php require 'header.php'; ?>

<div id="body">
	
<h2>Моят профил</h2>	
	 <div class="vertical-menu">
      <a href="<?php echo site_url("users/cart"); ?>">Количка</a>
	  <a href="<?php echo site_url("users/orders"); ?>">Поръчки</a>
	  <a href="<?php echo site_url("users/account"); ?>">Настройки</a>
	  <a href="<?php echo site_url("users/details"); ?>" class="active">Детайли</a>
	</div>
	
</div>

<?php require 'footer.php'; ?>
