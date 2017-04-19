<?php
	if ( !class_exists( 'epAwardNominationsNomineePageController' ) ) {
		
		
		class epAwardNominationsNomineePageController {
			
			
			public function __construct() {
				
				
				$currentUser = wp_get_current_user();
				
				
				if ( ( $currentUser instanceof WP_User ) && $currentUser->has_cap( 'epAwardNominee' ) ) {
					
					
					if ( isset( $_POST[ 'business-question-one' ] ) ) {
						
						
						require( 'ep-award-nominations-model.php' );
						
						$newModel = new epAwardNominationsModel;
						
						$answerID = $newModel->has_answered( 1, $currentUser->ID );
						
						if ( $answerID ) {
							
							
							$newModel->update_answer( $answerID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-one' ] )));
							
							
						} else {
							
							
							$newModel->set_answer( 1, $currentUser->ID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-one' ]) ));
							
							
						}
						
						
						$this->business_question_two();
						
						
					} elseif ( isset( $_POST[ 'business-question-two' ] ) ) {
						
						
						require( 'ep-award-nominations-model.php' );
						
						$newModel = new epAwardNominationsModel;
						
						$answerID = $newModel->has_answered( 2, $currentUser->ID );
						
						if ( $answerID ) {
							
							
							$newModel->update_answer( $answerID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-two' ]) ));
							
							
						} else {
							
							
							$newModel->set_answer( 2, $currentUser->ID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-two' ]) ));
							
							
						}
						
						
						$this->business_question_three();
						
						
					} elseif ( isset( $_POST[ 'business-question-three' ] ) ) {
						
						
						require( 'ep-award-nominations-model.php' );
						
						$newModel = new epAwardNominationsModel;
						
						$answerID = $newModel->has_answered( 3, $currentUser->ID );
						
						if ( $answerID ) {
							
							
							$newModel->update_answer( $answerID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-three' ]) ));
							
							
						} else {
							
							
							$newModel->set_answer( 3, $currentUser->ID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-three' ]) ));
							
							
						}
						
						
						$this->business_question_four();
						
						
					} elseif ( isset( $_POST[ 'business-question-four' ] ) ) {
						
						
						require( 'ep-award-nominations-model.php' );
						
						$newModel = new epAwardNominationsModel;
						
						$answerID = $newModel->has_answered( 4, $currentUser->ID );
						
						if ( $answerID ) {
							
							
							$newModel->update_answer( $answerID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-four' ]) ));
							
							
						} else {
							
							
							$newModel->set_answer( 4, $currentUser->ID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-four' ]) ));
							
							
						}
						
						
						$this->business_question_five();
						
						
					} else {
						
						
						$this->question_one( $currentUser );
						
						
					}
					
					
				} else {
					
					
					$this->must_be_nominee();
					
					
				}
				
				
			}
			
			
			public function must_be_nominee() {
				
				
				require( 'ep-award-nominations-view.php' );
				
				$newView = new epAwardNominationsView;
				
				$newView->must_be_nominee();
				
				
			}
			
			
			public function question_one( $currentUser ) {
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				
				if ( $newModel->get_nominee_award( $currentUser->ID ) === '1' ) {
					
					
					require( 'ep-award-nominations-view.php' );
					
					$newView = new epAwardNominationsView;
					
					$newView->business_question_one();
					
					
				}
				
				
			}
			
			
			public function business_question_two() {
				
				
				require( 'ep-award-nominations-view.php' );
				
				$newView = new epAwardNominationsView;
				
				$newView->business_question_two();
				
				
			}
			
			
			public function business_question_three() {
				
				
				require( 'ep-award-nominations-view.php' );
				
				$newView = new epAwardNominationsView;
				
				$newView->business_question_three();
				
				
			}
			
			
			public function business_question_four() {
				
				
				require( 'ep-award-nominations-view.php' );
				
				$newView = new epAwardNominationsView;
				
				$newView->business_question_four();
				
				
			}
			
			
		}
		
		
	}
?>
