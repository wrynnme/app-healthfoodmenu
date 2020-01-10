var page = $('body').data("page");
var type = $('body').data("name");

function search(value){
	$.ajax({
		type:"POST",
		url:"includes/"+type+"_list.inc.php",
		data:{value:value, page:page},
		success:function(data){
			$("#resultDiv").html(data);
		}
	});
}

function search_product(value, typep){
	$.ajax({
		type:"POST",
		url:"includes/"+type+"_list.inc.php",
		data:{value:value, type:typep},
		success:function(data){
			$(".this").html(data);
		}
	});
}

function send_data(value){
	$.ajax({
		type:"POST",
		url:"includes/foods_ingre.inc.php",
		data:{id:value},
		success:function(){
			Swal.fire({
				position: 'top-end',
				type: 'success',
				title: 'เพิ่มวัตถุดิบเรียบร้อย',
				showConfirmButton: false,
				timer: 1500
			})
		}
	});
}

function choosetype(){
	var value = "";
	$('select option:selected').each(function(){
		value += $(this).attr("value") + " ";
	});
	$.ajax({
		type:"POST",
		url:"includes/foods_ingre.inc.php",
		data:{type_id:value}
	});
}
function foodname(value){
	$.ajax({
		type:"POST",
		url:"includes/foods_ingre.inc.php",
		data:{food_name:value}
	});
}
function foodprice(value){
	$.ajax({
		type:"POST",
		url:"includes/foods_ingre.inc.php",
		data:{food_price:value}
	});
}
function cal_kcal(value, unit, kcal, i){
	var allcal = (kcal / unit) * value;
	$('#allcal'+i).html(allcal.toFixed(2));
	$.ajax({
		type:"POST",
		url:"includes/foods_ingre.inc.php",
		data:{allcal:allcal, count:i, gram:value},
		success:function(data){
			$("#allkcal").html(data);
		}
	});
}

function waitingConfrim(search){
	$.ajax({
		type:"POST",
		url:"includes/ingredients_wait.inc.php",
		data:{waitingConfrim:'1', search:search},
		success:function(data){
			$("#waitingconfrim").html(data);
		}
	});
}

function approved(id, status){
	$.ajax({
		type:"POST",
		url:"includes/ingredients_wait.inc.php",
		data:{approve:'1', id:id, status:status},
		success:function(data){
			if (data == 'success') {
				waitingConfrim();
			}
		}
	});
}

function edit(e){
	var id = $(e).data("id");
	window.location = type+'_edit.php?id='+id;
}

function del(e){
	let id = $(e).data("id");
	Swal.fire({
		title: 'คุณต้องการที่จะลบ?',
		text: "คุณต้องการลบเมนูนี้!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'ใช่, ฉันต้องการลบ!',
		cancelButtonText: 'ยกเลิก',
		reverseButtons: true
	}).then((result) => {
		if (result.value) {
			Swal.fire('ลบเรียบร้อย !', 'เมนูถูกลบเรียบร้อย.', 'success').then(function(){
				window.location = 'includes/foods_control.inc.php?cancelfood='+id;
			})
		}
	})
}

function del_foods(Line ,Type){
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
				window.location = 'includes/foods_control.inc.php?Line='+Line+'&from='+Type;
			})
		}
	})
}

$('.inpSearch').on('keyup keydown keypress blur focusout', function(event) {
	search(this.value);
});

$('.btnNext').click(function() {
	$('.nav-tabs > .nav-item > .active').parent().next('li').find('a').trigger('click');
});

$('.btnPrevious').click(function() {
	$('.nav-tabs > .nav-item > .active').parent().prev('li').find('a').trigger('click');
});

/*$(document).ready(function() {
	search(this.value);
});*/