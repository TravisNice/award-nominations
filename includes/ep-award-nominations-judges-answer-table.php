<?php
	include(EP_AWARD_NOMINATIONS_PATH.'/classes/ep-award-nominations-model.php');
	$newModel = new epAwardNominationsModel;
	$nomination = $newModel->get_nomination($_POST['answers']);
	$answers = $newModel->get_nominee_answers($nomination[0]->nomineeUserID);
	$attachments = $newModel->get_attachment($nomination[0]->nomineeUserID);
?>


<?php foreach($answers as $answer) { ?>
	<table>
		<thead>
			<tr>
				<th><?php echo $newModel->get_question_title($nomination[0]->awardID, $answer->questionID); ?></th>
			<tr>
			<tr>
				<th><?php echo $newModel->get_question_description($nomination[0]->awardID, $answer->questionID); ?></th>
			<tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $answer->answer; ?></td>
			</tr>
		</tbody>
	</table>
<?php } ?>


<table><thead><tr><th colspan="2">Attachments</th></tr></thead><tbody>
<?php if ($newModel->has_attachment($nomination[0]->nomineeUserID)) {
	foreach($attachments as $attachment) { ?>
		<tr>
			<td><?php echo $attachment->id; ?></td>
			<td><a href="<?php echo $attachment->filename; ?>"><?php echo $attachment->filename; ?></a></td>
		</tr>
	<?php } ?>
<?php } ?>
</tbody></table>



<form method="POST" action="">
<p><button id="back" name="back" value="back">Back</button></p>
</form>
