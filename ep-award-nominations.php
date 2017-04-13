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
	
	
	register_activation_hook ( __FILE__, 'epActivateAwardNominations' );
	
	function epActivateAwardNominations() {
		
		
			// Tell WordPress what to do when the user clicks on 'deactivate'
		
		register_deactivation_hook( __FILE__, 'ep_award_nominations_deactivate' );
		
		
			// Tell WordPress what to do when the user clicks on 'delete'
		
		register_uninstall_hook( __FILE__, 'ep_award_nominations_uninstall' );
		
		
			// Add custom roles
		
		add_role( 'epAwardNominee', 'Nominee', array( 'read' => true ) );
		
		add_role( 'ep_award_judge', 'Judge', array( 'read' => true ) );
		
		
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
		
		$epan_options = array('epan_db_version'             => '1',
				      'epan_nomination_page'        => $epanNominationPage,
				      'epan_nominee_page'           => $epanNomineePage
				      );
		
		add_option ( 'ep_award_nominations_options', $epan_options );
		
		
			// Setup our own database tables
		
		require_once( 'classes/epAwardNominationsController.php' );
		
		$newDatabase = new epAwardNominationsDatabaseController;
		
		$newDatabase->installDatabase();
		
		$newDatabase->insertTestData();
		
		
	}
	
	
	/*
	 * Uninstall functions
	 *
	 * @package Award Nominations
	 * @subpackage Award Nominations Main
	 * @since 1.0.0
	 */
	
	
	function ep_award_nominations_deactivate() {
		
		
		unregister_setting( 'ep_award_nominations_option_group', 'ep_award_nominations_options' );
		
		
	}
	
	
	function ep_award_nominations_uninstall() {
		
		
			//      Delete our custom roles
		
		remove_role( 'epAwardNominee' );
		
		remove_role( 'ep_award_judge' );
		
		
			//      Delete our custom pages
		
		$options = get_option( 'ep_award_nominations_options' );
		
		$postID = $options[ 'epan_nomination_page' ];
		
		wp_delete_post( $postID, true );
		
		$postID = $options[ 'epan_nominee_page' ];
		
		wp_delete_post( $postID, true );
		
		
			//      Delete what we put into the options
		
		delete_option( 'ep_award_nominations_options' );
		
		
			//      Delete our database tables
		
		require_once( 'classes/epAwardNominationsController.php' );
		
		$oldDatabase = new epAwardNominationsDatabaseController;
		
		$oldDatabase->uninstallDatabase();
		
		
	}
	
	
		//      This functions adds a settings link to the right of the activate and deactivate links on the plugin page
	
	
	function ep_award_nominations_settings_link ( $links ) {
		
		
		$settings_link = array (
					
					'<a href="' . admin_url ( 'options-general.php?page=ep_award_nominations_admin' ) . '">Settings</a>'
					
					);
		
		
		return array_merge( $settings_link, $links );
		
	}
	
	add_filter ( 'plugin_action_links_' . plugin_basename ( __FILE__ ), 'ep_award_nominations_settings_link' );
	
	
		//      Hand over to the Controller Class
	
	require_once( 'classes/epAwardNominationsController.php' );
	
	$startControl = new epAwardNominationsController;

	
?>
