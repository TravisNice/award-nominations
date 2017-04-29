<?php
	if (!class_exists('epAwardNominationsControlJudgesPage')) {
		
		class epAwardNominationsControlJudgesPage {
			
			public function __construct() {
				
				$user = wp_get_current_user();
				
				if ($user->has_cap('administrator') || $user->has_cap('epAwardJudge')) {
					if (isset($_POST['id'])) {
						require('ep-award-nominations-view-judges-page.php');
						$newView = new epAwardNominationsViewJudgesPage;
						$newView->show_nominees_table();
					}
					elseif (isset($_POST['answers'])) {
						require('ep-award-nominations-view-judges-page.php');
						$newView = new epAwardNominationsViewJudgesPage;
						$newView->show_nominees_answers();
					}
					else {
						require('ep-award-nominations-view-judges-page.php');
						$newView = new epAwardNominationsViewJudgesPage;
						$newView->show_nominations_table();
					}
				}
				else {
					require('ep-award-nominations-view-judges-page.php');
					$newView = new epAwardNominationsViewJudgesPage;
					$newView->must_be_a_judge();
				}
				
			}
			
		}
		
	}
	
?>
