<div class="sideMenu float-left rounded-sm border border-dark py-1">
	<br>
	<?php
	$cus_id = $_SESSION['cus_id'];
	$types = new typeview();
	$mytypes = $types->getAll();
	?>
	<div class="text-center">
		<label for="select">ประเภท</label>
	</div>
	<select class="custom-select" id="select">
		<option value="0" selected>ทั้งหมด</option>
		<?php for ($i = 0; $i < sizeof($mytypes); $i++) { ?>
			<option value="<?php echo $mytypes[$i]['type_id']?>"><?php echo $mytypes[$i]['type_name']?></option>
		<?php } ?>
	</select>
	<hr>
	<div class="text-center">
		<label for="rtable">โต๊ะ</label>
	</div>
	<div class="text-center">
		<?php for($i = 1; $i <= $_SESSION['cus_rtable']; $i++){ ?>
			<button class="btn btn-outline-secondary my-1" data-val="<?php echo $i; ?>" id="bst<?php echo $i; ?>" style="width: 42px;"><?php echo $i; ?></button>
		<?php } ?>
	</div>
	<hr>
	<div class="text-center">
		<input type="color" class="form-control" name="bg_color" id="bg_color" value="#F5F5F1">
	</div>
</div>
<script>
	$('.btn').on('click', function(){
		var select = $(this);
		var table = select.attr('data-val');
		var cus_rtable = <?php echo $_SESSION['cus_rtable']; ?>;
		var cus_id = <?php echo $_SESSION['cus_id']; ?>;
		$('#'+select.attr('id')).addClass('active');
		for (var i = 1; i <= cus_rtable; i++) {
			if (i != table) {
				$('#bst'+i).removeClass('active');
			}
		}
		var t = cus_id+'&'+table;
		generate_qrcode(cus_id,table);
	});

</script>