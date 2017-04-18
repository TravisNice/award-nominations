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
			
			
			public function set_nomination( $awardID, $categoryID, $nominee, $reason, $nomineeContact, $userID, $nominatorFirst, $nominatorLast, $nominatorPhone, $nominatorEmail ) {
				
				
				global $wpdb;
				
				$table = "{$wpdb->prefix}epan_nominations";
				
				$columns = array( 'awardID' => $awardID,
						 'categoryID' => $categoryID,
						 'nominee' => $nominee,
						 'reason' => $reason,
						 'nomineeContact' => $nomineeContact,
						 'nomineeUserID' => $userID,
						 'nominatorFirst' => $nominatorFirst,
						 'nominatorLast' => $nominatorLast,
						 'nominatorPhone' => $nominatorPhone,
						 'nominatorEmail' => $nominatorEmail
				);
				
				$types = array( '%d',
					       '%d',
					       '%s',
					       '%s',
					       '%s',
					       '%d',
					       '%s',
					       '%s',
					       '%s',
					       '%s'
				);
				
				$result = $wpdb->insert( $table, $columns, $types );
				
				
			}
			
			
			public function set_answer( $question, $userID, $answer ) {
				
				
				global $wpdb;
				
				$table = "{$wpdb->prefix}epan_answers";
				
				$columns = array( 'questionID' => $question,
						  'userID' => $userID,
						  'answer' => $answer
				);
				
				$types = array( '%d',
					        '%d',
					        '%s'
				);
				
				$result = $wpdb->insert( $table, $columns, $types );
				
				
			}
			
			
			public function update_answer( $id, $answer ) {
				
				
				global $wpdb;
				
				$table = "{$wpdb->prefix}epan_answers";
				
				$data = array( 'answer' => $answer );
				
				$where = array( 'id' => $id );
				
				$format = array( '%s' );
				
				$where_format = array( '%d' );
				
				$result = $wpdb->update( $table, $data, $where, $format, $where_format );
				
				
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
			
			
			public function get_award_title( $id ) {
				
				
				global $wpdb;
				
				$result = $wpdb->get_var( "SELECT title FROM {$wpdb->prefix}epan_award WHERE id = '" . $id . "'" );
				
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
			
			
			public function get_category_title( $id ) {
				
				
				global $wpdb;
				
				$result = $wpdb->get_var( "SELECT title FROM {$wpdb->prefix}epan_categories WHERE id = '" . $id . "'" );
				
				return $result;
				
				
			}
			
			
			public function get_nominee_award( $userID ) {
				
				
				global $wpdb;
				
				$result = $wpdb->get_var( "SELECT id FROM {$wpdb->prefix}epan_nominations WHERE nomineeUserID = '" . $userID . "'" );
				
				return $result;
				
				
			}
			
			
			public function get_question_title( $awardID, $questionID ) {
				
				
				global $wpdb;
				
				$result = $wpdb->get_var( "SELECT title FROM {$wpdb->prefix}epan_questions WHERE awardID = '" . $awardID . "' AND id = '" . $questionID . "'" );
				
				return $result;
				
				
			}
			
			
			public function get_question_description( $awardID, $questionID ) {
				
				
				global $wpdb;
				
				$result = $wpdb->get_var( "SELECT description FROM {$wpdb->prefix}epan_questions WHERE awardID = '" . $awardID . "' AND id = '" . $questionID . "'" );
				
				return $result;
				
				
			}
			
			
			public function has_answered( $questionID, $userID ) {
				
				
				global $wpdb;
				
				$result = $wpdb->get_var( "SELECT id FROM {$wpdb->prefix}epan_answers WHERE questionID = '" . $questionID . "' AND userID = '" . $userID . "'" );
				
				return $result;
				
				
			}
			
			
			public function get_answer( $questionID, $userID ) {
				
				
				global $wpdb;
				
				$result = $wpdb->get_var( "SELECT answer FROM {$wpdb->prefix}epan_answers WHERE questionID = '" . $questionID . "' AND userID = '" . $userID . "'" );
				
				return $result;
				
				
			}
			
			
		}
		
		
	}
	
	
?>
