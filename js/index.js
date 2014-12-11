var current_date = new Date();
var current_hour = 7;
var current_event = null;
$(document).ready(function()
{
	$('#calendar').datepicker(
	{
		todayHighlight: true,
		weekStart: 1
	}).on('click', function()
	{
		set_new_date($('#calendar').datepicker('getDate'));
	});

	$(".table>tbody>tr>td:not('.static')").on('click', function()
	{
		current_hour = $(this).data('hour');

		var choosen_day = $(this).data('day');
		current_date = week_day_diff(current_date, choosen_day);

		update_datepicker();
		set_new_date(current_date);
	});

	set_new_date(current_date);
	update_datepicker();

	$(".table td:not(.static)").kendoDraggable({
		hint: function() {
			return $("#draggable").clone();
		},
		dragstart: onDragStart,
		dragend: onDragEnd
	});
	$(".table td:not(.static)").kendoDropTarget(
	{
		dragenter: droptargetOnDragEnter,
		dragleave: droptargetOnDragLeave,
		drop: droptargetOnDrop
	});
});

/**
 * Calculate day of week on the same week as current date
 * @param Date date
 * @param int dow Day of Week (0 - Sunday 6 - Saturday)
 * @returns {Date}
 */
function week_day_diff(date, dow)
{
	var dow1 = date.getDay() == 0 ? 7 : date.getDay();
	dow = dow == 0 ? 7 : dow;
	var res = new Date();
	res.setTime(date.getTime() + (dow - dow1) * 86400000);
	return res;
}

function update_datepicker()
{
	$('#calendar').datepicker('setDate', current_date);
	$('#calendar').find("td").removeClass('active');
	$('#calendar').find("td:not('.old'):not('.new')").each(function()
	{
		if ($(this).text() == current_date.getDate())
		{
			$(this).addClass('active');
		}
	});
}

function my_date_format(date)
{
	return date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);
}

function set_new_date(new_date)
{
	if ( ! isNaN(new_date.getDay()))
	{
		current_date = new_date;
	}

	var dow = current_date.getDay();
	var day = current_date.getDate();

	for(var i = 0; i < 7; i++)
	{
		var calc_day = week_day_diff(current_date, i);
		$('.sub-day[data-day=' + i +']').text(calc_day.getDate() + '/' + (calc_day.getMonth() + 1));
		$('.table').find('td[data-day=' + i +']').attr('data-today', my_date_format(calc_day));
	}

	$('.table').find('td').removeClass('current');
	$('td[data-day=' + dow +'][data-hour=' + current_hour +']').addClass('current');

	$("input[name='date']").val(my_date_format(current_date));
	$("input[name='time_hour']").val(current_hour);
	$('#form-date').text(current_date.toLocaleDateString());
	$('#form-time').text(current_hour + ':00');
	update_events();
}

function update_events()
{
	var events = JSON.parse($('#events').text());
	$('.table').find("td:not(.static)").removeClass('event').text('');
	$("input[name='title']").val('');
	$("input[name='type']").val('');
	$("input[name='event_id']").val(0);
	$("textarea[name='text']").val('');
	$("select>option:selected").removeAttr('selected');
	$('#create-group').removeClass('hide');
	$('#edit-group').addClass('hide');
	current_event = null;
	events.forEach(function(event)
	{
		$('td[data-today="' + event.date +'"][data-hour="' + event.time_hour + '"]').addClass('event').text(event.title);
		console.log('td[data-today="' + event.date +'"][data-hour="' + event.time_hour + '"]');
		if (event.date == my_date_format(current_date) && event.time_hour == current_hour)
		{
			$("input[name='title']").val(event.title);
			$("input[name='type']").val(event.type);
			$("input[name='event_id']").val(event.id);
			$("textarea[name='text']").val(event.text);
			$("select>option[value='" + event.attach_user + "']").attr('selected', 'selected');
			$('#create-group').addClass('hide');
			$('#edit-group').removeClass('hide');
			current_event = event;
		}
	});
}

function ajax_remove_event()
{
	swal({
		title: "Are you sure?",
		text: "You will not be able to recover this event!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Yes, delete it!",   closeOnConfirm: false
	},
	function()
	{
		console.log('1');
		var data = {};
		data.id = $("input[name='event_id']").val();
		console.log(data);
		var url = $("#remove-button").data('url');
		console.log(url);
		$.post(url, data, function(msg)
		{
			//console.log(msg);
			ajax_response(msg);
		}).error(function(e)
		{
			console.log(e);
		});
	});
}

function upload_events(json)
{
	$('#events').text(json);
	set_new_date(current_date);
	swal('Event successfully saved!', '', 'success');
}

function remove_events(json)
	{
	$('#events').text(json);
	set_new_date(current_date);
	swal('Event successfully removed', '', 'success');
}

function onDragStart(e)
{
	$(e.target).click();
	$('.table').css('cursor', 'move');
}

function onDragEnd()
{
	$('.table').css('cursor', 'default');
}

function droptargetOnDragEnter(e)
{
	if (current_event != null)
	{
		$(e.dropTarget).addClass('current');
		$(e.dropTarget).text(current_event.title);
	}
}

function droptargetOnDragLeave(e)
{
	if (current_event != null)
	{
		$(e.dropTarget).removeClass('current');
		$(e.dropTarget).text('');
	}
}

function droptargetOnDrop(e)
{
	if (current_event != null)
	{
		$("input[name='date']").val($(e.dropTarget).data('today'));
		$("input[name='time_hour']").val($(e.dropTarget).data('hour'));
		$('#event-form').submit();
	}
	$(e.dropTarget).click();
}