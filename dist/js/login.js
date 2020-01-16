$('.account_info').on("click",function(){
	var key = $(this).data("key"); // email
	var email = $(this).data("email");
	if($('.card-user-choose').hasClass("d-none")){
		$('.card-user-choose').removeClass("d-none");
	}
	$('.card-user-choose').addClass("d-block");
	$('.card-user-choose p').html(key);
	$('.card-user-cookie').addClass("d-none");
	if($('.card-user-cookie').hasClass("d-inline-block")){
		$('.card-user-cookie').removeClass("d-inline-block");
	}

	$('div.email').addClass("d-none");
	if($('div.email').hasClass("d-block")){
		$('div.email').removeClass("d-block");
	}
	$('#email').val(email);

	$('button.close').attr("data-key",key);
});

$('.notme').on("click",function(){
	$('.card-user-choose').addClass("d-none");
	$('.card-user-choose').removeClass("d-block");
	if($('div.email').hasClass("d-none")){
		$('div.email').removeClass("d-none");
	}
	$('div.email').addClass("d-block");
	$('.card-user-cookie').addClass("d-inline-block");
	if($('.card-user-cookie').hasClass("d-none")){
		$('.card-user-cookie').removeClass("d-none");
	}
	$("form")[0].reset();
});

$('#deleteModal').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var key = button.data('key');
	$('.btn-delete').on("click",function(){
		$.ajax({
			url: "includes/login.inc.php?obj=delete_account_cookie",
			method: "POST",
			data: {key: key},
		}).done(function(result){
			if(result == "success"){
				$('#deleteModal').modal('hide');
				$('.card-user-'+key).addClass("d-none");
				$('.card-user-'+key).remove();
				$('.card-user-choose').addClass("d-none");
				if($('.card-user-choose').hasClass("d-block")){
					$('.card-user-choose').removeClass("d-block");
				}
				if($('div.email').hasClass("d-none")){
					$('div.email').removeClass("d-none");
				}
				if($('.card-user-cookie').hasClass("d-none")){
					$('.card-user-cookie').removeClass("d-none");
				}
				$('div.email').addClass("d-block");
				$('.card-user-cookie').addClass("d-inline-block");
				$("form")[0].reset();
				location.reload();
			}
		});
	})
	var modal = $(this);
	modal.find('.account_id').text('account ' + key);
	// modal.find('.modal-body input').val(recipient);
});
window.addEventListener('load', function() {
	var forms = $('.needs-validation');
	var validation = Array.prototype.filter.call(forms, function(form) {
		form.addEventListener('submit', function(event) {
			if (form.checkValidity() === false) {
				event.preventDefault();
				event.stopPropagation();
			}else{
				event.preventDefault();
				var myForm = document.getElementById('loginForm');
				var data = new FormData(myForm);
				/*for(var pair of data.entries()) {
					console.log(pair[0]+ ', '+ pair[1]); 
				}*/
				$.ajax({
					url: 'includes/login.inc.php?obj=check_login',
					type: 'POST',
					data: data,
					processData: false,
					contentType: false,
					beforeSend: function() {
						$('.btn-login').css("display","none");
						$('.btn-loading').removeClass("d-none");
					},
					success: function(data, textStatus, xhr) {
							// console.log(textStatus);
							if (data == 'success') {
								Swal.fire("สำเร็จ !", "<b>เข้าสู่ระบบสำเร็จ !!</b>", "success").then(function(){
									window.location.href='index.php';
								})
							}else{
								Swal.fire("ไม่สำเร็จ !", "<b>กรุณาตรวจสอบข้อมูลที่กรอก !!</b>", "error").then(function(){
									$('.btn-login').css("display","unset");
									$('.btn-loading').addClass("d-none");
								});
							}
						}
					});
			}
			form.classList.add('was-validated');
		}, false);
	});
}, false);