$(function(){
	var unsaved = false;
	$("#tdoc_form input, #tdoc_form select, #tdoc_form textarea").bind("change", function() {
		unsaved = true;
	});
	$("button").bind("click", function() {
		unsaved = false;
	});
	function unloadPage(){ 
		if (unsaved)
			return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
	}
	window.onbeforeunload = unloadPage;
});