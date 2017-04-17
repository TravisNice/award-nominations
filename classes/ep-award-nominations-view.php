<?php
	
	
	if (!class_exists('epAwardNominationsView')) {
		
		
		class epAwardNominationsView {
			
			
			public function award_view() {
				
				
				add_filter('the_title', array($this, 'award_view_title'));
				
				add_filter('the_content', array($this, 'award_view_content'));
				
				
			}
			
			
			public function award_view_title($title) {
				
				
				$title = "For which award is your nomination?";
				
				return $title;
				
				
			}
			
			
			public function award_view_content($content) {
				
				
				require('ep-award-nominations-model.php');
				
				$newModel = new epAwardNominationsModel;
				
				$allAwards = $newModel->get_all_awards();
				
				
				$content = '<form name="nomination" method="post" action=""><h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;"><input style="margin-right: 16px;" type="radio" name="award" value="' . $allAwards[0]->id . '" checked>' . $allAwards[0]->title . '</h2><p style="color: #000; font-size: 15px; max-width: 300px;">' . $allAwards[0]->description . '</p>';
				
				for ($i = 1; $i < $newModel->get_number_awards(); $i++) {
					$content = $content . '<h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;"><input style="margin-right: 16px;" type="radio" name="award" value="' . $allAwards[$i]->id . '">' . $allAwards[$i]->title . '</h2><p style="color: #000; font-size: 15px; max-width: 300px;">' . $allAwards[$i]->description . '</p>';
				}
				
				$content .= '<p><input type="submit" value="Next"></p></form>';
				
				return $content;
				
				
			}
			
			
			public function category_view() {
				
				
				add_filter( 'the_title', array( $this, 'category_view_title' ) );
				
				add_filter( 'the_content', array( $this, 'category_view_content' ) );
				
				
			}
			
			
			public function category_view_title( $title ) {
				
				
				$title = "For which category is your nomination?";
				
				return $title;
				
				
			}
			
			
			public function category_view_content( $content ) {
				
				
				require('ep-award-nominations-model.php');
				
				$newModel = new epAwardNominationsModel;
				
				$allCategories = $newModel->get_all_categories( $_SESSION[ 'award' ] );
				
				
				$content = '<form name="nomination" method="post" action=""><h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;"><input style="margin-right: 16px;" type="radio" name="category" value="'. $allCategories[0]->id . '" checked>' . $allCategories[0]->title . '</h2><p style="color: #000; font-size: 15px; max-width: 300px;">' . $allCategories[0]->description . '</p>';
				
				for ( $i = 1; $i < $newModel->get_number_categories( $_SESSION[ 'award' ] ); $i++ ) {
					
					
					$content .= '<h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;"><input style="margin-right: 16px;" type="radio" name="category" value="'. $allCategories[$i]->id . '">' . $allCategories[$i]->title . '</h2><p style="color: #000; font-size: 15px; max-width: 300px;">' . $allCategories[$i]->description . '</p>';
					
					
				}
				
				$content .= '<p><input type="submit" value="Next"></p></form>';
				
				return $content;
				
				
			}
			
			
			public function nominee_view() {
				
				
				add_action( 'wp_footer', array( $this, 'validate_nominee' ) );
				
				add_filter( 'the_title', array( $this, 'nominee_view_title' ) );
				
				add_filter( 'the_content', array( $this, 'nominee_view_content' ) );
				
				
			}
			
			
			public function nominee_view_title( $title ) {
				
				
				$title = "Please explain for whom, and why you are making this nomination.";
				
				return $title;
				
				
			}
			
			
			public function nominee_view_content( $content ) {
				
				
				$content = '<form name="nomination" method="post" action="" onsubmit="return validateNominee()">';
				
				
				if ( $_SESSION[ 'award' ] === '2' ) {
					
					
					$content .= '<h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Employee&#39;s Name:</h2><p style="color: #000; font-size: 15px; max-width: 300px;"><input type="text" name="nominee-name" value=""></p><h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Reason:</h2><p style="color: #000; font-size: 15px; max-width: 300px;"><textarea name="nominee-reason" value=""></textarea></p><h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Employee&#39;s Email [if known]:</h2><p style="color: #000; font-size: 15px; max-width: 300px;"><input type="text" name="nominee-contact" value=""></p>';
					
					
				}
				
				else {
					
					
					$content .= '<h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Business&#39;s Name:</h2><p style="color: #000; font-size: 15px; max-width: 300px;"><input type="text" name="nominee-name" value=""></p><h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Reason:</h2><p style="color: #000; font-size: 15px; max-width: 300px;"><textarea name="nominee-reason" value=""></textarea></p><h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Business&#39;s Email [if known]:</h2><p style="color: #000; font-size: 15px; max-width: 300px;"><input type="text" name="nominee-contact" value=""></p>';
					
					
				}
				
				$content .= '<p><input type="submit" value="Next"></p></form>';
				
				
				return $content;
				
				
			}
			
			
			public function validate_nominee() {
				
				
				$script = '<script type="text/javascript">function validateNominee() {var nominee_name = document.forms["nomination"]["nominee-name"].value;var nominee_reason = document.forms["nomination"]["nominee-reason"].value;if (nominee_name == "") {alert( "You must provide the nominee\'s name to complete the nomination" );return false;}if (nominee_reason == "") {alert( "You must provide an explanation or reason to complete the nomination" );return false;}return true;}</script>';

				echo $script;
				
		
			}
			
			
			public function nominator_view() {
				
				
				add_action( 'wp_footer', array( $this, 'validate_nominator' ) );
				
				add_filter( 'the_title', array( $this, 'nominator_view_title' ) );
				
				add_filter( 'the_content', array( $this, 'nominator_view_content' ) );

				
			}
			
			
			public function nominator_view_title( $title ) {
				
				
				$title = "Please provide your contact details.";
				
				return $title;
				
				
			}
			
			
			public function nominator_view_content( $content ) {
				
				
				$content = '<p>We won\'t share your details with anyone, this is just so we know who to contact if we need any clarification of the nomination.</p><form name="nomination" method="post" action="" onsubmit="return validateNominator()"><h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Your First Name:</h2><p style="color: #000; font-size: 15px; max-width: 300px;"><input type="text" name="nominator-first" value=""></p><h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Your Last Name:</h2><p style="color: #000; font-size: 15px; max-width: 300px;"><input type="text" name="nominator-last" value=""></p><h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Your Email [optional]:</h2><p style="color: #000; font-size: 15px; max-width: 300px;"><input type="text" name="nominator-email" value=""></p><h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Your Phone Number [optional]:</h2><p style="color: #000; font-size: 15px; max-width: 300px;"><input type="text" name="nominator-phone" value=""></p><p><input type="submit" value="Next"></p></form>';
				
				return $content;
				
				
			}
			
			
			public function validate_nominator() {
				
				
				$script = '<script type="text/javascript">function validateNominator() {var nfirst = document.forms["nomination"]["nominator-first"].value;var nlast = document.forms["nomination"]["nominator-last"].value;if (nfirst == "") {alert("You must provide your first name to complete the nomination");return false;}if (nlast == "") {alert("You must provide your last name to complete the nomination");return false;}return true;}</script>';
				
				echo $script;
				
				
			}
	
	
		}
		
		
	}
?>
