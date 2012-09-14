<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<title>SMARTER - eVSC mockup</title> 
	<?php echo $html->meta('favicon.ico', $html->url('/favicon.ico'), array('type' => 'icon')); ?>
	<?php echo $html->css('cake.generic.css'); ?>
	<?php echo $html->css('custom.css'); ?>
	<?php echo $html->script('jquery'); ?>
	<?php # echo $html->script('jquery.jplayer.min'); ?>
	<?php echo $html->script('mediaplayer'); ?>
    <?php echo $scripts_for_layout; ?>
</head> 
<body> 
	<div id="container">	
		<?php if($this->params['action'] != "main") : ?>
		<h2  style="margin: auto; text-align: center;">
		[<?php echo $html->link(__('Home', true), array('controller' => 'categories', 'action' => 'main')); ?>]
		[<?php echo $html->link(__('Edit Categories', true), array('controller' => 'categories', 'action' => 'index')); ?>]
		</h2>
		<?php endif; ?>
		<div id="content"> 
		<?php 
			echo $this->Session->flash('auth');
			echo $session->flash();
			echo $content_for_layout;
		?>

		</div>
		<h4>
		[<?php echo $html->link(__('Edit Categories', true), array('controller' => 'categories', 'action' => 'index')); ?>]
		</h4>
</div>
</body> 
</html>

