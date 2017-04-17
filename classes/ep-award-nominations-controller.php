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
					
					
				}
				
				else {
					
					
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
					
					
					if (in_the_loop()) $newPage = new epAwardNominationsNominatePageController;
					
					
				}
				
				
			}
			
			
		}
		
		
	}
	
	
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
					
					
					$_SESSION[ 'category' ] = $_POST[ 'category' ];
					
					
					$this->nominee_page();
					
					
				} elseif ( isset( $_POST[ 'nominee-name' ] ) ) {
					
					
					$_SESSION[ 'nominee-name' ] = $_POST[ 'nominee-name' ];
					
					$_SESSION[ 'nominee-reason' ] = $_POST[ 'nominee-reason' ];
					
					
					if ( isset( $_POST[ 'nominee-contact' ] ) ) {
						
						
						$_SESSION[ 'nominee-contact' ] = $_POST[ 'nominee-contact' ];
						
						
					} else {
						
						
						$_SESSION[ 'nominee-contact' ] = "No Email Given";
						
						
					}
					
					
					$this->nominator_page();
					
					
				} elseif ( isset( $_POST['nominator-first' ] ) ) {
					
					
					$_SESSION[ 'nominator-first' ] = $_POST[ 'nominator-first' ];
					
					$_SESSION[ 'nominator-last' ] = $_POST[ 'nominator-last' ];
					
					if ( isset( $_POST['nominator-email' ] ) ) {
						
						
						$_SESSION[ 'nominator-email' ] = $_POST[ 'nominator-email' ];
						
						
					} else {
						
						
						$_SESSION[ 'nominator-email' ] = "No email provided";
						
						
					}
					
					
					if ( isset( $_POST[ 'nominator-phone' ] ) ) {
						
						
						$_SESSION[ 'nominator-phone' ] = $_POST[ 'nominator-phone' ];
						
						
					} else {
						
						
						$_SESSION[ 'nominator-phone' ] = "No phone given";
						
						
					}
					
					
					$this->confirmation_page();
					
					
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
			
			
		}
		
		
	}
	
	
	if (!class_exists('epAwardNominationsDatabaseController')) {
		
		
		class epAwardNominationsDatabaseController {
			
			
			public function install_database() {
				
				
				global $wpdb;
				
				$wpdb->query( "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}epan_award ( id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, title VARCHAR(60), description TEXT, PRIMARY KEY (id) ) {$wpdb->get_charset_collate()}" );
				
				$wpdb->query( "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}epan_categories ( id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, awardID INT(10) UNSIGNED NOT NULL, title VARCHAR(60), description TEXT, PRIMARY KEY (id) ) {$wpdb->get_charset_collate()}" );
				
				$wpdb->query( "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}epan_nominations ( id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, awardID INT(10) UNSIGNED NOT NULL, categoryID INT(10) UNSIGNED NOT NULL, nominee VARCHAR(60), reason TEXT, nomineeContact VARCHAR(60), nominatorFirst VARCHAR(60), nominatorLast VARCHAR(60), nominatorPhone VARCHAR(60), nominatorEmail VARCHAR(60), PRIMARY KEY (id) ) {$wpdb->get_charset_collate()}");
				
				$wpdb->query( "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}epan_questions ( id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, awardID INT(10) UNSIGNED NOT NULL, title TEXT, description LONGTEXT, PRIMARY KEY (id) ) {$wpdb->get_charset_collate()}" );
				
				$wpdb->query( "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}epan_answers ( id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, questionID INT(10) UNSIGNED NOT NULL, userID BIGINT(20) UNSIGNED NOT NULL, answer LONGTEXT, PRIMARY KEY (id) ) {$wpdb->get_charset_collate()}" );
				
				$wpdb->query( "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}epan_attachments ( id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, userID BIGINT(20) UNSIGNED NOT NULL, filename TEXT, PRIMARY KEY (id) ) {$wpdb->get_charset_collate()}" );
				
				$wpdb->flush();
				
				
			}
			
			public function insert_test_data() {
				
				
				global $wpdb;
				
					//	AWARDS
				
				$wpdb->query( "INSERT INTO {$wpdb->prefix}epan_award (id, title, description) VALUES (NULL, 'Business', 'Nominate a business that has provided exceptional service or performance in their field.')");
				
				$wpdb->query( "INSERT INTO {$wpdb->prefix}epan_award (id, title, description) VALUES (NULL, 'Employee', 'Nominate an employee you know who has gone above and beyond the call of their duties.')");
				
				$wpdb->query( "INSERT INTO {$wpdb->prefix}epan_award (id, title, description) VALUES (NULL, 'Innovation', 'Nominate a business that has implemented a significant innovation in either management, business practices, or in their products or services.')");
				
					//	CATEGORIES
				
				$wpdb->query("INSERT INTO {$wpdb->prefix}epan_categories (id, awardID, title, description) VALUES (NULL, 1, 'Agriculture', 'This award is for any business where more than 50% of the business relies on the Agricultural sector. E.g. farming, livestock, agronomy, export, chemicals & fertilisers, irrigation services, manufacturing, equipment supply, repairs & maintenance, engineering, ag contractors, transport, seed merchants, etc.')");
				
				$wpdb->query("INSERT INTO {$wpdb->prefix}epan_categories (id, awardID, title, description) VALUES (NULL, 1, 'Community Services', 'This award recognises organisations that implement initiatives that have a positive impact on the community, and generate outcomes that have a long term benefit.')");
				
				$wpdb->query("INSERT INTO {$wpdb->prefix}epan_categories (id, awardID, title, description) VALUES (NULL, 1, 'Hospitality & Tourism', 'This award is for any business involved in the hospitality & tourism industry. E.g. hotels, motels, caravan parks, tour operators, cafes, takeaways & restaurants, licensed clubs & bars, caterers, etc.')");
				
				$wpdb->query("INSERT INTO {$wpdb->prefix}epan_categories (id, awardID, title, description) VALUES (NULL, 1, 'Manual Trades', 'This award is for businesses that operate in a manual trade. E.g. hair & beauty, electrical, plumbing, building, glaziers, smash repairs, mechanics, graphic designer, taxi services, couriers, cleaners, waste management, landscapers, earth works, pest control, tattooists, concreting, quarries, security, locksmiths, cabinet makers, contractors, communications, solar energy suppliers, handyman services, etc.')");
				
				$wpdb->query("INSERT INTO {$wpdb->prefix}epan_categories (id, awardID, title, description) VALUES (NULL, 1, 'Professional Services', 'This award is for businesses that offer a professional service to individuals or other businesses. The business would supply a service, knowledge, or a skill – rather than a physical product. E.g. medicine, optometrist, veterinary, dental, accountants, solicitors, insurance, engineers, real estate, education & training, child care, architects, consultants, therapists, publishers, HR businesses, financial services, etc.')");
				
				$wpdb->query("INSERT INTO {$wpdb->prefix}epan_categories (id, awardID, title, description) VALUES (NULL, 1, 'Retail', 'This award is for any business in the retail and customer service sector. E.g. retailers, clothing, homewares & gifts, flooring, travel agents, online businesses, supermarkets, butchers, delicatessens, bakeries, florists, motor vehicle dealers, nurseries, newsagents, tyre services, exhaust suppliers, machinery sales, hire services, etc.')");
				
				$wpdb->query("INSERT INTO {$wpdb->prefix}epan_categories (id, awardID, title, description) VALUES (NULL, 2, 'Employee', 'Over 21 years of age')");
				
				$wpdb->query("INSERT INTO {$wpdb->prefix}epan_categories (id, awardID, title, description) VALUES (NULL, 2, 'Junior Employee', '21 years of age or younger')");
				
					//	NOMINEE'S QUESTIONS
				
				$wpdb->query("INSERT INTO {$wpdb->prefix}epan_questions (id, awardID, title, description) VALUES (NULL, 1, 'Business History', 'Please tell us, briefly, the story of how your business came to be where it is today. Note: this question is weighted 20% of the judging criteria.')");
				
				$wpdb->query("INSERT INTO {$wpdb->prefix}epan_questions (id, awardID, title, description) VALUES (NULL, 1, 'Marketing', 'Please tell us, briefly, how you make your products and services known to new prospects. Include plans you may have for future marketing endeavours.')");
				
				$wpdb->query("INSERT INTO {$wpdb->prefix}epan_questions (id, awardID, title, description) VALUES (NULL, 1, 'Staff Training', 'Please tell us, briefly, how your business trains and develops employee\'s skills.')");
				
				$wpdb->query("INSERT INTO {$wpdb->prefix}epan_questions (id, awardID, title, description) VALUES (NULL, 1, 'Successes of the last 12 months', 'Please tell us, briefly, any milestones or particular goals you have achieved during the last year.')");
				
				$wpdb->query("INSERT INTO {$wpdb->prefix}epan_questions (id, awardID, title, description) VALUES (NULL, 1, 'Business Plan', 'Please tell us, briefly, your plans for the next five years or thereabouts. Hint: consider this your elevator pitch.')");
				
				$wpdb->query("INSERT INTO {$wpdb->prefix}epan_questions (id, awardID, title, description) VALUES (NULL, 1, 'Community Support', 'Please tell us, briefly, how your business supports any local clubs, charities, or other groups.')");
				
				$wpdb->query("INSERT INTO {$wpdb->prefix}epan_questions (id, awardID, title, description) VALUES (NULL, 2, 'Employment History', 'Please tell us, briefly, the story of how you came to be employed by your business, what positions/roles you have held, and why you are the 2017 Goondiwindi Employee of the Year.')");
				
				$wpdb->query("INSERT INTO {$wpdb->prefix}epan_questions (id, awardID, title, description) VALUES (NULL, 3, 'Innovation History', 'Please tell us, briefly, the story of how your unique product/service came to be, and share some milestones or trials and tribulations.')");
				
				$wpdb->flush();
				
				
			}
			
			public function uninstallDatabase() {
				
				
				global $wpdb;
				
				$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}epan_attachments" );
				
				$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}epan_answers" );
				
				$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}epan_questions" );
				
				$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}epan_nominations" );
				
				$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}epan_categories" );
				
				$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}epan_award" );
				
				$wpdb->flush();
			
			
			}
		
		
		}
	
	
	}
	
	
?>
