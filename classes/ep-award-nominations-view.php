<?php
	if (!class_exists('epAwardNominationsView')) {
		
		
		class epAwardNominationsView {
			
			
			public function clean_include( $file ) {
				
				
				ob_start();
				
				$content = require( $file );
				
				return ob_get_clean();
				
				
			}
			
			
			public function award_view() {
				
				
				add_filter('the_title', array($this, 'award_view_title'));
				
				add_filter('the_content', array($this, 'award_view_content'));
			
			
			}
			
			
			public function award_view_title( $title ) {
			
				
				$title = "For which award is your nomination?";
				
				return $title;
			}
			
			
			public function award_view_content( $content ) {
				
				
				$file = EP_AWARD_NOMINATIONS_PATH . "/includes/ep-award-nominations-award-content.php";
				
				$content = $this->clean_include( $file );
				
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
					
					
					$content .= '<h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Employee&#39;s Name:</h2>';
					
					$content .= '<p style="color: #000; font-size: 15px; max-width: 300px;"><input type="text" name="nominee-name" value=""></p>';
					
					$content .= '<h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Reason: (Inlcude Employer\'s Name Here)</h2>';
					
					$content .= '<p style="color: #000; font-size: 15px; max-width: 300px;"><textarea name="nominee-reason" value=""></textarea></p>';
					
					$content .= '<h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Employee&#39;s Email [if known]:</h2>';
					
					$content .= '<p style="color: #000; font-size: 15px; max-width: 300px;"><input type="text" name="nominee-contact" value=""></p>';
					
					
				} else {
					
					
					$content .= '<h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Business&#39;s Name:</h2>';
					
					$content .= '<p style="color: #000; font-size: 15px; max-width: 300px;"><input type="text" name="nominee-name" value=""></p>';
					
					$content .= '<h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Reason:</h2>';
					
					$content .= '<p style="color: #000; font-size: 15px; max-width: 300px;"><textarea name="nominee-reason" value=""></textarea></p>';
					
					$content .= '<h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Business&#39;s Email [if known]:</h2>';
					
					$content .= '<p style="color: #000; font-size: 15px; max-width: 300px;"><input type="text" name="nominee-contact" value=""></p>';
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
			
			
			public function confirmation_page() {
				
				
				add_filter( 'the_title', array( $this, 'confirmation_view_title' ) );
				
				add_filter( 'the_content', array( $this, 'confirmation_view_content' ) );
				
				
			}
			
			
			public function confirmation_view_title( $title ) {
				
				
				$title = "Please confirm your nomination is correct.";
				
				return $title;
				
				
			}
			
			
			public function confirmation_view_content( $content ) {
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				
				$content = '<h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Award:</h2><p style="color: #000; font-size: 15px; max-width: 300px;">' . $newModel->get_award_title( $_SESSION[ 'award' ] ) . '</p>';
				
				
				if ( $newModel->get_number_categories( $_SESSION[ 'award' ] ) ) {
					
					
					$content .= '<h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Category:</h2><p style="color: #000; font-size: 15px; max-width: 300px;">' . $newModel->get_category_title( $_SESSION[ 'category' ] ) . '</p>';
					
					
				}
				
				$content .= '<h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Nominee:</h2><p style="color: #000; font-size: 15px; max-width: 300px;">' . esc_html( $_SESSION[ 'nominee-name' ] ) . '</p><h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Reason:</h2><p style="color: #000; font-size: 15px; max-width: 300px;">' . esc_html( $_SESSION[ 'nominee-reason' ] ) . '</p><h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Nominee&#39;s Email:</h2><p style="color: #000; font-size: 15px; max-width: 300px;">' . esc_html( $_SESSION[ 'nominee-contact' ] ) . '</p><h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Your Name:</h2><p style="color: #000; font-size: 15px; max-width: 300px;">' . esc_html( $_SESSION['nominator-first'] ) . ' ' . esc_html( $_SESSION[ 'nominator-last' ] ) . '</p><h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Your Email:</h2><p style="color: #000; font-size: 15px; max-width: 300px;">' . esc_html( $_SESSION[ 'nominator-email' ] ) . '</p><h2 style="color: #000; font-size: 15px; font-weight: 600; max-width: 300px;">Your Phone Number:</h2><p style="color: #000; font-size: 15px; max-width: 300px;">' . esc_html( $_SESSION[ 'nominator-phone' ] ) . '</p><form name="nomination" method="post" action=""><input type="hidden" value="1" name="confirm"><p><input type="submit" value="Confirm"></p></form>';
				
				return $content;
				
				
			}
			
			
			public function thank_you_page() {
				
				
				add_filter( 'the_title', array( $this, 'thank_you_title' ) );
				
				add_filter( 'the_content', array( $this, 'thank_you_content' ) );
				
				
			}
			
			
			public function thank_you_title( $title ) {
				
				
				$title = 'Thank you for submitting your nomination.';
				
				return $title;
				
				
			}
			
			
			public function thank_you_content( $content ) {
				
				
				$content = '<p>Thank you for your nomination.</p><p>If you think of any other worthy nominees, be sure to make another nomination. You may make as many nominations as you like.</p><p>To ensure you stay up to date with the Business Awards, like and follow our Facebook page: <a href="https://www.facebook.com/GoondiwindiChamberOfCommerce/">Goondiwindi Chamber of Commerce</a></p>';
				
				return $content;
				
				
			}
			
			
			public function must_be_nominee() {
				
				
				add_filter( 'the_title', array( $this, 'must_be_nominee_title' ) );
				
				add_filter( 'the_content', array( $this, 'must_be_nominee_content' ) );
				
				
			}
			
			
			public function must_be_nominee_title( $title ) {
				
				
				$title = "Not Logged In";
				
				return $title;
				
				
			}
			
			
			public function must_be_nominee_content( $content ) {
				
				
				$content = '<p>You must be logged in as a registered nominee to use this page</p><p><a href="/my-account">Please login here</a></p>';
				
				return $content;
				
				
			}
			
			
			public function business_question_one() {
				
				
				add_filter( 'the_title', array( $this, 'business_question_one_title' ) );
				
				add_filter( 'the_content', array( $this, 'business_question_one_content' ) );
				
				
			}
			
			
			public function business_question_one_title( $title ) {
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				
				$title = $newModel->get_question_title( 1, 1 );
				
				return $title;
				
				
			}
			
			
			public function business_question_one_content( $content ) {
				
				
				$user = wp_get_current_user();
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				$answer = "";
				
				
				if ( $newModel->has_answered( 1, $user->ID ) ) {
					
					
					$answer = $newModel->get_answer( 1, $user->ID );
					
					
				}				
				
				$content = '<form name="nomination" method="post" action="">';
				
				$content .= '<p>' . $newModel->get_question_description( 1, 1 ) . '</p>';
				
				$content .= '<p style="color: #000; font-size: 15px; max-width: 600px;"><textarea name="business-question-one" value="">' . esc_textarea( $answer ). '</textarea></p>';
				
				$content .= '<button name="submit" value="next" style="margin: 16px 16px 16px 0;">Save & Next</button>';
				
				$content .= '<button name="submit" value="end" style="margin: 16px 16px 16px 0;">Save & End</button>';
				
				$content .= '</form>';
				
				return $content;
				
				
			}
			
			
			public function business_question_two() {
				
				
				add_filter( 'the_title', array( $this, 'business_question_two_title' ) );
				
				add_filter( 'the_content', array( $this, 'business_question_two_content' ) );
				
				
			}
			
			
			public function business_question_two_title( $title ) {
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				$title = $newModel->get_question_title( 1, 2 );
				
				return $title;
				
				
			}
			
			
			public function business_question_two_content( $content ) {
				
				
				$user = wp_get_current_user();
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				
				if ( $newModel->has_answered( 2, $user->ID ) ) {
					
					
					$answer = $newModel->get_answer( 2, $user->ID );
					
					
				} else {
					
					
					$answer = "";
					
					
				}
				
				
				$content = '<form name="nomination" method="post" action="">';
				
				$content .= '<p>' . $newModel->get_question_description( 1, 2 ) . '</p>';
				
				$content .= '<p style="color: #000; font-size: 15px; max-width: 600px;"><textarea name="business-question-two" value="">' . esc_textarea( $answer ) . '</textarea></p>';
				
				$content .= '<button name="submit" value="next" style="margin: 16px 16px 16px 0;">Save & Next</button>';
				
				$content .= '<button name="submit" value="end" style="margin: 16px 16px 16px 0;">Save & End</button>';
				
				$content .= '</form>';
				
				
				return $content;
			
			
			}
			
			
			public function business_question_three() {
				
				
				add_filter( 'the_title', array( $this, 'business_question_three_title' ) );
				
				add_filter( 'the_content', array( $this, 'business_question_three_content' ) );
				
				
			}
			
			
			public function business_question_three_title( $title ) {
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				$title = $newModel->get_question_title( 1, 3 );
				
				return $title;
				
				
			}
			
			
			public function business_question_three_content( $content ) {
				
				
				$user = wp_get_current_user();
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				
				if ( $newModel->has_answered( 3, $user->ID ) ) {
					
					
					$answer = $newModel->get_answer( 3, $user->ID );
					
					
				} else {
					
					
					$answer = "";
					
					
				}
				
				
				$content = '<form name="nomination" method="post" action="">';
				
				$content .= '<p>' . $newModel->get_question_description( 1, 3 ) . '</p>';
				
				$content .= '<p style="color: #000; font-size: 15px; max-width: 600px;"><textarea name="business-question-three" value="">' . esc_html( $answer ) . '</textarea></p>';
				
				$content .= '<button name="submit" value="next" style="margin: 16px 16px 16px 0;">Save & Next</button>';
				
				$content .= '<button name="submit" value="end" style="margin: 16px 16px 16px 0;">Save & End</button>';
				
				$content .= '</form>';
				
				
				return $content;
				
				
			}
			
			
			public function business_question_four() {
				
				
				add_filter( 'the_title', array( $this, 'business_question_four_title' ) );
				
				add_filter( 'the_content', array( $this, 'business_question_four_content' ) );
				
				
			}
			
			
			public function business_question_four_title( $title ) {
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				$title = $newModel->get_question_title( 1, 4 );
				
				return $title;
				
				
			}
			
			
			public function business_question_four_content( $content ) {
				
				
				$user = wp_get_current_user();
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				
				if ( $newModel->has_answered( 4, $user->ID ) ) {
					
					
					$answer = $newModel->get_answer( 4, $user->ID );
					
					
				} else {
					
					
					$answer = "";
					
					
				}
				
				
				$content = '<form name="nomination" method="post" action="">';
				
				$content .= '<p>' . $newModel->get_question_description( 1, 4 ) . '</p>';
				
				$content .= '<p style="color: #000; font-size: 15px; max-width: 600px;"><textarea name="business-question-four" value="">' . esc_html( $answer ) . '</textarea></p>';
				
				$content .= '<button name="submit" value="next" style="margin: 16px 16px 16px 0;">Save & Next</button>';
				
				$content .= '<button name="submit" value="end" style="margin: 16px 16px 16px 0;">Save & End</button>';
				
				$content .= '</form>';
				
				
				return $content;
				
				
			}
			
			
			public function business_question_five() {
				
				
				add_filter( 'the_title', array( $this, 'business_question_five_title' ) );
				
				add_filter( 'the_content', array( $this, 'business_question_five_content' ) );
				
				
			}
			
			
			public function business_question_five_title( $title ) {
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				$title = $newModel->get_question_title( 1, 5 );
				
				return $title;
				
				
			}
			
			
			public function business_question_five_content( $content ) {
				
				
				$user = wp_get_current_user();
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				
				$answer = "";
				
				
				if ( $newModel->has_answered( 5, $user->ID ) ) {
					
					
					$answer = $newModel->get_answer( 5, $user->ID );
					
					
				}
				
				
				$content = '<form name="nomination" method="post" action="">';
				
				$content .= '<p>' . $newModel->get_question_description( 1, 5 ) . '</p>';
				
				$content .= '<p style="color: #000; font-size: 15px; max-width: 600px;"><textarea name="business-question-five" value="">' . esc_html( $answer ) . '</textarea></p>';
				
				$content .= '<button name="submit" value="next" style="margin: 16px 16px 16px 0;">Save & Next</button>';
				
				$content .= '<button name="submit" value="end" style="margin: 16px 16px 16px 0;">Save & End</button>';
				
				$content .= '</form>';
				
				
				return $content;
				
				
			}
			
			
			public function business_question_six() {
				
				
				add_filter( 'the_title', array( $this, 'business_question_six_title' ) );
				
				add_filter( 'the_content', array( $this, 'business_question_six_content' ) );
				
				
			}
			
			
			public function business_question_six_title( $title ) {
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				$title = $newModel->get_question_title( 1, 6 );
				
				return $title;
				
				
			}
			
			
			public function business_question_six_content( $content ) {
				
				
				$user = wp_get_current_user();
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				
				$answer = "";
				
				
				if ( $newModel->has_answered( 6, $user->ID ) ) {
					
					
					$answer = $newModel->get_answer( 6, $user->ID );
					
					
				}
				
				
				$content = '<form name="nomination" method="post" action="">';
				
				$content .= '<p>' . $newModel->get_question_description( 1, 6 ) . '</p>';
				
				$content .= '<p style="color: #000; font-size: 15px; max-width: 600px;"><textarea name="business-question-six" value="">' . esc_html( $answer ) . '</textarea></p>';
				
				$content .= '<button name="submit" value="next" style="margin: 16px 16px 16px 0;">Save & Next</button>';
				
				$content .= '<button name="submit" value="end" style="margin: 16px 16px 16px 0;">Save & End</button>';
				
				$content .= '</form>';
				
				
				return $content;
				
				
			}
			
			
			public function employee_question_one() {
				
				
				add_filter( 'the_title', array( $this, 'employee_question_one_title' ) );
				
				add_filter( 'the_content', array( $this, 'employee_question_one_content' ) );
				
				
			}
			
			
			public function employee_question_one_title( $title ) {
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				
				$title = $newModel->get_question_title( 2, 7 );
				
				return $title;
				
				
			}
			
			
			public function employee_question_one_content( $content ) {
				
				
				$user = wp_get_current_user();
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				$answer = "";
				
				
				if ( $newModel->has_answered( 7, $user->ID ) ) {
					
					
					$answer = $newModel->get_answer( 7, $user->ID );
					
					
				}
				
				
				$content = '<form name="nomination" method="post" action="">';
				
				$content .= '<p>' . $newModel->get_question_description( 2, 7 ) . '</p>';
				
				$content .= '<p style="color: #000; font-size: 15px; max-width: 600px;"><textarea name="employee-question-one" value="">' . esc_textarea( $answer ). '</textarea></p>';
				
				$content .= '<button name="submit" value="next" style="margin: 16px 16px 16px 0;">Save & Next</button>';
				
				$content .= '<button name="submit" value="end" style="margin: 16px 16px 16px 0;">Save & End</button>';
				
				$content .= '</form>';
				
				return $content;
				
				
			}
			
			
			public function innovation_question_one() {
				
				
				add_filter( 'the_title', array( $this, 'innovation_question_one_title' ) );
				
				add_filter( 'the_content', array( $this, 'innovation_question_one_content' ) );
				
				
			}
			
			
			public function innovation_question_one_title( $title ) {
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				
				$title = $newModel->get_question_title( 3, 8 );
				
				return $title;
				
				
			}
			
			
			public function innovation_question_one_content( $content ) {
				
				
				$user = wp_get_current_user();
				
				
				require( 'ep-award-nominations-model.php' );
				
				$newModel = new epAwardNominationsModel;
				
				$answer = "";
				
				
				if ( $newModel->has_answered( 8, $user->ID ) ) {
					
					
					$answer = $newModel->get_answer( 8, $user->ID );
					
					
				}
				
				
				$content = '<form name="nomination" method="post" action="">';
				
				$content .= '<p>' . $newModel->get_question_description( 3, 8 ) . '</p>';
				
				$content .= '<p style="color: #000; font-size: 15px; max-width: 600px;"><textarea name="innovation-question-one" value="">' . esc_textarea( $answer ). '</textarea></p>';
				
				$content .= '<button name="submit" value="next" style="margin: 16px 16px 16px 0;">Save & Next</button>';
				
				$content .= '<button name="submit" value="end" style="margin: 16px 16px 16px 0;">Save & End</button>';
				
				$content .= '</form>';
				
				return $content;
				
				
			}
			
			
			public function video_upload() {
				
				add_filter( 'the_title', array( $this, 'video_upload_title' ) );
				
				add_filter( 'the_content', array( $this, 'video_upload_content' ) );
				
			}
			
			
			public function video_upload_title( $title ) {
				
				
				$title = "Video Upload";
				
				return $title;
				
				
			}
			
			
			public function video_upload_content( $content ) {
				
				
				$content = $this->clean_include(EP_AWARD_NOMINATIONS_PATH . "/includes/ep-award-nominations-video-upload-content.php");
				
				return $content;
				
				
			}
			
			
			public function nominee_confirmation() {
				
				
				add_filter( 'the_title', array( $this, 'nominee_confirmation_title' ) );
				
				add_filter( 'the_content', array( $this, 'nominee_confirmation_content' ) );
				
				
			}
			
			
			public function nominee_confirmation_title( $title ) {
				
				
				$title = "Review Submission";
				
				return $title;
				
				
			}
			
			public function nominee_confirmation_content( $title ) {
				
				
				require( 'ep-award-nominations-model.php' );
				$newModel = new epAwardNominationsModel;
				
				$user = wp_get_current_user();
				
				$content = '<p>Here are the fields you entered, please review them and make any changes you need. When you\'re happy with your answers, click on Submit. You can change your answers again later, simply follow through the <a href="/nominee">Nominee Questions</a> again. If you do change anything later, make sure you come back here and press submit again. We\'ll only accept your most recent submission</p>';
				
				$content .= '<form method="post" action="">';
				
				
				if ( $newModel->get_nominee_award( $user->ID ) === '1' ) {
					
					
					$content .= '<h2>' . $newModel->get_question_title( 1, 1 ) . '</h2>';
					$content .= '<p>' . $newModel->get_answer( 1, $user->ID ) . '</p>';
					$content .= '<button type="submit" name="change1">Change</button>';
					
					
					$content .= '<h2>' . $newModel->get_question_title( 1, 2 ) . '</h2>';
					$content .= '<p>' . $newModel->get_answer( 2, $user->ID ) . '</p>';
					$content .= '<button type="submit" name="change2">Change</button>';
					
					
					$content .= '<h2>' . $newModel->get_question_title( 1, 3 ) . '</h2>';
					$content .= '<p>' . $newModel->get_answer( 3, $user->ID ) . '</p>';
					$content .= '<button type="submit" name="change3">Change</button>';
					
					
					$content .= '<h2>' . $newModel->get_question_title( 1, 4 ) . '</h2>';
					$content .= '<p>' . $newModel->get_answer( 4, $user->ID ) . '</p>';
					$content .= '<button type="submit" name="change4">Change</button>';
					
					
					$content .= '<h2>' . $newModel->get_question_title( 1, 5 ) . '</h2>';
					$content .= '<p>' . $newModel->get_answer( 5, $user->ID ) . '</p>';
					$content .= '<button type="submit" name="change5">Change</button>';
					
					
					$content .= '<h2>' . $newModel->get_question_title( 1, 6 ) . '</h2>';
					$content .= '<p>' . $newModel->get_answer( 6, $user->ID ) . '</p>';
					$content .= '<button type="submit" name="change6">Change</button>';
					
					
				} elseif ( $newModel->get_nominee_award( $user->ID ) === '2' ) {
					
					
					$content .= '<h2>' . $newModel->get_question_title( 2, 7 ) . '</h2>';
					$content .= '<p>' . $newModel->get_answer( 7, $user->ID ) . '</p>';
					$content .= '<button type="submit" name="change7">Change</button>';
					
					
				} elseif ( $newModel->get_nominee_award( $user->ID ) === '3' ) {
					
					
					$content .= '<h2>' . $newModel->get_question_title( 3, 8 ) . '</h2>';
					$content .= '<p>' . $newModel->get_answer( 8, $user->ID ) . '</p>';
					$content .= '<button type="submit" name="change8">Change</button>';
					
				}
				
				
				if ( $newModel->has_attachment( $user->ID ) ) {
					
					
					$content .= '<h2>Video Upload</h2>';
					$content .= '<p>At least one file is uploaded.</p>';
					$content .= '<button type="submit" name="change9">Change</button>';
					
				} else {
					
					
					$content .= '<h2>Video Upload</h2>';
					$content .= '<p>No files have been uploaded.</p>';
					$content .= '<button type="submit" name="change9">Change</button>';
					
					
				}
				
				
				$content .= '<hr><p><button type="submit" name="confirm-nominee" style="margin: 16px 16px 16px 0;">Submit</button></p>';
				
				$content .= '</form>';
				
				return $content;
				
			}
	
	
		}
		
		
	}
?>
