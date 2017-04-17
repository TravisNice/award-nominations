<?php
	
	
	if (!class_exists('epAwardNominationsModel')) {
		
		
		class epAwardNominationsModel {
			
			
			private $databaseVersion;
			
			private $nominatePageID;
			
			private $nomineePageID;
			
			
			public function __construct() {
				
				
				$options = get_option('epAwardNominationsOptions');
				
				$this->set_database_version($options['databaseVersion']);
				
				$this->set_nominate_page_id($options['nominatePageID']);
				
				$this->set_nominee_page_id($options['nomineePageID']);
				
				
			}
			
			
				//	SETTERS
			
			public function set_database_version( $versionNumber ) {
				
				
				$this->databaseVersion = $versionNumber;
				
				
			}
			
			
			public function set_nominate_page_id( $id ) {
				
				
				$this->nominatePageID = $id;
				
				
			}
			
			
			public function set_nominee_page_id( $id ) {
				
				
				$this->nomineePageID = $id;
				
				
			}
			
			
				//	GETTERS
			
			
			public function get_database_version() {
				
				
				return $this->databaseVersion;
				
				
			}
			
			
			public function get_nominate_page_id() {
				
				
				return $this->nominatePageID;
				
				
			}
			
			
			public function get_nominee_page_id() {
				
				
				return $this->nomineePageID;
				
				
			}
			
			
			public function get_number_awards() {
				
				
				global $wpdb;
				
				$result = $wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}epan_award");
				
				return $result;
				
				
			}
			
			
			public function get_all_awards() {
				
				
				global $wpdb;
				
				$result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}epan_award");
				
				return $result;
				
				
			}
			
			
			public function get_number_categories( $awardID ) {
				
				
				global $wpdb;
				
				$result = $wpdb->get_var( "SELECT COUNT(id) FROM {$wpdb->prefix}epan_categories WHERE awardID='" . $awardID . "'" );
				
				return $result;
				
				
			}
			
			
			public function get_all_categories( $awardID ) {
				
				
				global $wpdb;
				
				$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}epan_categories WHERE awardID='" . $awardID . "'" );
				
				return $result;
				
				
			}
		}
	}
?>
