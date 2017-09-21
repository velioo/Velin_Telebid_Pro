<?php require 'header.php'; ?>

<div id="body">

<h2>Вход за служители</h2>
    <?php
	if(!empty($this->session->userdata('success_msg'))){
		echo '<p class="statusMsg">' . $this->session->userdata('success_msg') . '</p>';
		$this->session->unset_userdata('success_msg');
	} elseif(!empty($this->session->userdata('error_msg'))) {
		echo '<p class="statusMsg">' . $this->session->userdata('error_msg') . '</p>';
		$this->session->unset_userdata('error_msg');
	}
    ?>
    <form action="<?php echo site_url("employees/login"); ?>" method="post">
        <div class="form-group has-feedback">
            <input type="text" class="form-control" name="username" placeholder="Потребителско име" required="" value="" autocomplete="off">
            <?php echo form_error('username','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="password" placeholder="Парола" required="">
          <?php echo form_error('password','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <input type="submit" name="loginSubmit" class="btn-primary" value="Вход"/>
        </div>
    </form>

</div>

<?php require 'footer.php'; ?>
