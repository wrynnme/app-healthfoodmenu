$('.custom-file-input').change(function(event) {
	$('.custom-file-label').text($(this).val().split("\\").pop());
});
'use strict';
window.addEventListener('load', function() {
	var forms = $('.needs-validation');
	var validation = Array.prototype.filter.call(forms, function(form) {
		form.addEventListener('submit', function(event) {
			if (form.checkValidity() === false) {
				event.preventDefault();
				event.stopPropagation();
			}else{
				event.preventDefault();
				var myForm = document.getElementById('myForm');
				var data = new FormData(myForm);
				var id = <?php echo $_GET['id']; ?>;
				var old_pic = "<?php echo $ing['ing_img']; ?>";
				data.append('ing_id', id);
				data.append('old_pic', old_pic);
				// for(var pair of data.entries()) {
				// 	console.log(pair[0]+ ', '+ pair[1]); 
				// }
				$.ajax({
					url: 'includes/ingredients_edit.inc.php',
					type: 'POST',
					data: data,
					processData: false,
					contentType: false,
					success: function(response) {
						if (response == '') {
							Swal.fire("สำเร็จ !", "<b>แก้ไขข้อมูลสำเร็จ !!</b>", "success").then(function(){
								window.location.href='ingredients_list.php';
							})
						}else{
							Swal.fire("ไม่สำเร็จ !", "<b>กรุณาตรวจสอบข้อมูลที่กรอก !!</b>", "error")
						}
					}
				})
			}
			form.classList.add('was-validated');
		}, false);
	});
}, false);