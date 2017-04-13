<?php
	
	/*
         * Plugin Name: Business Awards Nominations
         * Plugin URI: https://www.everydaypublishing.com.au
         * Description: Setup for the Goondiwindi Chamber of Commerce
         * Version: 1.0.0
         * Author: Travis Nice
         * Author URI: https://www.everydaypublshing.com.au
         * License: GPL2
         * Licence URI: https://www.gnu.org/licenses/gpl-2.0.html
         * Text Domain: wordpress
         * Domain Path: /languages
         */
	
	
	defined ( 'ABSPATH' ) or die ( 'Get out of my plugin dammit!' );
	
	if ( !defined ( 'EP_AWARD_NOMINATIONS_PATH' ) ) {
		
		define ( 'EP_AWARD_NOMINATIONS_PATH', dirname ( __FILE__ ) );
		
	}
	
	
	/*
	 * Functions that are called at installation
	 *
	 * @package Award Nominations
	 * @subpackage Award Nominations Main
	 * @since 1.0.0
	 */
	
	
	register_activation_hook ( __FILE__, 'ep_activate_award_nominations' );
	
	function ep_activate_award_nominations() {
		
		
			// Tell WordPress what to do when the user clicks on 'deactivate'
		
		register_deactivation_hook( __FILE__, 'ep_award_nominations_deactivate' );
		
		
			// Tell WordPress what to do when the user clicks on 'delete'
		
		register_uninstall_hook( __FILE__, 'ep_award_nominations_uninstall' );
		
		
			// Add custom roles
		
		add_role( 'epAwardNominee', 'Nominee', array( 'read' => true ) );
		
		add_role( 'epAwardJudge', 'Judge', array( 'read' => true ) );
		
		
			// Create our own pages and their templates
		
		$epanNominationPageData = array('ID'              => 0,
						'post_title'      => 'Nominate',
						'post_status'     => 'publish',
						'post_type'       => 'page',
						'comment_status'  => 'closed',
						'ping_status'     => 'closed'
						);
		
		$epanNominationPage = wp_insert_post( $epanNominationPageData );
		
		
		$epanNomineePageData = array('ID'                  => 0,
					     'post_title'          => 'Nominee',
					     'post_status'         => 'publish',
					     'post_type'           => 'page',
					     'comment_status'      => 'closed',
					     'ping_status'         => 'closed'
					     );
		
		$epanNomineePage = wp_insert_post( $epanNomineePageData );
		
		
			//      Use the WordPress Database to store options -- This must be last as we want to store the page ID's we created
		
		$epanOptions = array( 'databaseVersion' => '1',
				      'nominationPageID' => $epanNominationPage,
				      'nomineePageID' => $epanNomineePage
		);
		
		add_option ( 'epAwardNominationsOptions', $epanOptions );
		
		
			// Setup our own database tables
		
		require_once( 'classes/ep-award-nominations-controller.php' );
		
		$newDatabase = new epAwardNominationsDatabaseController;
		
		$newDatabase->install_database();
		
		$newDatabase->insert_test_data();
		
		
	}
	
	
	/*
	 * Uninstall functions
	 *
	 * @package Award Nominations
	 * @subpackage Award Nominations Main
	 * @since 1.0.0
	 */
	
	
	function ep_award_nominations_deactivate() {
		
		
			//	unregister_setting( 'ep_award_nominations_option_group', 'ep_award_nominations_options' );
		
		
	}
	
	
	function ep_award_nominations_uninstall() {
		
		
			//      Delete our custom roles
		
		remove_role( 'epAwardNominee' );
		
		remove_role( 'epAwardJudge' );
		
		
			//      Delete our custom pages
		
		$options = get_option( 'epAwardNominationsOptions' );
		
		wp_delete_post( $options[ 'nominationPageID' ], true );
		
		wp_delete_post( $options[ 'nomineePageID' ], true );
		
		
			//      Delete what we put into the options
		
		delete_option( 'epAwardNominationsOptions' );
		
		
			//      Delete our database tables
		
		require_once( 'classes/ep-award-nominations-controller.php' );
		
		$oldDatabase = new epAwardNominationsDatabaseController;
		
		$oldDatabase->uninstallDatabase();
		
		
	}
	
	
		//      Hand over to the Controller Class
	
	require_once( 'classes/ep-award-nominations-controller.php' );
	
	$startControl = new epAwardNominationsController;

	
?>
