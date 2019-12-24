function del(Line ,Type){
	Swal.fire({
		title: 'คุณต้องการที่จะลบ?',
		text: "คุณต้องการลบวัตถุดิบชิ้นนี้ ออกจากเมนูนีั!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'ใช่, ฉันต้องการลบ!',
		cancelButtonText: 'ยกเลิก',
		reverseButtons: true
	}).then((result) => {
		if (result.value) {
			Swal.fire('ลบเรียบร้อย !', 'วัตถุดิบถูกลบเรียบร้อย.', 'success').then(function(){
				window.location = 'del.php?Line='+Line+'&from='+Type;
			})
		}
	})
}
function cal_kcal(value, unit, kcal, i){
	var allcal = (kcal / unit) * value;
	$('#allcal'+i).html(allcal.toFixed(2));
	$.ajax({
		type:"POST",
		url:"ajax_calc.php",
		data:{allcal:allcal, count:i, gram:value},
		success:function(data){
			$("#allkcal").html(data);
		}
	});
}
function foodname(value){
	$.ajax({
		type:"POST",
		url:"ajax_plate.php",
		data:{food_name:value}
	});
}
function foodprice(value){
	$.ajax({
		type:"POST",
		url:"ajax_plate.php",
		data:{food_price:value}
	});
}
function choosetype(){
	var value = "";
	$('select option:selected').each(function(){
		value += $(this).attr("value") + " ";
	});
	$.ajax({
		type:"POST",
		url:"ajax_plate.php",
		data:{type_id:value}
	});
}