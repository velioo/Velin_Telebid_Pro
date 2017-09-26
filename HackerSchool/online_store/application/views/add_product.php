<?php include 'dashboard_header.php'; ?>

<div id="body" style="width: 100%;">

<div class="vertical-menu employee">
	  <a href="<?php echo site_url("employees/dashboard"); ?>">Виж всички продукти</a>
	  <a href="<?php echo site_url("employees/add_product"); ?>" class="active">Добави продукт</a>
</div>

<div class="account-info employee">
	<div class="profile_tab_title">Добави продукт</div>
	<hr>
	
	<?php
		if(!empty($this->session->userdata('success_msg'))){
			echo '<p class="statusMsg">' . $this->session->userdata('success_msg') . '</p>';
			$this->session->unset_userdata('success_msg');
		} elseif(!empty($this->session->userdata('error_msg'))) {
			echo '<p class="statusMsg">' . $this->session->userdata('error_msg') . '</p>';
			$this->session->unset_userdata('error_msg');
		}
		
		echo isset($product['image_error']) ? '<p class="statusMsg">' . $product['image_error']['error'] . '</p>' : '';
	?>
	
	<form action="<?php echo site_url("products/insert_product"); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
			<label for="name">Име на продукта:</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="*Име" required="" value="<?php echo !empty($product['name']) ? htmlentities($product['name']) : ''; ?>">
            <?php echo form_error('name','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <label for="description">Описание:</label>
			<textarea class="form-control" rows="5" id="description" name="description" placeholder="Описание"><?php echo !empty($product['description']) ? htmlentities($product['description']) : ''; ?></textarea>		
        </div>
        <div class="form-group">
			 <label for="category_id">*Категория:</label>
			 <select name="category_id" id="category" class="form-control">
				<?php foreach($categories as $category) { ?>
					<option value="<?php echo htmlentities($category['id']); ?>" <?php if(isset($product['category_id'])) { echo ($category['id'] == $product['category_id']) ? 'selected' : ''; }?> ><?php echo htmlentities($category['name']); ?></option>
				<?php } ?>
			 </select> 
			 <?php echo form_error('category','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <label for="price_leva">*Цена в лв:</label>
			<input type="number" value="<?php echo !empty($product['price_leva']) ? htmlentities($product['price_leva']) : ''; ?>" min="0" step="0.01" name="price_leva" id="price_leva" />
			 <?php echo form_error('price_leva','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
			 <?php
				if(!empty($product['available']) && $product['available'] == '0'){
					$not_available = 'checked="checked"';
					$available = '';
				}else{
					$available = 'checked="checked"';
					$not_available = '';
				}
            ?>
            <div class="radio">
                <label>
                <input type="radio" name="available" value="1" <?php echo $available; ?>>
                Наличен
                </label>
            </div>
            <div class="radio">
                <label>
                  <input type="radio" name="available" value="0" <?php echo $not_available; ?>>
                  Не е наличен
                </label>
            </div>
             <?php echo form_error('available','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <label for="image">Изображение на продукта:</label>
			<input type="file" name="image" accept="image/*" size="20">
        </div>
        <div class="form-group">
            <input type="submit" name="productSubmit" class="btn-primary" value="Добави"/>
        </div>
    </form>
	
</div>
</div>

<?php include 'dashboard_footer.php'; ?>


