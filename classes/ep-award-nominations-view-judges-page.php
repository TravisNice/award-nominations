<?php
	if (!class_exists('epAwardNominationsView')) {
		class epAwardNominationsViewJudgesPage {
			
			public function clean_include( $file ) {
				ob_start();
				$content = include( $file );
				return ob_get_clean();
			}
			
			public function must_be_a_judge() {
				add_filter('the_title', array($this, 'must_be_a_judge_title'));
				add_filter('the_content', array($this, 'must_be_a_judge_content'));
			}
			
			public function must_be_a_judge_title($title) {
				return "You Are Not Allowed Here";
			}
			
			public function must_be_a_judge_content($content) {
				return "You must be an Administrator or a Registered Judge to see this page. Please log-in to use this page.";
			}
			
			public function show_nominations_table() {
				add_filter('the_title', array($this, 'show_nominations_table_title'));
				add_filter('the_content', array($this, 'show_nominations_table_content'));
			}
			
			public function show_nominations_table_title($title) {
				return "Nominations Summary";
			}
			
			public function show_nominations_table_content($content) {
				return $this->clean_include(EP_AWARD_NOMINATIONS_PATH.'/includes/ep-award-nominations-judges-summary-table.php');
			}
			
			public function show_nominees_table() {
				add_filter('the_title', array($this,'show_nominees_table_title'));
				add_filter('the_content', array($this,'show_nominees_table_content'));
			}
			
			public function show_nominees_table_title($title) {
				return "Nominee's Table";
			}
			
			public function show_nominees_table_content($content) {
				return $this->clean_include(EP_AWARD_NOMINATIONS_PATH.'/includes/ep-award-nominations-judges-nominee-table.php');
			}
			
			public function show_nominees_answers() {
				add_filter('the_title', array($this,'show_nominees_answers_title'));
				add_filter('the_content', array($this,'show_nominees_answers_content'));
			}
			
			public function show_nominees_answers_title($title) {
				return "Nominee's Answers";
			}
			
			public function show_nominees_answers_content($content) {
				return $this->clean_include(EP_AWARD_NOMINATIONS_PATH.'/includes/ep-award-nominations-judges-answer-table.php');
			}
		}
	}
?>
