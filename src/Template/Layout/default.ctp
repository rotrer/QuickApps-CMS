<!DOCTYPE html>
<html lang="en">
  <head>
    <?php echo $this->Html->charset(); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $this->fetch('title'); ?></title>
	<?php echo $this->Html->meta('icon'); ?>
	<?php echo $this->Html->css('bootstrap.min.css'); ?>
	<?php echo $this->fetch('meta'); ?>
	<?php echo $this->fetch('css'); ?>
	<?php echo $this->fetch('script'); ?>
	<style>
		body { padding-top: 50px;}
		.starter-template {
			padding: 40px 15px;
			text-align: center;
		}
	</style>
  </head>

  <body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">
      <?php echo $this->fetch('content'); ?>
      <?php $this->element('sql_dump'); ?>
    </div><!-- /.container -->
  </body>
</html>
