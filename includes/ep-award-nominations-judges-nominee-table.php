<?php
	include(EP_AWARD_NOMINATIONS_PATH.'/classes/ep-award-nominations-model.php');
	$newModel = new epAwardNominationsModel;
	$countNominations = $newModel->get_number_of_nominations();
	$nominations = $newModel->get_nomination($_POST['id']);
?>

<table>
	<thead>
		<tr>
			<td colspan="5">Nominee</td>
		</tr>
		<tr>
			<td>id</td>
			<td>Award</td>
			<td>Category</td>
			<td>Name</td>
			<td>Email</td>
		</tr>
	</thead>
	</tbody>
		<tr>
			<td><?php echo $_POST['id']; ?></td>
			<td><?php echo $newModel->get_award_title($nominations[0]->awardID); ?></td>
			<td><?php echo $newModel->get_category_title($nominations[0]->categoryID); ?></td>
			<td><?php echo $nominations[0]->nominee; ?></td>
			<td><?php echo $nominations[0]->nomineeContact; ?></td>
		</tr>
	</tbody>
</table>

<table>
	<thead>
		<tr>
			<td>Reason</td>
		</tr>
	</thead>
	</tbody>
		<tr>
			<td><?php echo $nominations[0]->reason; ?></td>
		</tr>
	</tbody>
</table>

<table>
	<thead>
		<tr>
			<td colspan="3">Nominator</td>
		</tr>
		<tr>
			<td>Name</td>
			<td>Email</td>
			<td>Phone</td>
		</tr>
	</thead>
	</tbody>
		<tr>
			<td><?php echo $nominations[0]->nominatorFirst . " " . $nominations[0]->nominatorLast; ?></td>
			<td><?php echo $nominations[0]->nominatorEmail; ?></td>
			<td><?php echo $nominations[0]->nominatorPhone; ?></td>
		</tr>
	</tbody>
</table>

<form method="POST" action="">
<p><button id="back" name="back" value="back">Back</button></p>
</form>
