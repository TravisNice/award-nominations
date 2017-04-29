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
						
						
						if ( $_POST[ 'submit' ] == "next" ) {
							
							$this->business_question_two();
							
						}
						elseif ( $_POST[ 'submit' ] == "end" ) {
							
							$this->nominee_confirmation();
							
						}
						
						
					} elseif ( isset( $_POST[ 'business-question-two' ] ) ) {
						
						
						require( 'ep-award-nominations-model.php' );
						
						$newModel = new epAwardNominationsModel;
						
						$answerID = $newModel->has_answered( 2, $currentUser->ID );
						
						if ( $answerID ) {
							
							
							$newModel->update_answer( $answerID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-two' ]) ));
							
							
						} else {
							
							
							$newModel->set_answer( 2, $currentUser->ID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-two' ]) ));
							
							
						}
						
						
						if ( $_POST[ 'submit' ] == "next" ) {
							
							$this->business_question_three();
							
						}
						elseif ( $_POST[ 'submit' ] == "end" ) {
							
							$this->nominee_confirmation();
							
						}
						
						
					} elseif ( isset( $_POST[ 'business-question-three' ] ) ) {
						
						
						require( 'ep-award-nominations-model.php' );
						
						$newModel = new epAwardNominationsModel;
						
						$answerID = $newModel->has_answered( 3, $currentUser->ID );
						
						if ( $answerID ) {
							
							
							$newModel->update_answer( $answerID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-three' ]) ));
							
							
						} else {
							
							
							$newModel->set_answer( 3, $currentUser->ID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-three' ]) ));
							
							
						}
						
						
						if ( $_POST[ 'submit' ] == "next" ) {
							
							$this->business_question_four();
							
						}
						elseif ( $_POST[ 'submit' ] == "end" ) {
							
							$this->nominee_confirmation();
							
						}
						
						
					} elseif ( isset( $_POST[ 'business-question-four' ] ) ) {
						
						
						require( 'ep-award-nominations-model.php' );
						
						$newModel = new epAwardNominationsModel;
						
						$answerID = $newModel->has_answered( 4, $currentUser->ID );
						
						if ( $answerID ) {
							
							
							$newModel->update_answer( $answerID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-four' ]) ));
							
							
						} else {
							
							
							$newModel->set_answer( 4, $currentUser->ID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-four' ]) ));
							
							
						}
						
						
						if ( $_POST[ 'submit' ] == "next" ) {
							
							$this->business_question_five();
							
						}
						elseif ( $_POST[ 'submit' ] == "end" ) {
							
							$this->nominee_confirmation();
							
						}
						
						
					} elseif ( isset( $_POST[ 'business-question-five' ] ) ) {
						
						
						require( 'ep-award-nominations-model.php' );
						
						$newModel = new epAwardNominationsModel;
						
						$answerID = $newModel->has_answered( 5, $currentUser->ID );
						
						if ( $answerID ) {
							
							
							$newModel->update_answer( $answerID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-five' ]) ));
							
							
						} else {
							
							
							$newModel->set_answer( 5, $currentUser->ID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-five' ]) ));
							
							
						}
						
						
						if ( $_POST[ 'submit' ] == "next" ) {
							
							$this->business_question_six();
							
						}
						elseif ( $_POST[ 'submit' ] == "end" ) {
							
							$this->nominee_confirmation();
							
						}
						
						
					} elseif ( isset( $_POST[ 'business-question-six' ] ) ) {
						
						
						require( 'ep-award-nominations-model.php' );
						
						$newModel = new epAwardNominationsModel;
						
						$answerID = $newModel->has_answered( 6, $currentUser->ID );
						
						if ( $answerID ) {
							
							
							$newModel->update_answer( $answerID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-six' ]) ));
							
							
						} else {
							
							
							$newModel->set_answer( 6, $currentUser->ID, sanitize_text_field(stripslashes_deep($_POST[ 'business-question-six' ]) ));
							
							
						}
						
						
						if ( $_POST[ 'submit' ] == "next" ) {
							
							$this->video_upload();
							
						}
						elseif ( $_POST[ 'submit' ] == "end" ) {
							
							$this->nominee_confirmation();
							
						}
						
						
					} elseif ( isset( $_POST[ 'employee-question-one' ] ) ) {
						
						
						require( 'ep-award-nominations-model.php' );
						
						$newModel = new epAwardNominationsModel;
						
						$answerID = $newModel->has_answered( 7, $currentUser->ID );
						
						if ( $answerID ) {
							
							
							$newModel->update_answer( $answerID, sanitize_text_field(stripslashes_deep($_POST[ 'employee-question-one' ]) ));
							
							
						} else {
							
							
							$newModel->set_answer( 7, $currentUser->ID, sanitize_text_field(stripslashes_deep($_POST[ 'employee-question-one' ]) ));
							
							
						}
						
						
						if ( $_POST[ 'submit' ] == "next" ) {
							
							$this->video_upload();
							
						}
						elseif ( $_POST[ 'submit' ] == "end" ) {
							
							$this->nominee_confirmation();
							
						}
						
						
					} elseif ( isset( $_POST[ 'innovation-question-one' ] ) ) {
						
						
						require( 'ep-award-nominations-model.php' );
						
						$newModel = new epAwardNominationsModel;
						
						$answerID = $newModel->has_answered( 8, $currentUser->ID );
						
						if ( $answerID ) {
							
							
							$newModel->update_answer( $answerID, sanitize_text_field(stripslashes_deep($_POST[ 'innovation-question-one' ]) ));
							
							
						} else {
							
							
							$newModel->set_answer( 8, $currentUser->ID, sanitize_text_field(stripslashes_deep($_POST[ 'innovation-question-one' ]) ));
							
							
						}
						
						
						if ( $_POST[ 'submit' ] == "next" ) {
							
							$this->video_upload();
							
						}
						elseif ( $_POST[ 'submit' ] == "end" ) {
							
							$this->nominee_confirmation();
							
						}
						
					} //elseif ( isset ( $_POST[ 'video-submit' ] ) ) {
						
						//	if ( isset( $_FILES['images'] ) ) {
							
						//	require( EP_AWARD_NOMINATIONS_PATH . "/includes/ep-award-nominations-video-form-handler.php" );
						//	upload_user_file( $_FILES['images'] );
								//$this->upload_user_file( $_FILES['videos'] );
							
						//}
						
						//$this->nominee_confirmation();
						
						//}
					
					elseif ( isset( $_POST[ 'confirm-nominee' ] ) ) {
						
						
						require( 'ep-award-nominations-model.php' );
						
						$newModel = new epAwardNominationsModel;
						
						$user = wp_get_current_user();
						
						
						$to = "travis.nice@everydaypublishing.com.au,chamber@goondiwindi.qld.au";
						
						$subject = "Submitted Nominee Questions";
						
						$message  = "This is the submission from " . $newModel->get_nominee_name( $user->ID ) . PHP_EOL . PHP_EOL;
						
						$message .= "Award: " .  $newModel->get_award_title( $newModel->get_nominee_award( $user->ID ) ) . PHP_EOL;
						
						if ( $newModel->get_nominee_award( $user->ID ) == 1 || $newModel->get_nominee_award( $user->ID ) == 2 ) $message .= "Category: " . $newModel->get_category_title( $newModel->get_nominee_category( $user->ID ) )  . PHP_EOL . PHP_EOL;
						
						if ( $newModel->get_nominee_award( $user->ID ) == 1 ) {
							
							$message .= "Business History:" . PHP_EOL . $newModel->get_answer( 1, $user->ID ) . PHP_EOL . PHP_EOL;
							
							$message .= "Marketing:" . PHP_EOL . $newModel->get_answer( 2, $user->ID ) . PHP_EOL . PHP_EOL;
							
							$message .= "Staff Training:" . PHP_EOL . $newModel->get_answer( 3, $user->ID ) . PHP_EOL . PHP_EOL;
							
							$message .= "Successes of the last 12 months:" . PHP_EOL . $newModel->get_answer( 4, $user->ID ) . PHP_EOL . PHP_EOL;
							
							$message .= "Business Plan:" . PHP_EOL . $newModel->get_answer( 5, $user->ID ) . PHP_EOL . PHP_EOL;
							
							$message .= "Community Support:" . PHP_EOL . $newModel->get_answer( 6, $user->ID ) . PHP_EOL . PHP_EOL;
							
						} elseif ( $newModel->get_nominee_award( $user->ID ) == 2 ) {
							
							$message .= "Employee History:" . PHP_EOL . $newModel->get_answer( 1, $user->ID ) . PHP_EOL . PHP_EOL;
							
						} elseif ( $newModel->get_nominee_award( $user->ID ) == 3 ) {
							
							$message .= "Innovation History:" . PHP_EOL . $newModel->get_answer( 1, $user->ID ) . PHP_EOL . PHP_EOL;
							
						}
						
						wp_mail( $to, $subject, $message );
						
						
						$this->thank_you_page();
						
						
					} elseif ( isset ( $_POST[ 'video-submit' ] ) ) {
						
						if ( $_POST[ 'video-submit' ] == "next" ) {
							$this->nominee_confirmation();
						}
						
					} elseif ( isset( $_POST[ 'change1' ] ) ){
							
						$this->question_one( $currentUser );
							
					} elseif ( isset( $_POST[ 'change2' ] ) ) {
							
						$this->business_question_two();
							
					} elseif ( isset( $_POST[ 'change3' ] ) ) {
							
						$this->business_question_three();
							
					} elseif ( isset( $_POST[ 'change4' ] ) ) {
							
						$this->business_question_four();
							
					} elseif ( isset( $_POST[ 'change5' ] ) ) {
							
						$this->business_question_five();
							
					} elseif ( isset( $_POST[ 'change6' ] ) ) {
							
						$this->business_question_six();
							
					} elseif ( isset( $_POST[ 'change7' ] ) ) {
							
						$this->question_one( $currentUser );
							
					} elseif ( isset( $_POST[ 'change8' ] ) ) {
							
						$this->question_one( $currentUser );
							
					} elseif ( isset( $_POST[ 'change9' ] ) ) {
							
						$this->video_upload();
					
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
					
					
				} elseif ( $newModel->get_nominee_award( $currentUser->ID ) === '2' ) {
					
					
					require( 'ep-award-nominations-view.php' );
					
					$newView = new epAwardNominationsView;
					
					$newView->employee_question_one();
					
					
				} elseif ( $newModel->get_nominee_award( $currentUser->ID ) === '3' ) {
					
					
					require( 'ep-award-nominations-view.php' );
					
					$newView = new epAwardNominationsView;
					
					$newView->innovation_question_one();
					
					
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
			
			
			public function business_question_five() {
				
				
				require( 'ep-award-nominations-view.php' );
				
				$newView = new epAwardNominationsView;
				
				$newView->business_question_five();
				
				
			}
			
			
			public function business_question_six() {
				
				
				require( 'ep-award-nominations-view.php' );
				
				$newView = new epAwardNominationsView;
				
				$newView->business_question_six();
				
				
			}
			
			
			public function employee_question_one() {
				
				
				require( 'ep-award-nominations-view.php' );
				
				$newView = new epAwardNominationsView;
				
				$newView->employee_question_one();
				
				
			}
			
			
			public function innovation_question_one() {
				
				
				require( 'ep-award-nominations-view.php' );
				
				$newView = new epAwardNominationsView;
				
				$newView->innovation_question_one();
				
				
			}
			
			
			public function video_upload() {
				
				
					//				require( EP_AWARD_NOMINATIONS_PATH . "/includes/ep-award-nominations-video-form-handler.php" );
				
				
				require( 'ep-award-nominations-view.php' );
				
				$newView = new epAwardNominationsView;
				
				$newView->video_upload();
				
				
			}
			
			
			public function nominee_confirmation() {
				
				
				require( 'ep-award-nominations-view.php' );
				
				$newView = new epAwardNominationsView;
				
				$newView->nominee_confirmation();
				
				
			}
			
			
			public function thank_you_page() {
				
				
				require( 'ep-award-nominations-view.php' );
				
				$newView = new epAwardNominationsView;
				
				$newView->thank_you_page();
				
				
			}
			
		}
		
		
	}
?>
