function generate_qrcode(value1, value2){
	$.ajax({
		type: 'post',
		url: 'includes/generate_qrcode.php',
		data: {cus_id: value1, table: value2},
		success: function(code){
			$('#qrDiv').show();
			$('#qrDiv').html(code);
			$('#qrDiv').addClass('col');
		}
	})
}

function removeQR(table){
	$('#qrDiv').removeClass('col');
	$('#bst'+table).removeClass('active');
	$('#qrDiv').hide();
	$('#qrcode').prop('checked', false);
}

function printValue(type){
	var currentPage = $('body').data("page");
	$.ajax({
		type:"POST",
		url:"includes/menus.inc.php",
		data:{type:type, currentPage:currentPage},
		success:function(data){
			$("#printDiv").html(data);
			$('.btn').removeClass('active');
		}
	});
}

function printDiv() {
	$('.print').hide();
	$('.sideMenu').hide();
	$('blockquote').hide();
	$('nav').hide();
	$('#myTop').hide();
	$(".g1").css("font-size", "25px");
	window.print();
	$('.print').show();
	$('.sideMenu').show();
	$('blockquote').show();
	$('nav').show();
	$('#myTop').show();
	$(".g1").css("font-size", "16px");
}

$('#bg_color').change(function() {
	var color = $('#bg_color').val();
	console.log(color);
	$('#menus_page').css('background', color);
});

$('#select').on('change', function() {
	var val = $( this ).val();
	printValue(val);
});


// nav_menu.inc.php
$('#logo').on('click', function() {
	if ($('#logo').prop('checked')) {
		// console.log('checked');
		$('#logoDiv').show();
	} else {
		// console.log('uncheck');
		$('#logoDiv').hide();
	}
});

$('#res_name').on('click', function() {
	if ($('#res_name').prop('checked')) {
		// console.log('checked');
		$('#resDiv').show();
	} else {
		// console.log('uncheck');
		$('#resDiv').hide();
	}
});

$('#qrcode').on('click', function() {
	if ($('#qrcode').prop('checked')) {
		// console.log('checked');
		$('#qrDiv').show();
	} else {
		// console.log('uncheck');
		$('#qrDiv').hide();
	}
});