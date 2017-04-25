<?php
	require( $file = EP_AWARD_NOMINATIONS_PATH . "/classes/ep-award-nominations-model.php" );
	
	$newModel = new epAwardNominationsModel;
	
	$allAwards = $newModel->get_all_awards();
?>

<form name="nomination" method="post" action="">

<h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;"><input style="margin-right: 16px;" type="radio" name="award" value="<?php echo $allAwards[0]->id; ?>" checked><?php echo $allAwards[0]->title ?></h2>

<p style="color: #000; font-size: 15px; max-width: 300px;"><?php echo $allAwards[0]->description ?></p>


<?php for ($i = 1; $i < $newModel->get_number_awards(); $i++) { ?>
<h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;"><input style="margin-right: 16px;" type="radio" name="award" value="<?php echo $allAwards[$i]->id; ?>"><?php echo $allAwards[$i]->title; ?></h2>
<p style="color: #000; font-size: 15px; max-width: 300px;"><?php echo $allAwards[$i]->description; ?></p>
<?php } ?>

<p><input type="submit" value="Next"></p>

</form>
