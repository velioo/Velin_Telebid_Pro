<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $title; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
<link rel="stylesheet" href="<?php echo asset_url() . "css/main.css"; ?>"> 
 
</head>
<body>
	
<div id="holder">	
	
<nav class="navbar navbar-fixed-top" id="navigation_top">
  <div class="container-fluid" style="width: 1150px;">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo site_url(); ?>">Computer Store</a>
    </div>
    <form class="navbar-form navbar-left">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search">
        <div class="input-group-btn">
          <button class="btn btn-default" type="submit">
            <i class="glyphicon glyphicon-search"></i>
          </button>
        </div>
      </div>
    </form>
    <ul class="nav navbar-nav navbar-right">
	  <?php if(!$this->session->userdata('isUserLoggedIn')) { ?>
		  <li><a href="<?php echo site_url("users/registration"); ?>"><span class="glyphicon glyphicon-user"></span> Регистрация</a></li>
		  <li><a href="<?php echo site_url("users/login"); ?>"><span class="glyphicon glyphicon-log-in"></span> Вход</a></li>
      <?php } else { ?>
		  <li><a href="<?php echo site_url("users/account"); ?>"><span class="glyphicon glyphicon-user"></span> Моят профил</a></li>
		  <li><a href="<?php echo site_url("users/logout"); ?>"><span class="glyphicon glyphicon-log-in"></span> Изход</a></li>
	  <?php } ?>
    </ul>
  </div>	
	
<nav class="navbar navbar-fixed-top" id="navigation_top2">
  <div class="container-fluid" style="width: 1150px; margin-top:70px;">
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Начало</a></li>
      <li><a href="#">Лаптопи</a></li>
      <li><a href="#">Компютри</a></li>
      <li><a href="#">Монитори</a></li>
      <li><a href="#">Компоненти</a></li>
      <li><a href="#">Периферия</a></li>
    </ul>
  </div>
</nav>
