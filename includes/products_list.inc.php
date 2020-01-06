<?php require_once 'class-autoload.inc.php'; ?>
<?php
$value = $_POST['value'];
$type = $_POST['type'];

$ings = new ingredientsview();
$types[$type] = $ings->getTypeWithSearch($type, $value);
?>
<div class="text-center" id="ingtr<?=$type;?>">
	<?php for ($i = 0;$i < sizeof($types[$type]); $i++) { ?>
		<div class="card">
			<img src="dist/img/ingredients/<?php echo $types[$type][$i]['ing_img'];?>" class="card-img-top mx-auto" alt="...">
			<div class="card-body text-center">
				<h5 class="card-title"><?php echo $types[$type][$i]['ing_name'];?></h5>
				<p class="card-text"><?php echo $types[$type][$i]['ing_unit']." กรัม ";?>: <?php echo $types[$type][$i]['ing_kcal']." แคลอรี่ ";?></p>
				<button type="button" name="<?php echo $types[$type][$i]['ing_id']?>" id="add" class="btn btn-outline-success" onclick="return send_data(this.name);"><i class="fal fa-cart-plus"></i></button>
			</div>
		</div>
	<?php } ?>
</div>