<?php
/* @var $this BaseController */
$this->client_script->registerCssFile('css/login.css');
?>
<br/>
<div class="jumbotron text-center">
	<h2 class="text-success">Wellcome to my test web-application!</h2>
	<p>Please, write your email to start working</p>
	<form class="form-group" action="<?= Yii::app()->createUrl('site/login'); ?>" method="post" onsubmit='return ajax_submit(this)'>
		<div class="form-horizontal">
			<div class="col-md-6 col-md-offset-2">
				<input type="text" class="form-control" name="email" />
			</div>
			<div class="col-md-2">
				<input type="submit" class="form-control btn btn-success" value="Send!" />
			</div>
		</div>
	</form>
</div>
<script>
	function show_register()
	{
		console.log('Show register');
	}
	function show_login()
	{
		console.log('Show login!');
	}
</script>