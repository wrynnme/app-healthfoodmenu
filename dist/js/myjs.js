var page = $('body').data("page");
var types = $('body').data("name");

function search(value){
	$.ajax({
		type:"POST",
		url:"includes/"+types+"_list.inc.php",
		data:{value:value, page:page},
		success:function(data){
			$("#resultDiv").html(data);
		}
	});
}

function search_product(value, typep){
	$.ajax({
		type:"POST",
		url:"includes/"+types+"_list.inc.php",
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
		value = $(this).attr("value");
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

function mymenu(e){
	let res_id = $(e).data('res');
	$.ajax({
		type:"POST",
		url:"includes/orders_mymenu.inc.php",
		data:{res_id : res_id},
		success:function(data){
			$("#my-menu").html(data);
		}
	});
}

function checkbill(e) {
	let cus_id = $(e).data('cus');
	$.post('includes/orders.inc.php', {cus_id: cus_id, pay_status: '1'}, function(data, textStatus, xhr) {
		Swal.fire({
			title: 'กรุณารอพนักงาน',
			text: "กรุณารอพนักงานคิดเงิน!",
			confirmButtonText: "รอพนักงาน",
			confirmButtonColor: "#28A745",
			icon: 'success',
			width: 600,
			padding: '3em',
			background: '#fff',
			backdrop: `
			rgba(0, 51, 102,0.4)
			url("dist/img/giphy.gif")
			`,
		}).then(value => {window.location.reload();}, dismiss => {Swal.DismissReason.close});
	});
}

function confrim() {
	Swal.fire({
		title: 'ยืนยัน?',
		text: "คุณต้องการ สั่งอาหารเมนูนี้!",
		icon: 'success',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'ฉันต้องการสั่ง!',
		cancelButtonText: 'ยกเลิก',
		reverseButtons: true
	}).then((result) => {
		if (result.value) {
			$.ajax({
				type: 'POST',
				url: 'includes/orders_confrim.inc.php',
			}).done(function(result, textStatus, xhr){
				if (result == 'fail') {
					Swal.fire('สั่งอาหาร !', 'ไม่สามารถยืนยันการสั่งอาหารได้', 'error')
				}else if (result == 'error table or res_id') {
					Swal.fire('สั่งอาหาร !', 'ไม่สามารถยืนยันโต๊ะ หรือ ร้านอารหาร ได้', 'error')
				}else if (result == 'success') {
					Swal.fire('สั่งเรียบร้อย !', 'ยืนยันการสั่งอารหารเรียบร้อย.', 'success').then(function(){
						window.location.reload();
					})
				}
			});
		}
	});
}

function order_this(e){
	let res_id = $(e).data("res");
	let or_id = $(e).data("id");
	$.ajax({
		type:"POST",
		url:"includes/orders.inc.php",
		data:{order: or_id, res_id: res_id}
	});
	Swal.fire({
		position: 'top-end',
		type: 'success',
		title: 'เพื่มรายการอาหาร',
		showConfirmButton: false,
		timer: 1500
	})
}

function edit(e) {
	var id = $(e).data("id");
	window.location = types+'_edit.php?id='+id;
}

function del(e) {
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

function del_order(e){
	let res_id = $(e).data("res");
	let or_id = $(e).data("id");
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
				window.location = 'includes/orders.inc.php?del='+or_id+'&r='+res_id;
			})
		}
	})
}

function del_foods(Line ,Type) {
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

function del_user(e) {
	let id = $(e).data("id");
	Swal.fire({
		title: 'คุณต้องการที่จะลบ?',
		text: "คุณต้องการลบผู้ใช้นี้ออกจากระบบ!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'ใช่, ฉันต้องการลบ!',
		cancelButtonText: 'ยกเลิก',
		reverseButtons: true
	}).then((result) => {
		if (result.value) {
			Swal.fire('ลบเรียบร้อย !', 'ผู้ใช้นี้ถูกลบเรียบร้อย.', 'success').then(function(){
				window.location = 'includes/users_edit.inc.php?del='+id;
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