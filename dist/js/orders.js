$(document).ready(function() {
	$('#confrim').hide();
	$('#checkbill').hide();
	var size  = $('body').attr('data-size');
	var price = $('body').attr('data-price');
	var submit = $('body').attr('data-x');
	if (parseInt(size) > 0) {
		$('#confrim').show();
	}
	if (price != 0) {
		$('#checkbill').show();
	}
});