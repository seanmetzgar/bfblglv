<?php
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set("log_errors", 0);
ini_set("display_errors", 0);
// ini_set("error_log", BFBLGLV_BLC__PLUGIN_DIR . "/log/php-error.log");

class BFBL_GLV_Challenge {
	private static $initiated = false;
	private static $data_table_name = "bfblglv_blc_data";
	private static $settings_table_name = "bfblglv_blc_settings";

	public static function init_session() {
	    if(!session_id()) {
	        session_start();
	    }
	}
	public static function update_check() {
	    global $jal_db_version;
	    if ( get_site_option( "bfblglv_blc_db_version" ) != BFBLGLV_BLC__DB_VERSION ) {
	        self::run_install();
	    }
	}

	public static function run_install() {
		$current_db_version = get_option( "bfblglv_blc_db_version" );

		if ( $current_db_version != BFBLGLV_BLC__DB_VERSION ) {
			if (!isset($wpdb)) $wpdb = $GLOBALS['wpdb'];

	   		$data_table_full_name = $wpdb->prefix . self::$data_table_name;
	   		$settings_table_full_name = $wpdb->prefix . self::$settings_table_name;

	   		$charset_collate = $wpdb->get_charset_collate();

	   		$sql_settings_table = "CREATE TABLE $settings_table_full_name (
				id INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
				name TEXT NOT NULL,
				end_date DATE NOT NULL,
				form_headline_primary TEXT NOT NULL,
				form_headline_secondary TEXT NOT NULL,
				form_pledge_label TEXT NOT NULL,
				form_amount_label TEXT NOT NULL,
				form_people_label TEXT NOT NULL,
				form_name_label VARCHAR(30) NOT NULL,
				form_email_label VARCHAR(30) NOT NULL,
				form_phone_label VARCHAR(30) NOT NULL,
				form_zip_label VARCHAR(30) NOT NULL,
				form_optin_label TEXT NOT NULL,
				form_cta VARCHAR(50) NOT NULL,
				chart_headline TEXT NOT NULL,
				chart_callout TEXT NOT NULL,
				chart_text TEXT NOT NULL,
				insert_headline TEXT NOT NULL,
				insert_message TEXT NOT NULL,
				update_headline TEXT NOT NULL,
				update_message TEXT NOT NULL,
				error_headline TEXT NOT NULL,
				error_message TEXT NOT NULL,
				goal_amount BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
				status SMALLINT(3) NOT NULL DEFAULT 0,
				UNIQUE KEY id (id)
			) $charset_collate;";

			$sql_data_table = "CREATE TABLE $data_table_full_name (
				id INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
				challenge_id INT(8) UNSIGNED NOT NULL,
				weekly_amount INT(4) UNSIGNED NOT NULL,
				number_people INT(4) UNSIGNED NOT NULL,
				name TEXT NOT NULL,
				email TEXT NOT NULL,
				phone TEXT NOT NULL,
				zip TEXT NOT NULL,
				optin BOOLEAN NOT NULL DEFAULT FALSE,
				modified TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL,
				created TIMESTAMP NOT NULL,
				status SMALLINT(3) NOT NULL DEFAULT 1,
				UNIQUE KEY id (id)
			) $charset_collate;";

			require_once( ABSPATH . "wp-admin/includes/upgrade.php" );
			dbDelta( $sql_settings_table );
			dbDelta( $sql_data_table );
			update_option( "bfblglv_blc_db_version", BFBLGLV_BLC__DB_VERSION );
		}
	}

	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
	}

	private static function init_hooks() {
		self::$initiated = true;

		//self::architecture_customizations();
	}

	private static function page_link($action = "list", $id = 0) {
		$action = (is_string($action) && strlen($action) > 0) ? $action : "list";
		$rVal = admin_url("admin.php?page=" . BFBLGLV_BLC__PAGE_SLUG . "&action={$action}");
		if ($action == "edit" || $action == "update" || $action == "view") {
			$rVal .= "&challenge_id={$id}";
		}

		return $rVal;
	}

	private static function pledge_link($action = "delete", $id = 0, $challenge_id = 0) {
		$action = (is_string($action) && strlen($action) > 0) ? $action : "delete";
		$action .= "_pledge";
		$rVal = admin_url("admin.php?page=" . BFBLGLV_BLC__PAGE_SLUG . "&action={$action}");
		$rVal .= "&pledge_id={$id}&challenge_id={$challenge_id}";

		return $rVal;
	}

	private static function get_value($field_name, $challenge = false, $default_value = false, $pure = false, $echo = true) {
		$field_name = (is_string($field_name) && strlen($field_name) > 0) ? $field_name : false;
		$default_value = (is_string($default_value)) ? $default_value : "";
		$pure = is_bool($pure) ? $pure : false;
		$echo = is_bool($echo) ? $echo : true;
		$challenge = is_object($challenge) ? $challenge : false;

		$rVal = "";
		if ($field_name) {
			$value_string = ($challenge) ? $challenge->{$field_name} : $default_value;
			if ($field_name === "end_date") {
				$value_string = date_format(date_create($value_string), "m/d/Y");
			}
			$rVal = ($pure) ? $value_string : " value=\"" . esc_attr($value_string) . "\"";
		}

		if ($echo) echo $rVal;
		else return $rVal;
	}

	private static function get_challenge_total_amount($challenge_id) {
		if (!isset($wpdb)) $wpdb = $GLOBALS['wpdb'];
		$data_table_full_name = $wpdb->prefix . self::$data_table_name;
		$settings_table_full_name = $wpdb->prefix . self::$settings_table_name;
		$get_sum_sql = "SELECT SUM(a.weekly_amount * ROUND((DATEDIFF(b.end_date, CAST(a.created as date)) / 7), 0)) as total_amount FROM $data_table_full_name AS a JOIN $settings_table_full_name AS b WHERE a.challenge_id = b.id AND a.challenge_id = $challenge_id AND a.status = 1;";
    	$get_sum_results = $wpdb->get_results($get_sum_sql);
    	$total_amount = 0;
		if (is_array($get_sum_results) && count($get_sum_results) > 0) {
			$total_amount = $get_sum_results[0]->total_amount;
			if ($total_amount == NULL) {
				$total_amount = 0;
			}
		}
		return $total_amount;
	}

	private static function get_pledge_impact($pledge_id) {
		if (!isset($wpdb)) $wpdb = $GLOBALS['wpdb'];
		$data_table_full_name = $wpdb->prefix . self::$data_table_name;
		$settings_table_full_name = $wpdb->prefix . self::$settings_table_name;
		$get_impact_sql = "SELECT (a.weekly_amount * ROUND((DATEDIFF(b.end_date, CAST(a.created as date)) / 7), 0)) as impact FROM $data_table_full_name AS a JOIN $settings_table_full_name AS b WHERE a.challenge_id = b.id AND a.id = $pledge_id AND a.status = 1 LIMIT 1;";
    	$get_impact_results = $wpdb->get_results($get_impact_sql);
    	$impact = 0;
		if (is_array($get_impact_results) && count($get_impact_results) > 0) {
			$impact = $get_impact_results[0]->impact;
			if ($impact == NULL) {
				$impact = 0;
			}
		}
		return $impact;
	}

	private static function get_number_pledges($challenge_id) {
		if (!isset($wpdb)) $wpdb = $GLOBALS['wpdb'];
		$data_table_full_name = $wpdb->prefix . self::$data_table_name;
		$settings_table_full_name = $wpdb->prefix . self::$settings_table_name;
		$get_pledges_sql = "SELECT SUM(a.number_people) as pledges FROM $data_table_full_name as a JOIN $settings_table_full_name as b WHERE a.challenge_id = b.id AND a.challenge_id = $challenge_id AND a.status = 1;";
		$get_pledges_results = $wpdb->get_results($get_pledges_sql);
    	$pledges = 0;
		if (is_array($get_pledges_results) && count($get_pledges_results) > 0) {
			$pledges = $get_pledges_results[0]->pledges;
			if ($pledges == NULL) {
				$pledges = 0;
			}
		}
		return $pledges;
	}

	private static function pretty_number($number) {
		$abbreviations = array(12 => 'T', 9 => 'B', 6 => 'M', 3 => 'K', 0 => '');
		$rVal = $number;
		if (intval($number)) {
			$number = (int)$number;
			$rVal = $number;
			foreach($abbreviations as $exponent => $abbreviation) {
		        if($number >= pow(10, $exponent)) {
		            $rVal = "".round(number_format($number / pow(10, $exponent)),1).$abbreviation;
		            break;
		        }
		    }
		}
	    return $rVal;
	}

	public static function generate_admin_page() {
		if ( ! current_user_can( "edit_posts" ) ) {
            wp_die( "You're not supposed to be here..." );
        }
        if (!isset($wpdb)) $wpdb = $GLOBALS['wpdb'];
        $data_table_full_name = $wpdb->prefix . self::$data_table_name;
   		$settings_table_full_name = $wpdb->prefix . self::$settings_table_name;
   		$messages = array();
   		$form_data = array();

        $action = (isset($_REQUEST["action"]) && is_string($_REQUEST["action"]) && strlen($_REQUEST["action"]) > 0) ? $_REQUEST["action"] : "list";

        //If Edit / Update / View / Delete Pledge, make sure valid challenge id
        if ($action === "edit" || $action === "update" || $action === "view" || $action === "delete_pledge") {
        	if (isset($_REQUEST["challenge_id"]) && intval($_REQUEST["challenge_id"])) {
        		$challenge_id = (int)$_REQUEST["challenge_id"];
	        	if ($challenge_id === 0) {
	        		$challenge_id = null;
	        		$action = "list";
	        	} else {
	        		$get_challenge_sql = "SELECT * FROM $settings_table_full_name WHERE `id` = $challenge_id LIMIT 1";
	        		$get_challenge_results = $wpdb->get_results($get_challenge_sql);
	        		if (is_array($get_challenge_results) && count($get_challenge_results) === 1) {
	        			$challenge = $get_challenge_results[0];
	        		} else {
	        			$messages[] = "Challenge with the specified ID (#{$challenge_id}) does not exist.";
	        			$action = "list";
	        			$challenge_id = null;
	        		}
	        	}
        	} else {
        		$messages[] = "Invalid Challenge ID (#{$challenge_id}).";
        		$action = "list";
        	}
        }

        //If Insert / Update, make sure session_keys match & validate data
        if ($action == "insert" || $action == "update") {
        	if (isset($_SESSION["bfblglv-blc-session-key"]) && isset($_POST["session_key"]) && $_SESSION["bfblglv-blc-session-key"] == $_POST["session_key"]) {
        		$isValidSubmission = true;

        		$form_data = array();

	  			$form_data["name"] = (isset($_POST["name"]) && strlen($_POST["name"]) > 0) ? $_POST["name"] : "NO NAME";
	        	$form_data["end_date"] = (isset($_POST["end_date"]) && date_create($_POST["end_date"])) ? date_format(date_create($_POST["end_date"]), "Y-m-d") : "";
	        	$form_data["goal_amount"] = (isset($_POST["goal_amount"]) && intval($_POST["goal_amount"])) ? (int)$_POST["goal_amount"] : 200000;
	        	$form_data["form_headline_primary"] = isset($_POST["form_headline_primary"]) ? $_POST["form_headline_primary"] : "";
	        	$form_data["form_headline_secondary"] = isset($_POST["form_headline_secondary"]) ? $_POST["form_headline_secondary"] : "";
	        	$form_data["form_pledge_label"] = isset($_POST["form_pledge_label"]) ? $_POST["form_pledge_label"] : "";
	        	$form_data["form_amount_label"] = isset($_POST["form_amount_label"]) ? $_POST["form_amount_label"] : "";
	        	$form_data["form_people_label"] = isset($_POST["form_people_label"]) ? $_POST["form_people_label"] : "";
	        	$form_data["form_name_label"] = isset($_POST["form_name_label"]) ? $_POST["form_name_label"] : "";
	        	$form_data["form_email_label"] = isset($_POST["form_email_label"]) ? $_POST["form_email_label"] : "";
	        	$form_data["form_phone_label"] = isset($_POST["form_phone_label"]) ? $_POST["form_phone_label"] : "";
	        	$form_data["form_zip_label"] = isset($_POST["form_zip_label"]) ? $_POST["form_zip_label"] : "";
	        	$form_data["form_optin_label"] = isset($_POST["form_optin_label"]) ? $_POST["form_optin_label"] : "";
	        	$form_data["form_cta"] = isset($_POST["form_cta"]) ? $_POST["form_cta"] : "Submit";
	        	$form_data["chart_headline"] = isset($_POST["chart_headline"]) ? $_POST["chart_headline"] : "";
	        	$form_data["chart_callout"] = isset($_POST["chart_callout"]) ? $_POST["chart_callout"] : "";
	        	$form_data["chart_text"] = isset($_POST["chart_text"]) ? $_POST["chart_text"] : "";
	        	$form_data["insert_headline"] = isset($_POST["insert_headline"]) ? $_POST["insert_headline"] : "";
	        	$form_data["insert_message"] = isset($_POST["insert_message"]) ? $_POST["insert_message"] : "";
	        	$form_data["update_headline"] = isset($_POST["update_headline"]) ? $_POST["update_headline"] : "";
	        	$form_data["update_message"] = isset($_POST["update_message"]) ? $_POST["update_message"] : "";
	        	$form_data["error_headline"] = isset($_POST["error_headline"]) ? $_POST["error_headline"] : "";
	        	$form_data["error_message"] = isset($_POST["error_message"]) ? $_POST["error_message"] : "";
	        	$form_data["status"] = 1;
        	} else {
        		$messages[] = "Invalid Session Key.";
        		$action = "list";
        		$isValidSubmission = false;
        	}
        }

        //If Delete Pledge, make sure valid pledge id
        if ($action === "delete_pledge") {
        	if (isset($_REQUEST["pledge_id"]) && intval($_REQUEST["pledge_id"])) {
        		$pledge_id = (int)$_REQUEST["pledge_id"];
	        	if ($pledge_id === 0) {
	        		$pledge_id = null;
	        		$action = "list";
	        	} else {
	        		$get_pledge_sql = "SELECT * FROM $data_table_full_name WHERE `id` = $pledge_id LIMIT 1";
	        		$get_pledge_results = $wpdb->get_results($get_pledge_sql);
	        		if (is_array($get_pledge_results) && count($get_pledge_results) === 1) {
	        			$pledge = $get_pledge_results[0];
	        		} else {
	        			$messages[] = "Pledge with the specified ID (#{$pledge_id}) does not exist.";
	        			$action = "list";
	        			$challenge_id = null;
	        		}
	        	}
        	} else {
        		$messages[] = "Invalid Pledge ID (#{$pledge_id}).";
        		$action = "list";
        	}
        }

        //Run Insert
        if ($action === "insert" && $isValidSubmission) {
        	if ($wpdb->insert($settings_table_full_name, $form_data)) {
        		$messages[] = "Challenge added sucessfully.";
        	} else {
        		$messages[] = "There was an error while submitting your challenge.";
        	}
        	$action = "list";
        }

        //Run Update
        if ($action === "update" && $isValidSubmission) {
        	if ($wpdb->update($settings_table_full_name, $form_data, array("id" => $challenge_id))) {
        		$messages[] = "Challenge updated sucessfully.";
        	} else {
        		$messages[] = "There was an error while updating your challenge.";
        	}
        	$action = "list";
        }

        //Delete Pledge
        if ($action === "delete_pledge") {
        	if ($wpdb->update($data_table_full_name, array("status" => 9), array("id" => $pledge_id))) {
        		$messages[] = "Pledge deleted sucessfully.";
        	} else {
        		$messages[] = "There was an error while updating your pledge. {$pledge_id} / {$challenge_id}";
        	}
        	$action = "view";
        }

        $headerButtons = array();
        $headerButtons[] = "<a href=\"" . self::page_link("new") . "\" class=\"page-title-action\">Add New</a>";
        if ($action !== "list") $headerButtons[] = "<a href=\"" . self::page_link("list") . "\" class=\"page-title-action\">View All</a>";
        $headerButtons = implode(" ", $headerButtons);

        echo "<div class=\"wrap bfblglv-blc-wrap\">";
  			echo "<h1>Buy Local Challenge Settings $headerButtons</h1>";
  			echo "<hr>";
  			if (count($messages) > 0) {
  				echo "<div id=\"message\" class=\"notice-warning notice is-dismissible\">";
  				foreach($messages as $message) {
  					echo "<p>{$message}</p>";
  				}
  				echo "</div>";
  			}

  		switch ($action) {
  			case "edit":
  			case "new":
  				$isEdit = false;
  				if ($action === "edit") {
  					$isEdit = true;
  					$pageTitle = "Edit Listing:<br><small>{$challenge->name}</small>";
  					$formAction = self::page_link("update", $challenge->id);
  				} else {
  					$pageTitle = "Add New Challenge";
  					$formAction = self::page_link("insert");
  					$challenge = false;
  				}
?>

<form class="bfblglv-blc-form new-challenge" action="<?php echo $formAction; ?>" method="POST">
	<h2><?php echo $pageTitle; ?></h2>
	<label>Title
		<input type="text" name="name" <?php self::get_value("name", $challenge); ?> aria-required="true">
	</label>

	<label>End Date
		<input type="text" name="end_date" class="bfblglv-blc-datepicker" <?php self::get_value("end_date", $challenge); ?>>
	</label>

	<label>Goal Amount ($)
		<input type="number" min="1" max="999999999" name="goal_amount" <?php self::get_value("goal_amount", $challenge); ?>>
	</label>

	<hr>

	<h2>Form Details</h2>
	<label>Headline (Main)
		<input type="text" name="form_headline_primary" <?php self::get_value("form_headline_primary", $challenge, "Take the Challenge"); ?>>
	</label>

	<label>Pledge Checkbox Label
		<textarea name="form_pledge_label"><?php self::get_value("form_pledge_label", $challenge, "I pledge to spend more on locally grown foods each week throughout the 2016 growing season.", true); ?></textarea>
	</label>

	<label>Pledge Amount Label
		<input type="text" name="form_amount_label" <?php self::get_value("form_amount_label", $challenge, "How much per week?"); ?>>
	</label>

	<label>Number of People Label
		<input type="text" name="form_people_label" <?php self::get_value("form_people_label", $challenge, "For how many people?"); ?>>
	</label>

	<label>Headline (Personal Info)
		<input type="text" name="form_headline_secondary" <?php self::get_value("form_headline_secondary", $challenge, "Tell us about yourself"); ?>>
	</label>

	<label>Name Label
		<input type="text" name="form_name_label" <?php self::get_value("form_name_label", $challenge, "Name"); ?>>
	</label>

	<label>Email Label
		<input type="text" name="form_email_label" <?php self::get_value("form_email_label", $challenge, "Email"); ?>>
	</label>

	<label>Phone Label
		<input type="text" name="form_phone_label" <?php self::get_value("form_phone_label", $challenge, "Phone"); ?>>
	</label>

	<label>Zip Code Label
		<input type="text" name="form_zip_label" <?php self::get_value("form_zip_label", $challenge, "Zip"); ?>>
	</label>

	<label>Newsletter Opt-in Label
		<textarea name="form_optin_label"><?php self::get_value("form_optin_label", $challenge, "Yes, I’d like to receive the BFBLGLV newsletter", true); ?></textarea>
	</label>

	<label>Submit Button Text
		<input type="text" name="form_cta" <?php self::get_value("form_cta", $challenge, "Submit"); ?>>
	</label>

	<hr>

	<h2>Chart Details</h2>
	<label>Headline
		<input type="text" name="chart_headline" <?php self::get_value("chart_headline", $challenge, "Our Goal"); ?>>
	</label>

	<label>Callout
		<input type="text" name="chart_callout" <?php self::get_value("chart_callout", $challenge, "There's still time to pledge!"); ?>>
	</label>

	<label>Text
		<textarea name="chart_text"><?php self::get_value("chart_text", $challenge, "If we reach our goal of $200,000 it will help generate $300 million to our local economy.", true); ?></textarea>
	</label>

	<hr>

	<h2>Form Submission Messages</h2>
	<label>Success Headline
		<input type="text" name="insert_headline" <?php self::get_value("insert_headline", $challenge, "Thank You!"); ?>>
	</label>
	<label>Success Message
		<textarea name="insert_message"><?php self::get_value("insert_message", $challenge, "Your Buy Local Challenge Pledge has been recorded.", true); ?></textarea>
	</label>
	<label>Updated Entry Headline
		<input type="text" name="update_headline" <?php self::get_value("update_headline", $challenge, "Thanks Again!"); ?>>
	</label>
	<label>Updated Entry Message
		<textarea name="update_message"><?php self::get_value("update_message", $challenge, "We have updated your existing pledge accordingly.", true); ?></textarea>
	</label>
	<label>Error Headline
		<input type="text" name="error_headline" <?php self::get_value("error_headline", $challenge, "Whoops..."); ?>>
	</label>
	<label>Error Message
		<textarea name="error_message"><?php self::get_value("error_message", $challenge, "Looks like something went wrong, please try again later.", true); ?></textarea>
	</label>

	<?php
		$unique_key = wp_generate_password( 8, false );
		$_SESSION["bfblglv-blc-session-key"] = $unique_key;
		echo "<input type=\"hidden\" name=\"session_key\" value=\"{$unique_key}\">\n";
		if ($isEdit) echo "<input type=\"hidden\" name=\"challenge_id\" value=\"{$challenge->id}\">\n";
	?>
	<input type="submit" class="button action" value="<?php echo ($isEdit) ? "Update" : "Submit"; ?>">
</form>
<?php
  				break;
  			case "view":
?>
  				<h2>View Pledge Information</h2>
  				<p>Challenge: <?php echo $challenge->name; ?></p>
  				<hr>
<?php
  				$get_pledges_sql = "SELECT * FROM $data_table_full_name WHERE challenge_id = $challenge_id AND status = 1";
  				$pledges = $wpdb->get_results($get_pledges_sql);
  				if (is_array($pledges) && count($pledges) > 0) {
  					echo "<table class=\"bfblglv-blc-view display cell-border\">";
  						echo "<thead>";
  							echo "<tr>";
  								echo "<th align=\"left\">Name</th>";
  								echo "<th align=\"left\">Email</th>";
  								echo "<th align=\"left\">Zip</th>";
  								echo "<th align=\"left\">Phone</th>";
  								echo "<th align=\"left\">Weekly Amount</th>";
  								echo "<th align=\"left\">Total Pledge Impact</th>";
  								echo "<th align=\"left\">Number of People</th>";
  								echo "<th align=\"left\">Action</th>";
  							echo "</tr>";
  						echo "</thead>";
  						echo "<tbody>";
  						foreach ($pledges as $tempPledge) {
  							$tempPledgeID = $tempPledge->id;
  							$tempPledgeImpact = "$" . number_format(self::get_pledge_impact($tempPledgeID), 0, ".", ",");
  							$tempPledgeAmount = "$" . number_format($tempPledge->weekly_amount, 0, ".", ",");
  							$tempDeleteLink = self::pledge_link("delete", $tempPledgeID, $challenge_id);
  							echo "<tr>";
  								echo "<td align=\"left\">{$tempPledge->name}</td>";
  								echo "<td align=\"left\">{$tempPledge->email}</td>";
  								echo "<td align=\"left\">{$tempPledge->zip}</td>";
  								echo "<td align=\"left\">{$tempPledge->phone}</td>";
  								echo "<td align=\"left\">{$tempPledgeAmount}</td>";
  								echo "<td align=\"left\">{$tempPledgeImpact}</td>";
  								echo "<td align=\"left\">{$tempPledge->number_people}</td>";
  								echo "<td align=\"center\"><a class=\"button action dashicons-before dashicons-trash\" href=\"{$tempDeleteLink}\" title=\"Delete\" onclick=\"return window.confirm('Are you sure you want to delete this pledge?')\"><span>Delete</span></a></td>";
  							echo "</tr>";
  					}
  						echo "</tbody>";
  					echo "</table>";
  					echo "<hr>";
  					echo "<a href=\"/wp-admin/admin-ajax.php?action=xhr_download_pledges&challenge_id={$challenge_id}\" class=\"button action\">Download Pledges</a>";
  				} else { echo "<p><strong>No pledges found</strong></p>"; }
  				break;
  			case "list":
  			default:
  				$get_challenges_sql = "SELECT id, name, goal_amount, status FROM $settings_table_full_name";
  				$challenges = $wpdb->get_results($get_challenges_sql);
  				if (is_array($challenges) && count($challenges) > 0) {
  					echo "<table class=\"bfblglv-blc-list display cell-border\">";
  						echo "<thead>";
  							echo "<tr>";
  								echo "<th align=\"left\">Name</th>";
  								echo "<th align=\"center\">Goal</th>";
  								echo "<th align=\"center\">Amount Pledged</th>";
  								echo "<th align=\"center\">Shortcode</th>";
  								echo "<th align=\"center\">Action</th>";
  							echo "</tr>";
  						echo "</thead>";
  						echo "<tbody>";

  					foreach ($challenges as $tempChallenge) {
  							$tempChallengeID = $tempChallenge->id;
  							$tempTotalAmount = (int)self::get_challenge_total_amount($tempChallengeID);
  							$tempTotalAmount = "$" . number_format($tempTotalAmount, 0, ".", ",");
  							$editLink = self::page_link("edit", $tempChallengeID);
  							$viewLink = self::page_link("view", $tempChallengeID);
  							$tempChallengeGoal = number_format($tempChallenge->goal_amount, 0, ".", ",");
  							$tempChallengeGoal = "\${$tempChallengeGoal}";
  							echo "<tr>";
  								echo "<td align=\"left\"><a href=\"{$editLink}\">{$tempChallenge->name}</a></td>";
  								echo "<td align=\"center\">{$tempChallengeGoal}</td>";
  								echo "<td align=\"center\">{$tempTotalAmount}</td>";
  								echo "<td align=\"center\">[blc id={$tempChallenge->id}]</td>";
  								echo "<td align=\"center\"><a class=\"button action dashicons-before dashicons-edit\" href=\"{$editLink}\" title=\"Edit\"><span>Edit</span></a> <a class=\"button action
dashicons-before dashicons-carrot\" href=\"{$viewLink}\" title=\"Pledges\"><span>Pledges</span></a></td>";
  							echo "</tr>";
  					}
  						echo "</tbody>";
  					echo "</table>";
  				} else {
  					echo "<p><strong>No challenges found...</strong></p>";
  				}
  		}



  		echo "</div><!-- .wrap -->";
	}

	public static function blc_shortcode($atts) {
		$rVal = "";
		if (is_array($atts) && array_key_exists("id", $atts) && intval($atts["id"])) {
			if (!isset($wpdb)) $wpdb = $GLOBALS['wpdb'];
			$challenge_id = (int)$atts["id"];
			$settings_table_full_name = $wpdb->prefix . self::$settings_table_name;
			$data_table_full_name = $wpdb->prefix . self::$data_table_name;
			$get_challenge_sql = "SELECT * FROM $settings_table_full_name WHERE `id` = $challenge_id LIMIT 1;";
    		$get_challenge_results = $wpdb->get_results($get_challenge_sql);
    		$total_amount = self::get_challenge_total_amount($challenge_id);
    		$pretty_total_amount = self::pretty_number($total_amount);

    		if (is_array($get_challenge_results) && count($get_challenge_results) === 1) {
    			$challenge = $get_challenge_results[0];
    			$form_pledge_label = self::get_value("form_pledge_label", $challenge, "I pledge to spend more on locally grown foods each week throughout the 2016 growing season.", true, false);
				$form_optin_label = self::get_value("form_optin_label", $challenge, "Yes, I’d like to receive the BFBLGLV newsletter", true, false);
				$form_amount_label = self::get_value("form_amount_label", $challenge, "How much per week?", true, false);
				$form_people_label = self::get_value("form_people_label", $challenge, "For how many people?", true, false);

				$form_name_label = esc_attr(self::get_value("form_name_label", $challenge, "Name", true, false));
				$form_email_label = esc_attr(self::get_value("form_email_label", $challenge, "Email", true, false));
				$form_phone_label = esc_attr(self::get_value("form_phone_label", $challenge, "Phone", true, false));
				$form_zip_label = esc_attr(self::get_value("form_zip_label", $challenge, "Zip", true, false));
				$form_cta = self::get_value("form_cta", $challenge, "Submit", true, false);

				$insert_headline = self::get_value("insert_headline", $challenge, "Thank You!", true, false);
				$insert_message = nl2br(self::get_value("insert_message", $challenge, "Your Buy Local Challenge Pledge has been recorded.", true, false));
				$update_headline = self::get_value("update_headline", $challenge, "Thanks Again!", true, false);
				$update_message = nl2br(self::get_value("update_message", $challenge, "We have updated your existing pledge accordingly.", true, false));
				$error_headline = self::get_value("error_headline", $challenge, "Whoops...", true, false);
				$error_message = nl2br(self::get_value("error_message", $challenge, "Looks like something went wrong, please try again later.", true, false));
				$goal_amount = $challenge->goal_amount;
				$pretty_goal_amount = self::pretty_number($goal_amount);
				$total_amount = self::get_challenge_total_amount($challenge_id);
				$pretty_total_amount = self::pretty_number($total_amount);
				$carrot_title = "$".number_format($total_amount, 0, ".", ",");
				$carrot_title .= " of ";
				$carrot_title .= "$".number_format($goal_amount, 0, ".", ",");
				$carrot_title = esc_attr($carrot_title);

				$chart_headline = self::get_value("chart_headline", $challenge, "Our Goal", true, false);
				$chart_callout = self::get_value("chart_callout", $challenge, "There's still time to pledge!", true, false);
				$chart_text = self::get_value("chart_text", $challenge, "", true, false);

				if ($challenge->form_headline_primary) {
					$primary_headline = "<h2>";
					$pledges = self::get_number_pledges($challenge_id);
					if ($pledges > 1) {
						$primary_headline .= "<small>Join the {$pledges} people who have pledged</small>";
					}
					$primary_headline .= "{$challenge->form_headline_primary}</h2>";
				} else { $primary_headline = ""; }

    			$rVal = "<div class=\"container-fluid blc-display-wrap\"><div class=\"row\">";
    				$rVal .= "<div class=\"col-lg-5 col-sm-6 blc-chart-column col-lg-push-7 col-sm-push-6\">";
    					$rVal .= "<div class=\"blc-narrow-wrap\">";
    						$rVal .= "<h2>{$chart_headline}</h2>";
    						$rVal .= "<div class=\"carrot-chart-wrap\"><div class=\"carrot-chart\" data-goal=\"$goal_amount\" data-total=\"$total_amount\" data-goal-pretty=\"$pretty_goal_amount\" data-total-pretty=\"$pretty_total_amount\" title=\"$carrot_title\"></div></div>";
    						$rVal .= "<p class=\"callout\">{$chart_callout}</p>";
    						$rVal .= "<p>{$chart_text}</p>";
    					$rVal .= "</div>";
    				$rVal .= "</div>";
    				$rVal .= "<div class=\"col-lg-7 col-sm-6 blc-form-column col-lg-pull-5 col-sm-pull-6\">";
    					$rVal .= "<form class=\"blc-form\" method=\"POST\">";
	    					$rVal .= "<div class=\"blc-narrow-wrap\">";
	    						$rVal .= "{$primary_headline}";
		    					$rVal .= "<label class=\"check-label\"><input type=\"checkbox\" name=\"pledge\" value=\"1\"><span>{$form_pledge_label}</span></label>";
		    					$rVal .= "<label class=\"slider-label\"><span>{$form_amount_label}</span><input type=\"text\" name=\"amount\"></label>";
		    					$rVal .= "<label class=\"slider-label\"><span>{$form_people_label}</span><input type=\"text\" name=\"people\"></label>";
		    					$rVal .= ($challenge->form_headline_secondary) ? "<h3>{$challenge->form_headline_secondary}</h3>" : "";
		    				$rVal .= "</div>";

		    				$rVal .= "<div class=\"blc-wider-wrap\">";
		    					$rVal .= "<div class=\"blc-input-wrap\"><input type=\"text\" class=\"blc-input\" name=\"name\" placeholder=\"{$form_name_label}\" aria-label=\"{$form_name_label}\"></div>";
		    					$rVal .= "<div class=\"blc-input-wrap\"><input type=\"text\" class=\"blc-input\" name=\"email\" placeholder=\"{$form_email_label}\" aria-label=\"{$form_email_label}\"></div>";
		    					$rVal .= "<div class=\"blc-input-wrap\"><input type=\"text\" class=\"blc-input\" name=\"phone\" placeholder=\"{$form_phone_label}\" aria-label=\"{$form_phone_label}\"></div>";
		    					$rVal .= "<div class=\"blc-input-wrap\"><input type=\"text\" class=\"blc-input\" name=\"zip\" placeholder=\"{$form_zip_label}\" aria-label=\"{$form_zip_label}\"></div>";
		    				$rVal .= "</div>";

		    				$rVal .= "<div class=\"blc-extra-narrow-wrap\">";
		    					$rVal .= "<label class=\"check-label\"><input type=\"checkbox\" name=\"optin\" value=\"1\"><span>{$form_optin_label}</span></label>";
		    				$rVal .= "</div>";

		    				$rVal .= "<input type=\"hidden\" name=\"challenge_id\" value=\"{$challenge_id}\">";

		    				$rVal .= "<button type=\"submit\" class=\"bfblButtonLink btnBlueSolidWhiteHover\">{$form_cta}</button>";
	    				$rVal .= "</form>";
	    				$rVal .= "<div class=\"blc-form-success insert\"><div class=\"content\">";
	    					$rVal .= "<div class=\"blc-narrow-wrap\">";
	    						$rVal .= "<h2>{$insert_headline}</h2>";
	    						$rVal .= "<p>{$insert_message}</p>";
	    					$rVal .= "</div>";
	    				$rVal .= "</div></div>";
	    				$rVal .= "<div class=\"blc-form-success update\"><div class=\"content\">";
	    					$rVal .= "<div class=\"blc-narrow-wrap\">";
	    						$rVal .= "<h2>{$update_headline}</h2>";
	    						$rVal .= "<p>{$update_message}</p>";

	    					$rVal .= "</div>";
	    				$rVal .= "</div></div>";
	    				$rVal .= "<div class=\"blc-form-failure\"><div class=\"content\">";
	    					$rVal .= "<h2>{$error_headline}</h2>";
	    					$rVal .= "<p>{$error_message}</p>";
	    					$rVal .= "<p class=\"code\"></p>";
	    				$rVal .= "</div></div>";
    				$rVal .= "</div>";
    			$rVal .= "</div></div>";



    		} else {
    			$rVal = "<p>Error loading the Buy Local Challenge Form</p>";
    		}
		}
		return $rVal;
	}

   	public static function add_admin_pages() {
   		add_menu_page( "Buy Local Challenge Settings", "Buy Local Challenge", "edit_posts", BFBLGLV_BLC__PAGE_SLUG, array( __CLASS__, "generate_admin_page" ) );
   	}

   	public static function admin_enqueue_scripts( $hook ) {
        // load the scripts on only the plugin admin page ##
        if ( isset( $_GET['page'] ) && ( $_GET['page'] == BFBLGLV_BLC__PAGE_SLUG ) ) {
        	wp_enqueue_style( "jquery-style", "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css");
            wp_enqueue_style( "bfblglv-blc-admin-css", plugins_url( "css/admin-styles.css" ,__FILE__ ) );
            wp_enqueue_script( "jquery-ui-datepicker", false, array("jquery") );
            wp_enqueue_script( "bfblglv-blc-admin-scripts", plugins_url( "scripts/admin-scripts.min.js", __FILE__ ), array("jquery", "jquery-ui-datepicker") );
        }
    }

    public static function wp_enqueue_scripts( $hook ) {
    	wp_enqueue_style( "bfblglv-blc-css", plugins_url( "css/styles.css" ,__FILE__ ) );
        wp_enqueue_script( "bfblglv-blc-scripts", plugins_url( "scripts/scripts.min.js", __FILE__ ), array("jquery") );
        wp_localize_script("bfblglv-blc-scripts", "BFBLGLV_BLC_AJAX", array( "ajaxUrl" => admin_url("admin-ajax.php")));
    }

    public static function xhr_bfblglv_blc_add_data() {
    	$error = false;
    	$isUpdate = false;
    	$challenge_id = (isset($_REQUEST["challenge_id"]) && intval($_REQUEST["challenge_id"])) ? (int)$_REQUEST["challenge_id"] : false;
		$amount = (isset($_REQUEST["amount"]) && intval($_REQUEST["amount"])) ? (int)$_REQUEST["amount"] : false;
		$people = (isset($_REQUEST["people"]) && intval($_REQUEST["people"])) ? (int)$_REQUEST["people"] : false;
		$name = isset($_REQUEST["name"]) ? trim($_REQUEST["name"]) : false;
		$email = isset($_REQUEST["email"]) ? strtolower(trim($_REQUEST["email"])) : false;
		$phone = isset($_REQUEST["phone"]) ? trim($_REQUEST["phone"]) : false;
		$zip = isset($_REQUEST["zip"]) ? trim($_REQUEST["zip"]) : false;
		$optin = isset($_REQUEST["optin"]) ? true : false;

		if ($challenge_id && $amount && $people && $name && $email && $phone && $zip) {
			date_default_timezone_set("America/New_York");
			if (!isset($wpdb)) $wpdb = $GLOBALS['wpdb'];
			$data_table_full_name = $wpdb->prefix . self::$data_table_name;
			$email = strtolower($email);
			$insert_data = array();
			$insert_data["challenge_id"] = $challenge_id;
			$insert_data["weekly_amount"] = $amount;
			$insert_data["number_people"] = $people;
			$insert_data["name"] = $name;
			$insert_data["email"] = $email;
			$insert_data["phone"] = $phone;
			$insert_data["zip"] = $zip;
			$insert_data["optin"] = $optin;
			$insert_data["modified"] = date('Y-m-d G:i:s');
			$insert_data["status"] = 1;

			//First look for previous entry by email
			$data_checker_query = "SELECT id, email FROM `{$data_table_full_name}` WHERE `challenge_id` = '{$challenge_id}' AND `email` = '{$email}' LIMIT 1;";
			$data_checker_results = $wpdb->get_results($data_checker_query);

			if (is_array($data_checker_results) && count($data_checker_results) > 0) {
				$challenge_data = $data_checker_results[0];

				$challenge_data_id = $challenge_data->id;
				if ($wpdb->update($data_table_full_name, $insert_data, array("id" => $challenge_data_id))) {
	        		$error = false;
	        		$isUpdate = true;
	        	} else {
	        		$error = true;
	        		$code = "UPD-01";
	        	}
			} else {
				$insert_data["created"] = $insert_data["modified"];
				if ($wpdb->insert($data_table_full_name, $insert_data)) {
	        		$error = false;
	        	} else {
	        		$error = true;
	        		$code = "INS-01";
	        	}
			}
			if ($optin) {
				self::email_optin($email);
			}
		} else {
			$error = true;
			$code = "REQ-01";
		}
		$response = array();
		if ($error) {
			$response["status"] = "fail";
			$response["code"] = $code;
		} else {
			$response["status"] = "success";
			$response["type"] = $isUpdate ? "update" : "insert";
		}

		$response = json_encode($response);

		header('Content-Type: application/json');
		echo $response;

	   	die();
    }

    public static function xhr_download_pledges() {
    	$challenge_id = (isset($_REQUEST["challenge_id"]) && intval($_REQUEST["challenge_id"])) ? (int)$_REQUEST["challenge_id"] : false;

    	if ($challenge_id) {
    		/** Include PHPExcel */
	    	if (!class_exists("PHPExcel")) {
				require_once dirname(__FILE__) . '/extra-classes/PHPExcel.php';
			}

			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();
			//PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);

    		if (!isset($wpdb)) $wpdb = $GLOBALS['wpdb'];
			$data_table_full_name = $wpdb->prefix . self::$data_table_name;

    		$get_pledges_sql = "SELECT * FROM $data_table_full_name WHERE challenge_id = $challenge_id AND status = 1";
			$pledges = $wpdb->get_results($get_pledges_sql);

			if (is_array($pledges) && count($pledges) > 0) {
				// Set document properties
				$objPHPExcel->getProperties()->setCreator("BFBLGLV")
					->setLastModifiedBy("BFBLGLV")
					->setTitle("BFBLGLV Pledge Data")
					->setSubject("BFBLGLV Pledge Data Export")
					->setDescription("BFBLGLV Pledge Data Export")
					->setKeywords("")
					->setCategory("");

				// Add some data
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Name')
					->setCellValue('B1', 'Email')
					->setCellValue('C1', 'Phone')
					->setCellValue('D1', 'Zip')
					->setCellValue('E1', 'Weekly Amount')
					->setCellValue('F1', 'Total Pledge Impact')
					->setCellValue('G1', 'Number of People')
					->setCellValue('H1', 'Date Pledged')
					->setCellValue('I1', 'Last Updated')
					->setCellValue('J1', 'Newsletter Opt-in');

				$cellCounter = "1";
				foreach ($pledges as $pledge) {
					if (is_object($pledge)) {
						$cellCounter++;
						$pledgeImpact = self::get_pledge_impact($pledge->id);
						$pledgeOptin = ($pledge->optin) ? "Yes" : "No";
						$pledgeCreated = date_format(date_create($pledge->created), "d-M-Y");
						$pledgeModified = date_format(date_create($pledge->modified), "d-M-Y");
						$objPHPExcel->setActiveSheetIndex(0)
				            ->setCellValue('A' . $cellCounter, xlsBreaks($pledge->name))
				            ->setCellValue('B' . $cellCounter, xlsBreaks($pledge->email))
				            ->setCellValue('C' . $cellCounter, xlsBreaks($pledge->phone))
				            ->setCellValue('D' . $cellCounter, xlsBreaks($pledge->zip))
				            ->setCellValue('E' . $cellCounter, xlsBreaks($pledge->weekly_amount))
				            ->setCellValue('F' . $cellCounter, xlsBreaks($pledgeImpact))
				            ->setCellValue('G' . $cellCounter, xlsBreaks($pledge->number_people))
				            ->setCellValue('H' . $cellCounter, xlsBreaks($pledgeCreated))
				            ->setCellValue('I' . $cellCounter, xlsBreaks($pledgeModified))
							->setCellValue('J' . $cellCounter, xlsBreaks($pledgeOptin));
					}
				}

				foreach(range('A','J') as $letter) {
					$cell_num = 1;
					$cell = "" . $letter . $cell_num;
					$objPHPExcel->getActiveSheet()
						->getStyle($cell)
		    			->getFont()
		    			->setBold(true);
				}

				foreach(range('A','J') as $letter) {
					for ($j = 0; $j <= count($pledges); $j++) {
						$cell_num = $j + 1;
						$cell = "" . $letter . $cell_num;
						$objPHPExcel->getActiveSheet()
							->getStyle($cell)
			    			->getAlignment()
			    			->setWrapText(true)
			    			->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP)
			    			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					}
				}

				foreach(range('C','D') as $letter) {
					for ($j = 1; $j <= count($pledges); $j++) {
						$cell_num = $j + 1;
						$cell = "" . $letter . $cell_num;
						$objPHPExcel->getActiveSheet()
							->getStyle($cell)
			    			->getNumberFormat()
			    			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
					}
				}

				foreach(range('E','F') as $letter) {
					for ($j = 1; $j <= count($pledges); $j++) {
						$cell_num = $j + 1;
						$cell = "" . $letter . $cell_num;
						$objPHPExcel->getActiveSheet()
							->getStyle($cell)
			    			->getNumberFormat()
			    			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD);
					}
				}

				foreach(range('H','I') as $letter) {
					for ($j = 1; $j <= count($pledges); $j++) {
						$cell_num = $j + 1;
						$cell = "" . $letter . $cell_num;
						$objPHPExcel->getActiveSheet()
							->getStyle($cell)
			    			->getNumberFormat()
			    			->setFormatCode('dd-mmm-yyyy');
					}
				}

				foreach(range('A','J') as $letter) {
				    $objPHPExcel->getActiveSheet()
				    	->getColumnDimension($letter)
				        ->setAutoSize(true);
				}



				// Rename worksheet
				$objPHPExcel->getActiveSheet()->setTitle('Pledges');


				// Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(0);


				// Redirect output to a client’s web browser (Excel5)
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="challenge_pledges.xls"');
				header('Cache-Control: max-age=0');
				// If you're serving to IE 9, then the following may be needed
				header('Cache-Control: max-age=1');

				// If you're serving to IE over SSL, then the following may be needed
				header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
				header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
				header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
				header ('Pragma: public'); // HTTP/1.0

				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output');
				exit;
			} else {
				header('Location: ' . $_SERVER['HTTP_REFERER']);
				exit;
			}
    	} else {
    		header('Location: ' . $_SERVER['HTTP_REFERER']);
    		exit;
    	}
    }

    private static function email_optin($email) {
	    $url = "http://visitor.constantcontact.com/d.jsp";
		$fields = array(
			"m" => "1102172366972",
			"p" => "oi",
			"ea" => urlencode($email)
		);

		//url-ify the data for the POST
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');

		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);
	}
}

?>