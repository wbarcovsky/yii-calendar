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
	$('#calendar').find("td").each(function()
	{
		if ($(this).text() == current_date.getDate())
		{
			$(this).addClass('active');
		}
	});
}

function set_new_date(new_date)
{
	if ( ! isNaN(new_date.getDay()))
	{
		current_date = new_date;
	}

	var dow =  current_date.getDay();
	var day = current_date.getDate();

	for(var i = 0; i < 7; i++)
	{
		var calc_day = week_day_diff(current_date, i);
		$('.sub-day[data-day=' + i +']').text(calc_day.getDate() + '/' + (calc_day.getMonth() + 1));
	}

	$('.table').find('td').removeClass('current');
	$('td[data-day=' + dow +'][data-hour=' + current_hour +']').addClass('current');

}
