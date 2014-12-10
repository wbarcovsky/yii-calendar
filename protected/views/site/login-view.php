<?php
/* @var $this BaseController */
$this->client_script->registerCssFile('css/login.css');
?>
<br/>
<div class="jumbotron text-center">
	<h2 class="text-success">Wellcome to my test web application!</h2>

	<p>Please write your email to start</p>

	<form id="login-form" class="form-group disaled" action="<?= Yii::app()->createUrl('site/login'); ?>" method="post"
		  onsubmit='return ajax_submit(this)'>
		<fieldset>
			<input type="text" class="form-control" name="email" placeholder="Enter your email" onkeydown="change_email()"/>

			<div id="login-fields" style="display: none;">
				<div class="row">
					<p class="alert alert-success col-md-6 col-md-offset-3">Enter your password to sing in!</p>
				</div>
				<input name="password" type="password" class="form-control" placeholder="Enter your pasword" />
			</div>

			<div id="register-fields" style="display: none;">
				<div class="row">
					<p class="alert alert-success col-md-6 col-md-offset-3">This email not registred in our system<br/>Enter your password to create new account!</p>
				</div>
				<input name="password_new" class="form-control" type="password" placeholder="Enter your pasword" />
				<input name="password_repeat" class="form-control" type="password" placeholder="Confirm your pasword" />
			</div>

			<input type="submit" class="form-control btn btn-success" value="Send!"/>
			<input type="hidden" name="action" value="check">
		</fieldset>
	</form>
</div>
<script>
	function show_register()
	{
		$('#register-fields').slideDown('slow');
		$('#login-form').find("input[name='action']").val('<?= FormLogin::ACTION_REGISTER; ?>');
	}

	function show_login()
	{
		$('#login-fields').slideDown('slow');
		$('#login-form').find("input[name='action']").val('<?= FormLogin::ACTION_LOGIN; ?>');
	}

	function change_email()
	{
		if($('#login-form').find("input[name='action']").val() != 'check')
		{
			$('#login-form').find("input[name='action']").val('check');
			$('#login-form').find("input[name='password']").val('');
			$('#login-form').find("input[name='password_new']").val('');
			$('#login-form').find("input[name='password_repeat']").val('');
			$('#register-fields').css('display', 'none');
			$('#login-fields').css('display', 'none');
		}
	}
</script>