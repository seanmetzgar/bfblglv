<?php
	$host = "mysql.buylocalglv.org";
	$user = "bfblglv_dba";
	$password = "WHnX06e3GtsoN3dmpN2r";
	$database = $_SERVER["SERVER_NAME"] == "partner.buylocalglv.org" ? "blglv_reg_live" : "blglv_reg_dev";

	$mysqli = new mysqli($host, $user, $password, $database);
