<?php
	if (!class_exists('epAwardNominationsNominatePageController')) {
		
		
		class epAwardNominationsNominatePageController {
			
			
			public function __construct() {
				
				
				if ( isset( $_POST[ 'award' ] ) ) {
					
					
					$_SESSION[ 'award' ] = $_POST[ 'award' ];
					
					
					require( 'ep-award-nominations-model.php' );
					
					$newModel = new epAwardNominationsModel;
					
					
					if ( $newModel->get_number_categories( $_SESSION[ 'award' ] ) ) {
						
						
						$this->category_page();
						
						
					}
					
					else {
						
						
						$_SESSION[ 'category' ] = 0;
						
						
						$this->nominee_page();
						
						
					}
					
					
				} elseif ( isset( $_POST[ 'category' ] ) ) {
					
					
					$_SESSION[ 'category' ] = $_POST['category'];
					
					
					$this->nominee_page();
					
					
				} elseif ( isset( $_POST[ 'nominee-name' ] ) ) {
					
					
					$_SESSION[ 'nominee-name' ] = stripslashes_deep($_POST[ 'nominee-name' ]);
					
					$_SESSION[ 'nominee-reason' ] = stripslashes_deep($_POST[ 'nominee-reason' ]);
					
					
					if ( $_POST[ 'nominee-contact' ] !== "" ) {
						
						
						$_SESSION[ 'nominee-contact' ] = $_POST[ 'nominee-contact' ];
						
						
					} else {
						
						
						$_SESSION[ 'nominee-contact' ] = "No email provided";
						
						
					}
					
					
					$this->nominator_page();
					
					
				} elseif ( isset( $_POST['nominator-first' ] ) ) {
					
					
					$_SESSION[ 'nominator-first' ] = stripslashes_deep($_POST[ 'nominator-first' ]);
					
					$_SESSION[ 'nominator-last' ] = stripslashes_deep($_POST[ 'nominator-last' ]);
					
					if ( $_POST['nominator-email' ] != "" ) {
						
						
						$_SESSION[ 'nominator-email' ] = $_POST[ 'nominator-email' ];
						
						
					} else {
						
						
						$_SESSION[ 'nominator-email' ] = "No email provided";
						
						
					}
					
					
					if ( $_POST[ 'nominator-phone' ] != "" ) {
						
						
						$_SESSION[ 'nominator-phone' ] = $_POST[ 'nominator-phone' ];
						
						
					} else {
						
						
						$_SESSION[ 'nominator-phone' ] = "No phone provided";
						
						
					}
					
					
					$this->confirmation_page();
					
					
				} elseif ( isset( $_POST[ 'confirm' ] ) ) {
					
					
					$randomNumber = uniqid();
					
					$nomineeDetails = 'Nominee\'s Name: ' . $_SESSION[ 'nominee-name' ] . PHP_EOL;
					
					$nomineeDetails .= 'Nominee\'s Email: ' . $_SESSION[ 'nominee-contact' ] . PHP_EOL;
					
					$nomineeDetails .= 'Reason for nomination: ' . $_SESSION[ 'nominee-reason' ] . PHP_EOL;
					
					$password = wp_generate_password();
					
					$userdata = array('user_login' => (string)$randomNumber,
							  'user_pass' => $password,
							  'role' => (string)'epAwardNominee',
							  'show_admin_bar_front' => (bool)'false',
							  'description' => (string)$nomineeDetails
					);
					
					$userID = wp_insert_user( $userdata );
					
					
					require( 'ep-award-nominations-model.php' );
					
					$newModel = new epAwardNominationsModel;
					
					$newModel->set_nomination($_SESSION[ 'award' ],
								  $_SESSION[ 'category' ],
								  $_SESSION[ 'nominee-name' ],
								  $_SESSION[ 'nominee-reason' ],
								  $_SESSION[ 'nominee-contact' ],
								  $userID,
								  $_SESSION[ 'nominator-first' ],
								  $_SESSION[ 'nominator-last' ],
								  $_SESSION[ 'nominator-phone' ],
								  $_SESSION[ 'nominator-email' ]
					);
					
					
					$to = "travis.nice@everydaypublishing.com.au,chamber@goondiwindi.qld.au";
					
					$subject = "You have been nominated for the 2017 Goondiwindi Business Awards";
					
					$header = "Content-Type: text/html;";
					
					$message = '<body style="background-color: #eee;"><div style="left; width: 80%; max=-width: 600px; margin: auto; padding: 32px; background-color: #fff; border:2px solid #000; font-family: Arial, sans-serif; font-size: 15px; color: #333;"><a href=""><img width="100%" src="https://www.goondiwindichamber.com.au/wp-content/uploads/2017/04/goondiwnidi-chamber-logo-green.png" alt="Goondiwindi Chamber of Commerce"></a>';
					
					$message .= '<p>Dear ' . $_SESSION[ 'nominee-name' ] . ',</p>';
					
					$message .= '<p>Congratulations, your business has been nominated for the 2017 Lowes Petroleum Goondiwindi Business Awards.</p>';
					
					$message .= '<p>Your nominations is:<br>Name: ' . $_SESSION[ 'nominee-name' ] . '<br>Award: ' . $newModel->get_award_title( $_SESSION[ 'award' ] ) . '<br>Category: ' . $newModel->get_category_title( $_SESSION[ 'category' ] ) .'</p>';
					
					$message .= '<p>To be eligible to win, you must complete the Nominee Question by <a href="https://www.goondiwindichamber.com.au/my-account">logging in to our website</a>.</p>';
					
					$message .= '<p>You must use the unique username and password provided.<br>Username: ' . $newModel->get_nominee_login( $userID ) . '<br>Password: ' . $password . '</p>';
					
					$message .= '<p>Once you\'re logged in, you can access the <a href="https://www.goondiwindichamber.com.au/nominee">questionnaire here</a>, or by select the Business Awards menu, and then Nominee Questionnaire.</p><p>Be sure to save as you go and you can come back at any time.</p><p>This year you also have the option to submit a 30 to 90 second video presentation to compliment your submission. Be as creative as you like! This accounts to 10% of your score, however is not essential.</p><p>The Lowes Petroleum Business Awards Gala Event is on the 2nd June, 2017 with special guest Dr. Rolf Gomes! Be sure to like our Goondiwindi Chamber of Commerce Facebook page for all of the updates!</p><p>Kindest Regards,</p><p>Brooke Saxby<br>Executive Officer<br>Goondiwindi Chamber of Commerce</p>';
					
					$message .= '</div></body>';
					
					/*$message  = "Nominee: " . $_SESSION[ 'nominee-name' ] . PHP_EOL;
					$message .= "Award: " . $newModel->get_award_title( $_SESSION[ 'award' ] ) . PHP_EOL;
					$message .= "Category: " . $newModel->get_category_title( $_SESSION[ 'category' ] ) . PHP_EOL;
					$message .= "Reason: " . $_SESSION[ 'nominee-reason' ] . PHP_EOL;
					$message .= "Contact: " . $_SESSION[ 'nominee-contact' ] . PHP_EOL;
					$message .= PHP_EOL;
					$message .= "Nominator: " . $_SESSION[ 'nominator-first' ] . " " . $_SESSION[ 'nominator-last' ] . PHP_EOL;
					$message .= "Contact: " . $_SESSION[ 'nominator-phone' ] . " or " . $_SESSION[ 'nominator-email' ];
					$message .= PHP_EOL;
					$message .= "This nomination was assigned user (login) name: " . $newModel->get_nominee_login( $userID ) . PHP_EOL;
					$message .= "        With Password: " . $password . PHP_EOL;*/
					
					wp_mail( $to, $subject, $message, $header );
					
					
					$this->thank_you_page();
					
					
				} else {
					
					
					$_SESSION[ 'award' ] = null;
					
					$_SESSION[ 'category' ] = null;
					
					$_SESSION[ 'nominee-name' ] = null;
					
					$_SESSION[ 'nominee-reason' ] = null;
					
					$_SESSION[ 'nominee-contact' ] = null;
					
					$_SESSION[ 'nominator-first' ] = null;
					
					$_SESSION[ 'nominator-last' ] = null;
					
					$_SESSION[ 'nominator-email' ] = null;
					
					$_SESSION[ 'nominator-phone' ] = null;
					
					$_SESSION[ 'confirm' ] = null;
					
					
					$this->award_page();
					
					
				}
				
				
			}
			
			
			public function award_page() {
				
				
				require('ep-award-nominations-view.php');
				
				$newView = new epAwardNominationsView;
				
				$newView->award_view();
				
				
			}
			
			
			public function category_page() {
				
				
				require('ep-award-nominations-view.php');
				
				$newView = new epAwardNominationsView;
				
				$newView->category_view();
				
				
			}
			
			
			public function nominee_page() {
				
				
				require( 'ep-award-nominations-view.php' );
				
				$newView = new epAwardNominationsView;
				
				$newView->nominee_view();
				
				
			}
			
			
			public function nominator_page() {
				
				
				require( 'ep-award-nominations-view.php' );
				
				$newView = new epAwardNominationsView;
				
				$newView->nominator_view();
				
				
			}
			
			
			public function confirmation_page() {
				
				
				require( 'ep-award-nominations-view.php' );
				
				$newView = new epAwardNominationsView;
				
				$newView->confirmation_page();
				
				
			}
			
			
			public function thank_you_page() {
				
				
				require( 'ep-award-nominations-view.php' );
				
				$newView = new epAwardNominationsView;
				
				$newView->thank_you_page();
				
				
			}
			
			
		}
		
		
	}
?>
