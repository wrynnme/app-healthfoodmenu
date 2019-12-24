/*================================
=            Function            =
================================*/

// Reusable Function to Enforce MaxLength
function enforce_maxlength(event) {
	var t = event.target;
	if (t.hasAttribute('maxlength')) {
	 t.value = t.value.slice(0, t.getAttribute('maxlength'));
	}
}

// Global Listener for anything with an maxlength attribute.
// I put the listener on the body, put it on whatever.
document.body.addEventListener('input', enforce_maxlength);

// minlength
$(document).ready(function(){
	$('form input[minlength]').on('keyup', function(){
		e_len = $(this).val().trim().length
		e_min_len = Number($(this).attr('minlength'))
		message = e_min_len <= e_len ? '' : e_min_len + ' characters minimum'
		this.setCustomValidity(message)
	})
	 $('input[type="number"]').on('keyup',function(){
		v = parseInt($(this).val());
		min = parseInt($(this).attr('min'));
		max = parseInt($(this).attr('max'));

		if (v < min){
			$(this).val(min);
		}
		if (v > max){
			$(this).val(max);
		}
	})
})

/*=====  End of Function  ======*/