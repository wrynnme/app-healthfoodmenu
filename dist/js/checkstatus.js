function check_status() {
	$.ajax({
		url: 'includes/check_status.inc.php?status',
		success: function(data) {
			// console.log(data);
			if (data == '0') {
				window.location.href="includes/logout.inc.php";
			}
		}
	}).always(function() {
		console.log("complete status checking");
	});
}

function check_online(value) {
	$.ajax({
		url: 'includes/check_status.inc.php',
		type: 'get',
		data: {online: value},
		success: function(data) {
			// console.log(data);
			if (data == '0') {
				// window.location.href="includes/logout.inc.php";
			}
		}
	}).always(function() {
		console.log("complete online checking");
	});
}