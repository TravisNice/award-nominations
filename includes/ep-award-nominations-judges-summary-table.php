<?php
	include(EP_AWARD_NOMINATIONS_PATH.'/classes/ep-award-nominations-model.php');
	$newModel = new epAwardNominationsModel;
	$countNominations = $newModel->get_number_of_nominations();
	$nominations = $newModel->get_all_nominations();
?>

<?php if ($countNominations) { ?>
<form method="POST" action="">
	<table>
		<thead>
			<tr>
				<th>Nomination</th>
				<th>Award</th>
				<th>Category</th>
				<th>Nominee</th>
				<th>Email</th>
				<th>Answers</th>
			</tr>
		</thead>
		</tbody>
			<?php foreach ($nominations as $nomination) { ?>
			<tr>
				<td><button id="id-<?php echo $nomination->id; ?>" type="submit" name="id" value="<?php echo $nomination->id; ?>"><?php echo $nomination->id; ?></button></td>
				<td><?php echo $newModel->get_award_title($nomination->awardID); ?></td>
				<td><?php if ($newModel->get_number_categories($nomination->awardID)) { ?>
					<?php echo $newModel->get_category_title($nomination->categoryID); ?>
				    <?php } else { ?>
					&nbsp;
				    <?php } ?>
				<td><?php echo $nomination->nominee; ?></td>
				<td><?php echo $nomination->nomineeContact; ?></td>
				<td><?php if ($newModel->nominee_has_answers($nomination->nomineeUserID)) { ?>
					<button type="submit" name="answers" value="<?php echo $nomination->nomineeUserID; ?>">View</button>
				    <?php } else { ?>
					&nbsp;
				    <?php } ?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</form>
<?php } else { ?>
	<p>There are no nominations to display.</p>
<?php } ?>

