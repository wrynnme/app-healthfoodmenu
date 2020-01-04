<?php require_once 'class-autoload.inc.php'; ?>
<?php
if (isset($_POST['waitingConfrim'])) {
	$search = @$_POST['search'];
	$ings = new ingredientsview();
	$ing = $ings->wait($search);
	?>
	<div class="table-responsive-xl">
		<table class="table table-striped table-borderless">
			<thead class="thead-dark">
				<tr class="text-center">
					<th scope="col">#</th>
					<th scope="col">ชื่อ</th>
					<th scope="col">แคลอรี่ : 100 กรัม</th>
					<th scope="col">ไม่อนุมัติ</th>
					<th scope="col">อนุมัติ</th>
				</tr>
			</thead>
			<tbody>
				<?php for ($i = 0; $i < sizeof($ing); $i++) { ?>
					<tr class="text-center">
						<th><?php echo $ing[$i]['ing_id']; ?></th>
						<td class="text-left"><?php echo $ing[$i]['ing_name']; ?></td>
						<td><?php echo $ing[$i]['ing_kcal']; ?></td>
						<td><i class="fas fa-thumbs-down text-danger" id="<?php echo $ing[$i]['ing_id']; ?>" onclick="approved(this.id,'disapproved');"></i></td>
						<td><i class="fas fa-thumbs-up text-success" id="<?php echo $ing[$i]['ing_id']; ?>" onclick="approved(this.id,'approved');"></i></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php 
unset($ings);
}
if (isset($_POST['approve'])) {
	$ings = new ingredientscontr();
	if ($_POST['status'] == 'approved') {
		$id = $_POST['id'];
		echo ($ings->edit('ing_status', '2', $id))? 'success' : 'error';
	}
	if ($_POST['status'] == 'disapproved') {
		$id = $_POST['id'];
		echo ($ings->edit('ing_status', '0', $id))? 'success' : 'error';
	}
	unset($ings);
}
?>
