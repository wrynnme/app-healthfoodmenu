$(document).ready(function() {
// $(window).on("load", function(){
	$('.tr-dif').hide();
	$('.tr-add').hide();
	$('.tr-mod').hide();
	$('.btn-event').on('click', function(){
		var id = $(this).attr("id");
		console.log(id);
		$('#show').show();
		$('.ee').hide();
		$('#t'+id).show();
		switch(id) {
			case 'add':
			$('.tr-add').show();
			$('.tr-dif').hide();
			$('.tr-mod').hide();
			$('.data').show();
			break;
			case 'dif':
			$('.tr-add').hide();
			$('.tr-dif').show();
			$('.tr-mod').hide();
			$('.data').show();
			break;
			case 'mod':
			$('.tr-add').hide();
			$('.tr-dif').hide();
			$('.tr-mod').show();
			break;
		}
	});
	$("#selectall").click(function(){
		$('.custom-control-input').prop('checked', true);
	});
	$("#deselectall").click(function(){
		$('.custom-control-input').prop('checked', false);
	});
	$('#delete').click(function(){
		Swal.fire({
			title: 'คุณต้องการที่จะลบ?',
			text: "คุณต้องการลบประเภทนี้!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'ใช่, ฉันต้องการลบ!',
			cancelButtonText: 'ยกเลิก',
			reverseButtons: true
		}).then((result) => {
			if (result.value) {
				var id = $('.custom-control-input:checked').length;
				$('.custom-control-input:checked').each(function(index, el) {
					$('table tr').has('.custom-control-input:checked').remove();
					var type = 'del';
					var value = el.id;
					$.ajax({
						type:"POST",
						url: 'includes/type_list.inc.php',
						data:{type:type, value:value},
						beforeSend: function() {
							$('.tr-add').hide();
							$('.tr-dif').hide();
							$('.tr-mod').hide();
						},
						success: function(response){
							if (response == '1') {
								Swal.fire('สำเร็จ!', 'ลบประเภท เรียบร้อย!', 'success'	).then(function(){
									window.location = "type_list.php";
								})
							}else{
								Swal.fire({type: 'error', title: 'ไม่สำเร็จ', text: 'ไม่สามารถลบประเภทได้ กรุณาติดต่อผู้ดูแลระบบ !'})
							}
						}
					});

				});
			}
		})
		// $('table tr').has('.custom-control-input:checked').remove();
	});
	$('#add-confrim').click(function() {
		var value = $('#add-input').val();
		var type = 'add';
		if (value != '') {
			$.ajax({
				type: "POST",
				url: 'includes/type_list.inc.php',
				data: {type:type, value:value},
				beforeSend: function() {
					$('.tr-add').hide();
					$('.tr-dif').hide();
					$('.tr-mod').hide();
				},
				success: function(response){
					if (response == '1') {
						Swal.fire('สำเร็จ!', 'เพิ่มประเภท เรียบร้อย!', 'success'	).then(function(){
							window.location = "type_list.php";
						})
					}else{
						Swal.fire({type: 'error', title: 'ไม่สำเร็จ', text: 'ไม่สามารถเพิ่มประเภทได้ กรุณาติดต่อผู้ดูแลระบบ !'})
					}
				}
			});
		}
	});
	$('#add-cancel').click(function(){
		$('.tr-add').hide();
		$('.tr-dif').hide();
		$('.tr-mod').hide();
	});
	$('#mod').click(function(){
		$('.tr-mod').show();
		$('.data').hide();
	});
	$('.mod-confrim').click(function(){
		var id = $(this).attr('id');
		var value = $('#mod-input'+id).val();
		var type = 'mod';
		$.post(
			'includes/type_list.inc.php',
			{
				id:id,
				value:value,
				type:type
			}
		).done(function(){
			Swal.fire('สำเร็จ!', 'แก้ไขประเภท เรียบร้อย!', 'success').then(function(){
				window.location = "type_list.php";
			})
		});
	});
});