<?php /* @var $this BaseController */ ?>
<html xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="language" content="en"/>
	<title><?= CHtml::encode($this->pageTitle) ?></title>

	<?
	$this->client_script->registerScriptFile('js/jquery-2.1.1.min.js');

	$this->client_script->registerCssFile('css/bootstrap.min.css');
	$this->client_script->registerCssFile('css/bootstrap-theme.min.css');
	$this->client_script->registerScriptFile('js/bootstrap.min.js');
	?>

</head>
<body>
	<div class="container">
		<?= $content ?>
	</div>
	</body>
</html>