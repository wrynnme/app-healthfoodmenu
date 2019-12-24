$('.btnNext').click(function() {
	$('.nav-tabs > .nav-item > .active').parent().next('li').find('a').trigger('click');
});

$('.btnPrevious').click(function() {
	$('.nav-tabs > .nav-item > .active').parent().prev('li').find('a').trigger('click');
});
function send_data(value){
	$.ajax({
		type:"POST",
		url:"ajax_plate.php",
		data:{id:value}
	});
	Swal.fire({
		position: 'top-end',
		type: 'success',
		title: 'เพิ่มวัตถุดิบเรียบร้อย',
		showConfirmButton: false,
		timer: 1500
	})
}
function search_data(v1, v2){
	$.ajax({
		type:"POST",
		url:"ajax_product.php",
		data:{value:v1, type:v2},
		success:function(data){
			$(".this").html(data);
		}
	});
}