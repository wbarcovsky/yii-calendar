<?php
/**
 * @var $this BaseController
 * @var $events Events[]
 */

$this->pageTitle = 'Wellcome!';
$this->client_script->registerCssFile('css/index.css');
$this->client_script->registerScriptFile('js/index.js');
?>
<nav class="navbar navbar-default alert alert-success" role="navigation" xmlns="http://www.w3.org/1999/html">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">Wellcome</a>
		</div>
		<div class="collapse navbar-collapse">
			<p class="navbar-text navbar-right">
				<a href="<?= Yii::app()->createUrl('site/logout') ?>"><span class="glyphicon glyphicon-log-out"></span> Log out</a>
			</p>
			<p class="navbar-text navbar-right"><?= $this->user->profile->email?></p>
		</div>
	</div>
</nav>
<div class="panel panel-default col-md-3 row">
	<div class="panel-body ">
		<div id="calendar"></div>
	</div>
</div>
<table class="table table-bordered">
	<thead>
	<tr>
		<th></th>
		<th>Monday<br><span data-day="1" class="sub-day">12/14</span></th>
		<th>Tuesday<br><span data-day="2" class="sub-day">12/14</span></th>
		<th>Wednesday<br><span data-day="3" class="sub-day">12/14</span></th>
		<th>Thursday<br><span data-day="4" class="sub-day">12/14</span></th>
		<th>Friday<br><span data-day="5" class="sub-day">12/14</span></th>
		<th>Saturday<br><span data-day="6" class="sub-day">12/14</span></th>
		<th>Sunday<br><span data-day="0" class="sub-day">12/14</span></th>
	</tr>
	</thead>
	<tbody>
	<? for ($i = 7; $i < 24;$i++): ?>
		<tr>
			<td data-hour="<?= $i; ?>"><?= sprintf('%02d', $i); ?>:00</td>
			<?php for($j = 1; $j <= 7; $j++): ?>
				<td class="day-cell" data-hour="<?= $i; ?>" data-day="<?= $j == 7 ? 0 : $j; ?>"></td>
			<? endfor; ?>
		</tr>
	<? endfor; ?>
	</tbody>
</table>
<script type="application/json" id="events">
{
	<?php echo json_encode($events); ?>
}
</script>