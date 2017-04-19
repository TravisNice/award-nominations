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
					
					
					$_SESSION[ 'nominee-name' ] = sanitize_text_field(stripslashes_deep($_POST[ 'nominee-name' ]));
					
					$_SESSION[ 'nominee-reason' ] = sanitize_text_field(stripslashes_deep($_POST[ 'nominee-reason' ]));
					
					
					if ( $_POST[ 'nominee-contact' ] != "" ) {
						
						
						$_SESSION[ 'nominee-contact' ] = sanitize_email(stripslashes_deep($_POST[ 'nominee-contact' ]));
						
						
					} else {
						
						
						$_SESSION[ 'nominee-contact' ] = "No email provided";
						
						
					}
					
					
					$this->nominator_page();
					
					
				} elseif ( isset( $_POST['nominator-first' ] ) ) {
					
					
					$_SESSION[ 'nominator-first' ] = sanitize_text_field(stripslashes_deep($_POST[ 'nominator-first' ]));
					
					$_SESSION[ 'nominator-last' ] = sanitize_text_field(stripslashes_deep($_POST[ 'nominator-last' ]));
					
					if ( $_POST['nominator-email' ] != "" ) {
						
						
						$_SESSION[ 'nominator-email' ] = sanitize_email(stripslashes_deep($_POST[ 'nominator-email' ]));
						
						
					} else {
						
						
						$_SESSION[ 'nominator-email' ] = "No email provided";
						
						
					}
					
					
					if ( $_POST[ 'nominator-phone' ] != "" ) {
						
						
						$_SESSION[ 'nominator-phone' ] = sanitize_text_field(stripslashes_deep($_POST[ 'nominator-phone' ]));
						
						
					} else {
						
						
						$_SESSION[ 'nominator-phone' ] = "No phone provided";
						
						
					}
					
					
					$this->confirmation_page();
					
					
				} elseif ( isset( $_POST[ 'confirm' ] ) ) {
					
					
					$randomNumber = rand( 100000, 999999 );
					
					$userdata = array( 'user_login' => (string) $randomNumber,
							  'user_pass' => 'Ssy-8wD-23d-pPK',
							  'role' => 'epAwardNominee',
							  'show_admin_bar_front' => 'false',
							  'user_email' => $_SESSION[ 'nominee-contact' ],
							  'nickname' => $_SESSION[ 'nominee-name' ],
							  'description' => $_SESSION[ 'nominee-reason' ]
							  );
					
					$userID = wp_insert_user( $userdata );
					
					
					require( 'ep-award-nominations-model.php' );
					
					$newModel = new epAwardNominationsModel;
					
					$newModel->set_nomination( $_SESSION[ 'award' ],
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
