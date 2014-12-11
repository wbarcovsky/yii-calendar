<?php /* @var $this BaseController */ ?>
<html xml:lang="en" lang="en">
<head>
	<?= CHtml::scriptFile('js/jquery-2.1.1.min.js');?>
	<?= CHtml::scriptFile('js/bootstrap.min.js');?>
	<?= CHtml::scriptFile('js/bootstrap-datepicker.js');?>
	<?= CHtml::scriptFile('js/bootstrap-datepicker.js');?>
	<?= CHtml::scriptFile('js/sweet-alert.min.js');?>
	<?= CHtml::scriptFile('js/kendo.all.min.js');?>
	<?= CHtml::scriptFile('js/ajax-form.js');?>

	<?= CHtml::cssFile('css/bootstrap.min.css');?>
	<?= CHtml::cssFile('css/bootstrap-theme.min.css');?>
	<?= CHtml::cssFile('css/datepicker3.css');?>
	<?= CHtml::cssFile('css/sweet-alert.css');?>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="language" content="en"/>
	<title><?= CHtml::encode($this->pageTitle) ?></title>
</head>
<body>
	<div class="container">
		<?= $content ?>
	</div>
	</body>
</html>