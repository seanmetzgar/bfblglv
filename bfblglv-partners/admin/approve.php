<?php
  setlocale(LC_MONETARY, 'en_US.UTF-8');
  require_once('../inc/phpmailer/PHPMailerAutoload.php');
  require_once('../inc/_inc_mysql.php');
  require_once("../inc/_inc_uuid.php");
  require_once("../inc/_inc_helpers.php");

	$uuid = $_REQUEST["uuid"];
	$uuid = strlen($uuid) > 10 ? $uuid : false;
	$id = (int)$_REQUEST["id"];
	$id = is_int($id) ? $id : false;
	$valid_partner = false;

	if ($uuid  && $id) {
		$select_query = "SELECT * FROM registrations WHERE id=? AND uuid=? LIMIT 1";
		$select_statement = $mysqli->stmt_init();
		if ($select_statement->prepare($select_query)) {
			$select_statement->bind_param("is", $id, $uuid);
			$select_statement->execute();


			$select_result = $select_statement->get_result();
			if ($partner = $select_result->fetch_assoc()) {
				$valid_partner = count($partner) > 0 ? true : false;
			}
			$select_statement->close();
		}
	}


	if ($valid_partner):
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" class="no-js lt-ie10 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" class="no-js lt-ie10 lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html lang="en" class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="initial-scale=1, width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<title>Partner Applications | Buy Fresh Buy Local - Greater Lehigh Valley</title>

		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,700italic,400italic,300italic,300|Roboto+Slab:400,700,300,100">

		<link rel="stylesheet" type="text/css" href="/css/styles.css">
		<link rel="stylesheet" type="text/css" href="/css/vendor/datatables/datatables.css">
	</head>

	<body>
		<div class="site-wrapper">
			<div class="container">
				<p class="ir pre-title">Buy Fresh Buy Local Greater Lehigh Valley</p>
				<h1 class="title"><?php echo $partner["name"]; ?></h1>

				<section class="details-section">

					<div class="approval-controls text-center">
						<div class="btn-group approval-controls" role="group">
						<?php if ($partner["status"] == 0): ?>
						  	<a href="change_status.php?id=<?php echo $partner["id"]; ?>&amp;uuid=<?php echo $partner["uuid"]; ?>&amp;status=1" class="btn btn-primary approve">Approve</a>
					  		<a href="change_status.php?id=<?php echo $partner["id"]; ?>&amp;uuid=<?php echo $partner["uuid"]; ?>&amp;status=9" class="btn btn-warning decline">Decline</a>
						<?php endif; ?>
						<?php if ($partner["paid"] == 0): ?>
							<a href="change_paid.php?id=<?php echo $partner["id"]; ?>&amp;uuid=<?php echo $partner["uuid"]; ?>&amp;paid=1" class="btn btn-warning mark-paid">Mark as Paid</a>
						<?php endif; ?>
            <?php if ($partner["status"] == 1 && $partner["paid"] == 0): ?>
              <a href="resend_email.php?id=<?php echo $partner["id"]; ?>&amp;uuid=<?php echo $partner["uuid"]; ?>&amp;email=payment" class="btn btn-info send-email">Send Payment Email</a>
            <?php endif; ?>
            <?php if ($partner["status"] == 1 && $partner["paid"] == 1): ?>
              <a href="resend_email.php?id=<?php echo $partner["id"]; ?>&amp;uuid=<?php echo $partner["uuid"]; ?>&amp;email=continue" class="btn btn-info send-email">Send Continuation Email</a>
            <?php endif; ?>
						</div>

						<p class="current-status">
							<strong>Current Status:</strong> <?php echo niceStatusName($partner["status"]); ?><br>
							<strong>Paid:</strong> <?php echo nicePaymentStatus($partner["paid"]); ?>
						</p>
				 	</div>

					<h2>Business Details</h2>
					<table class="table table-striped table-bordered" width="100%">
						<tr>
							<th width="25%">Business Name</th>
							<td width="75%"><?php echo $partner["name"]; ?></td>
						</tr>
						<tr>
							<th>Primary County</th>
							<td><?php echo $partner["primary_county"]; ?></td>
						</tr>
						<tr>
							<th>Category</th>
							<td><?php echo niceCategoryName($partner["category"]); ?></td>
						</tr>
						<?php
							switch($partner["category"]) {
								case "vineyard":
									$category_output = "<tr>\n";
									$category_output .= "    <th>Acres of Grapes</th>\n";
									$categpry_output .= "    <td>{$partner["acres"]}</td>\n";
									$category_output .= "</tr>\n";
									break;
								case "farm":
									$category_output = "<tr>\n";
									$category_output .= "    <th>Acres of Products</th>\n";
									$categpry_output .= "    <td>{$partner["acres"]}</td>\n";
									$category_output .= "</tr>\n";
									$category_output .= "<tr>\n";
									$category_output .= "    <th>Products</th>\n";
									$categpry_output .= "    <td>{$partner["products"]}</td>\n";
									$category_output .= "</tr>\n";
									if (strlen($partner["other_products"]) > 0) {
										$category_output .= "<tr>\n";
										$category_output .= "    <th><em>Other Products</em></th>\n";
										$categpry_output .= "    <td>{$partner["other_products"]}</td>\n";
										$category_output .= "</tr>\n";
									}
									break;
								case "farmers-market":
								default:
									break;
							}
						?>
						<tr>
							<th width="25%">Business Address</th>
							<td width="75%">
								<?php
									echo $partner["billing_street"];
									if (strlen($partner["billing_street_2"]) > 0) {
										echo "<br>{$partner["billing_street_2"]}";
									}
									echo "<br>{$partner["billing_city"]}, {$partner["billing_state"]} {$partner["billing_zip"]}";
								?>
							</td>
						</tr>
						<?php if (strlen($partner["phone"]) > 0): ?>
						<tr>
							<th>Business Phone</th>
							<td><?php echo $partner["phone"]; ?></td>
						</tr>
						<?php endif;
						if (strlen($partner["email"]) > 0): ?>
						<tr>
							<th>Business Email</th>
							<td><?php echo $partner["email"]; ?></td>
						</tr>
						<?php endif;
						if (strlen($partner["website"]) > 0): ?>
						<tr>
							<th>Business Website</th>
							<td><?php echo $partner["website"]; ?></td>
						</tr>
						<?php endif; ?>
						<?php if (is_string($partner["sources"]) && strlen($partner["sources"]) > 0): ?>
						<tr>
							<th>Local Sources</th>
							<td><?php echo $partner["sources"]; ?></td>
						</tr>
						<?php endif; ?>
					</table>

					<h2>Point of Contact</h2>
					<table class="table table-striped table-bordered" width="100%">
						<tr>
							<th width="25%">Name</th>
							<td width="75%"><?php echo $partner["contact_name"]; ?></td>
						</tr>
						<?php if (strlen($partner["contact_job"]) > 0): ?>
						<tr>
							<th>Job Title</th>
							<td><?php echo $partner["contact_job"]; ?></td>
						</tr>
						<?php endif;
						if (strlen($partner["contact_phone"]) > 0): ?>
						<tr>
							<th>Phone</th>
							<td><?php echo $partner["contact_phone"]; ?></td>
						</tr>
						<?php endif;
						if (strlen($partner["contact_email"]) > 0): ?>
						<tr>
							<th>Email</th>
							<td><?php echo $partner["contact_email"]; ?></td>
						</tr>
						<?php endif; ?>
					</table>

					<h2>Payment Details</h2>
					<table class="table table-striped table-bordered" width="100%">
						<tr>
							<th width="25%">Paid?</th>
							<td width="75%"><?php echo nicePaymentStatus($partner["paid"]); ?></td>
						</tr>
						<tr>
							<th>Amount:</th>
							<td><?php echo money_format('%.2n', $partner["amount_owed"]); ?></td>
						</tr>
					</table>



					<div class="approval-controls text-center">
            <div class="btn-group approval-controls" role="group">
						<?php if ($partner["status"] == 0): ?>
						  	<a href="change_status.php?id=<?php echo $partner["id"]; ?>&amp;uuid=<?php echo $partner["uuid"]; ?>&amp;status=1" class="btn btn-primary approve">Approve</a>
					  		<a href="change_status.php?id=<?php echo $partner["id"]; ?>&amp;uuid=<?php echo $partner["uuid"]; ?>&amp;status=9" class="btn btn-warning decline">Decline</a>
						<?php endif; ?>
						<?php if ($partner["paid"] == 0): ?>
							<a href="change_paid.php?id=<?php echo $partner["id"]; ?>&amp;uuid=<?php echo $partner["uuid"]; ?>&amp;paid=1" class="btn btn-warning mark-paid">Mark as Paid</a>
						<?php endif; ?>
            <?php if ($partner["status"] == 1 && $partner["paid"] == 0): ?>
              <a href="resend_email.php?id=<?php echo $partner["id"]; ?>&amp;uuid=<?php echo $partner["uuid"]; ?>&amp;email=payment" class="btn btn-info send-email">Send Payment Email</a>
            <?php endif; ?>
            <?php if ($partner["status"] == 1 && $partner["paid"] == 1): ?>
              <a href="resend_email.php?id=<?php echo $partner["id"]; ?>&amp;uuid=<?php echo $partner["uuid"]; ?>&amp;email=continue" class="btn btn-info send-email">Send Continuation Email</a>
            <?php endif; ?>
						</div>

						<p class="current-status">
							<strong>Current Status:</strong> <?php echo niceStatusName($partner["status"]); ?><br>
							<strong>Paid:</strong> <?php echo nicePaymentStatus($partner["paid"]); ?>
						</p>
				 	</div>
				</section>



			</div>
		</div><!-- END: .site-wrapper -->

		<script src="/scripts/vendor/jquery/jquery.min.js"></script>
		<script src="/scripts/vendor/bootstrap-sass/bootstrap.min.js"></script>
		<script src="/scripts/vendor/datatables/datatables.js"></script>
		<script src="/scripts/plugins.min.js"></script>
		<script src="/scripts/scripts.min.js"></script>
	</body>
</html><?php endif; ?>
