<?php
/**
 * @var $this BaseController
 * @var $events Events[]
 * @var $others Users[]
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
			<p class="navbar-text navbar-right"><?= $this->user->profile->email ?></p>
		</div>
	</div>
</nav>
<div class="panel panel-default col-md-7">
	<form id="event-form" class="form-horizontal" action="<?= Yii::app()->createUrl('site/editEvent'); ?>" method="post" onsubmit="return ajax_submit(this)">
		<div class="text-success">Information for events on <span id="form-date"></span> <span id="form-time"></span></div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Title</label>
			<div class="col-sm-10">
					<input type="text" class="form-control" name="title" placeholder="Title for event">
				</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Type</label>
			<div class="col-sm-10">
					<input type="text" class="form-control" name="type" placeholder="Type of the event">
				</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Attached user</label>
			<div class="col-sm-10">
				<select name="attach_user" class="form-control">
					<option value="">[no user]</option>
					<?php foreach($others as $other_user):?>
					    <option value="<?= $other_user->id; ?>"><?= $other_user->email; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Text</label>
			<div class="col-sm-10">
				<textarea name="text" class="form-control"></textarea>
			</div>
		</div>

		<div class="form-group col-md-5 pull-right" id="create-group">
			<button type="submit" class="form-control btn btn-success">
				<span class="glyphicon glyphicon-plus-sign"></span> Create
			</button>
		</div>


		<div id="edit-group" class="hide">
			<div class="form-group col-md-5 pull-right" id="">
				<button type="submit" class="form-control btn btn-success">
					<span class="glyphicon glyphicon-edit"></span> Edit
				</button>
			</div>
			<div class="form-group col-md-5">
				<button type="button" class="form-control btn btn-default" id="remove-button"
						onclick="ajax_remove_event();" data-url="<?= Yii::app()->createUrl('site/removeEvent'); ?>">
					<span class="glyphicon glyphicon-remove-sign"></span> Remove
				</button>
			</div>
		</div>

		<input type="hidden" name="date" value=""/>
		<input type="hidden" name="time_hour" value="">
		<input type="hidden" name="event_id" value="0">
	</form>
</div>
<div class="panel panel-default col-md-3 panel-calendar pull-right">
	<div class="panel-body ">
		<div id="calendar"></div>
		<button id="last-week" class="btn btn-default col-md-6" onclick="last_week()"><span class="glyphicon glyphicon-chevron-left"></span> Last week</button>
		<button id="next-week" class="btn btn-default col-md-6" onclick="next_week()">Netx week <span class="glyphicon glyphicon-chevron-right"></span></button>
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
	<?php for ($i = 7; $i < 24;$i++): ?>
		<tr>
			<td data-hour="<?= $i; ?>" class="static"><?= sprintf('%02d', $i); ?>:00</td>
			<?php for($j = 1; $j <= 7; $j++): ?>
				<td class="day-cell" data-hour="<?= $i; ?>" data-day="<?= $j == 7 ? 0 : $j; ?>"></td>
			<?php endfor; ?>
		</tr>
	<?php endfor; ?>
	</tbody>
</table>
<script type="application/json" id="events">
	<?= Ajax::modelToJson($events); ?>
</script>