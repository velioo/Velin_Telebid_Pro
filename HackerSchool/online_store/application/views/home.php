<?php require 'header.php'; ?>

<div id="body">
<div id="wrap">
	
<div class="container-fluid">
	 
<div class="row row-eq-height">
	  
  <?php $row = 0; if($products) foreach($products as $p) { ?>	 
	 <?php if($row % 4 == 0 && $row != 0) { ?>
		</div>
		<div class="row row-eq-height">
	 <?php } ?>
	 
	<div class="col-sm-3 product">
		<a href="#" class="product_image"><img src="<?php echo ($p['image'] != '') ? asset_url() . "imgs/" . htmlspecialchars($p['image'], ENT_QUOTES) : ""; ?>" onerror="this.src='<?php echo asset_url() . "imgs/no_image.png" ?>';" class="product_image"></a></br></br>
		<a href="#" class="product_name no_underline">Име: <?php echo htmlspecialchars($p['name'], ENT_QUOTES); ?></a></br>
		<a href="#" class="product_category no_underline">Категория: <?php echo htmlspecialchars($p['category'], ENT_QUOTES); ?></a></br>		
		<div class="product_price"><p style="font-size: 18px;">Цена: <?php echo htmlspecialchars($p['price_leva'], ENT_QUOTES) . " лв."; ?></p></div>
			
	</div>

  <?php $row++; } else echo "Няма налични продукти в момента."?>
  
</div>

<div style="text-align:center;">
	<?php if(isset($pagination)) echo $pagination; ?>
</div>
</div> 

</div>
</div>

<?php require 'footer.php'; ?>
