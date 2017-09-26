<?php require 'header.php'; ?>

<div id="body">
<div id="wrap" style="width: 80%;">
<h2>Влез в профил</h2>
    <?php
	if(!empty($this->session->userdata('success_msg'))){
		echo '<p class="statusMsg">' . $this->session->userdata('success_msg') . '</p>';
		$this->session->unset_userdata('success_msg');
	} elseif(!empty($this->session->userdata('error_msg'))) {
		echo '<p class="statusMsg">' . $this->session->userdata('error_msg') . '</p>';
		$this->session->unset_userdata('error_msg');
	}
    ?>
    <form action="<?php echo site_url("users/login"); ?>" method="post">
        <div class="form-group has-feedback">
            <input type="email" class="form-control" name="email" placeholder="Имейл" required="" value="" autocomplete="off">
            <?php echo form_error('email','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="password" placeholder="Парола" required="">
          <?php echo form_error('password','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <input type="submit" name="loginSubmit" class="btn-primary" value="Вход"/>
        </div>
    </form>
    <p class="footInfo">Няма профил? <a href="<?php echo base_url(); ?>users/registration">Регистрирай се</a></p>
</div>
</div>

<?php require 'footer.php'; ?>
