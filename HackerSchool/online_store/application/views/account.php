<?php require 'header.php'; ?>

<div id="body" style="width: 60%;">

<h2>Моят профил</h2>
    <div class="vertical-menu">
	  <a href="<?php echo site_url("users/orders"); ?>">Поръчки</a>
	  <a href="<?php echo site_url("users/account"); ?>" class="active">Настройки</a>
	  <a href="<?php echo site_url("users/details"); ?>">Детайли</a>
	</div>
    <div class="account-info">
		<div class="profile_tab_title">Настройки</div>
		<hr>
		<h3>Промяна на парола</h3>
		 <?php
			if(!empty($this->session->userdata('success_msg'))){
				echo '<p class="statusMsg">' . $this->session->userdata('success_msg') . '</p>';
				$this->session->unset_userdata('success_msg');
			} elseif(!empty($this->session->userdata('error_msg'))) {
				echo '<p class="statusMsg">' . $this->session->userdata('error_msg') . '</p>';
				$this->session->unset_userdata('error_msg');
			}
		?>
		
		<form action="<?php echo site_url("users/update_password"); ?>" method="post">
			<div class="form-group">
			  <input type="password" class="form-control" name="password" placeholder="Парола" required="">
			  <?php echo form_error('password','<span class="help-block">','</span>'); ?>
			</div>
			<div class="form-group">
			  <input type="password" class="form-control" name="conf_password" placeholder="Потвърждение на паролата" required="">
			  <?php echo form_error('conf_password','<span class="help-block">','</span>'); ?>
			</div>
			<div class="form-group">
				<input type="submit" name="passwordSubmit" class="btn-primary" value="Промени"/>
			</div>
		</form>
		
		<h3>Промяна на име и имейл</h3>
		<form action="<?php echo site_url("users/update_name_email"); ?>" method="post">
			<div class="form-group">
				<input type="text" class="form-control" name="name" placeholder="Име" required="" value="<?php echo !empty($user['name']) ? $user['name'] : ''; ?>">
			  <?php echo form_error('name','<span class="help-block">','</span>'); ?>
			</div>
			<div class="form-group">
				<input type="email" class="form-control" name="email" placeholder="Имейл" required="" value="<?php echo !empty($user['email']) ? $user['email'] : ''; ?>">
			  <?php echo form_error('email','<span class="help-block">','</span>'); ?>
			</div>
			<div class="form-group">
				<input type="submit" name="nameEmailSubmit" class="btn-primary" value="Промени"/>
			</div>
		</form>
    </div>
</div>

<?php require 'footer.php'; ?>
