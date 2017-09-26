<?php require 'header.php'; ?>

<div id="body">
<div id="wrap" style="width: 80%;">
<h2>Регистрация</h2>
    <form action="<?php echo site_url("users/registration"); ?>" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Име" required="" value="<?php echo !empty($user['name']) ? htmlspecialchars($user['name'], ENT_QUOTES) : ''; ?>">
          <?php echo form_error('name','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="email" placeholder="Имейл" required="" value="<?php echo !empty($user['email']) ? htmlspecialchars($user['email'], ENT_QUOTES) : ''; ?>">
          <?php echo form_error('email','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="phone" placeholder="Телефон" value="<?php echo !empty($user['phone']) ? htmlspecialchars($user['phone'], ENT_QUOTES) : ''; ?>">
            <?php echo form_error('phone','<span class="help-block">','</span>'); ?>
        </div>
         <div class="form-group">
            <input type="text" class="form-control" name="country" placeholder="Държава" value="<?php echo !empty($user['country']) ? htmlspecialchars($user['country'], ENT_QUOTES) : ''; ?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="region" placeholder="Регион" value="<?php echo !empty($user['region']) ? htmlspecialchars($user['region'], ENT_QUOTES) : ''; ?>">
        </div>
         <div class="form-group">
            <input type="text" class="form-control" name="street_address" placeholder="Адрес" value="<?php echo !empty($user['street_address']) ? htmlspecialchars($user['street_address'], ENT_QUOTES) : ''; ?>">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="password" placeholder="Парола" required="">
          <?php echo form_error('password','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="conf_password" placeholder="Потвърждение на паролата" required="">
          <?php echo form_error('conf_password','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <?php
            if(!empty($user['gender']) && $user['gender'] == 'Female'){
                $fcheck = 'checked="checked"';
                $mcheck = '';
            }else{
                $mcheck = 'checked="checked"';
                $fcheck = '';
            }
            ?>
            <div class="radio">
                <label>
                <input type="radio" name="gender" value="Male" <?php echo $mcheck; ?>>
                Мъж
                </label>
            </div>
            <div class="radio">
                <label>
                  <input type="radio" name="gender" value="Female" <?php echo $fcheck; ?>>
                  Жена
                </label>
            </div>
        </div>
        <div class="form-group">
            <input type="submit" name="registrSubmit" class="btn-primary" value="Регистрация"/>
        </div>
    </form>
    <p class="footInfo">Вече имаш профил? <a href="<?php echo base_url(); ?>users/login">Влез</a></p>       
</div>
</div>

<?php require 'footer.php'; ?>
