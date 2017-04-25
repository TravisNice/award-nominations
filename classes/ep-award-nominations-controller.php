<?php
	/*
	 * Handles the workflow and decides where to take you next
	 *
	 * @package Award Nominations
	 * @subpackage Award Nominations Main Controller
	 * @since 1.0.0
	 */
	if (!class_exists('epAwardNominationsController')) {
		
		
		class epAwardNominationsController {
		
			
			public function __construct() {

				
				add_action('init', array($this, 'make_session'));
				
				
				add_action('the_post', array($this, 'page_director'));
			
			
			}
			
			
			public function make_session() {
			
				
				if (!session_id()) {
				
					session_start();
				
				} else {
				
					
					add_action('wp_logout', array($this, 'end_current_session'));
					
					add_action('wp_login', array($this, 'end_current_session'));
				
				
				}
		
			
			}
			
			
			public function end_current_session() {
			
				
				session_destroy();
			
			
			}
			
			
			public function page_director( $pageID ) {
			
				
				require('ep-award-nominations-model.php');
				
				$newModel = new epAwardNominationsModel;
				
				
				if (get_the_ID() == $newModel->get_nominate_page_id()) {
				
					
					require('ep-award-nominations-nominate-page-controller.php');
					
					if (in_the_loop()) $newPage = new epAwardNominationsNominatePageController;
				
				
				} elseif ( get_the_ID() == $newModel->get_nominee_page_id() ) {
				
					
					require('ep-award-nominations-nominee-page-controller.php');
					
					if ( in_the_loop() ) $newPage = new epAwardNominationsNomineePageController;
				
				
				}
			
			
			}
		
		
		}
	
	
	}
	
	
?>
