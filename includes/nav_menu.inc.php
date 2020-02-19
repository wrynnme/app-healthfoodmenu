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
	<div class="row">
		<div class="col-4">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" id="logo" <?php if ($_SESSION['cus_logo'] != '' || $_SESSION['cus_logo'] != NULL) { echo 'checked'; }?>>
				<label class="custom-control-label" for="logo">Logo</label>
			</div>
		</div>
		<div class="col-4">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" id="res_name" checked>
				<label class="custom-control-label" for="res_name">Res Name</label>
			</div>
		</div>
		<div class="col-4">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" id="qrcode">
				<label class="custom-control-label" for="qrcode">QR Code</label>
			</div>
		</div>
	</div>
	
	<hr>
	<div class="text-center">
		<label for="rtable">โต๊ะ</label>
	</div>
	<div class="text-center">
		<?php for($i = 1; $i <= $_SESSION['cus_rtable']; $i++){ ?>
			<button class="btn btn-outline-secondary my-1 btnqrcode" data-val="<?php echo $i; ?>" id="bst<?php echo $i; ?>" style="width: 42px;"><?php echo $i; ?></button>
		<?php } ?>
	</div>
	<hr>
</div>
<script>
	$('.btnqrcode').on('click', function(){
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
		$('#qrcode').prop('checked', true);
	});

</script>