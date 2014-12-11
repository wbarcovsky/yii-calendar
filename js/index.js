var current_date = new Date();
var current_hour = 7;

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
	return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate()
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
	events.forEach(function(event)
	{
		$('.table').find('td[data-today=' + event.date +'][data-hour=' + event.time_hour + ']').addClass('event').text(event.title);
		if (event.date == my_date_format(current_date) && event.time_hour == current_hour)
		{
			console.log(event);
			$("input[name='title']").val(event.title);
			$("input[name='type']").val(event.type);
			$("input[name='event_id']").val(event.id);
			$("textarea[name='text']").val(event.text);
			$("select>option[value='" + event.attach_user + "']").attr('selected', 'selected');
			$('#create-group').addClass('hide');
			$('#edit-group').removeClass('hide');

		}
	});
}