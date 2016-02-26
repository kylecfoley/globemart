$(document).ready(function($){
	$('.megamenu').megaMenuCompleteSet({
		menu_speed_show : 0, // Time (in milliseconds) to show a drop down
		menu_speed_hide : 0, // Time (in milliseconds) to hide a drop down
		menu_speed_delay : 50, // Time (in milliseconds) before showing a drop down
		menu_show_onload : 0, // Drop down to show on page load (type the number of the drop down, 0 for none)
        menu_responsive:1, // 1 = Responsive, 0 = Not responsive
        open_close_toggle:1
	});
});