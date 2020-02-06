<?php require_once 'class-autoload.inc.php'; ?>
<?php
$value = $_POST['value'];
$type = $_POST['type'];

$ings = new ingredientsview();
$types[$type] = $ings->getTypeWithSearch($type, $value);
// var_dump(http_response_code());

?>
<div class="text-center" id="ingtr<?=$type;?>">
	<?php for ($j = 0; $j < sizeof($types[$type]); $j++) { ?>
		<div class="card <?php echo ($types[$type][$j]['ing_status'] == '0')?'bg-danger':NULL; ?> <?php echo ($types[$type][$j]['ing_status'] == '1')?'bg-info':NULL; ?>">
			<img src="dist/img/ingredients/<?php echo $types[$type][$j]['ing_img'];?>" class="card-img-top mx-auto" alt="...">
			<div class="card-body text-center">
				<h5 class="card-title"><?php echo $types[$type][$j]['ing_name'];?></h5>
				<p class="card-text"><?php echo $types[$type][$j]['ing_unit']." กรัม ";?>: <?php echo $types[$type][$j]['ing_kcal']." แคลอรี่ ";?></p>
			</div>
			<div class="middle">
				<div class="text"><a href="ingredients_edit.php?id=<?php echo $types[$type][$j]['ing_id'];?>"><i class="fad fa-tools"></i></a></div>
			</div>
		</div>
	<?php } ?>
</div>