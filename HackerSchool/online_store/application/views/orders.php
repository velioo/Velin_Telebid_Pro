<?php require 'header.php'; ?>

<div id="body" style="width: 60%;">
	
<h2>Моят профил</h2>	
	 <div class="vertical-menu">
	  <a href="<?php echo site_url("users/orders"); ?>" class="active">Поръчки</a>
	  <a href="<?php echo site_url("users/account"); ?>">Настройки</a>
	  <a href="<?php echo site_url("users/details"); ?>">Детайли</a>
	</div>
	
</div>

<?php require 'footer.php'; ?>
