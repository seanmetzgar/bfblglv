<?php
	$server_name = $_SERVER["SERVER_NAME"];
	function struuid($entropy) {
	    $s=uniqid("",$entropy);
	    $num= hexdec(str_replace(".","",(string)$s));
	    $index = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $base= strlen($index);
	    $out = '';
	        for($t = floor(log10($num) / log10($base)); $t >= 0; $t--) {
	            $a = floor($num / pow($base,$t));
	            $out = $out.substr($index,$a,1);
	            $num = $num-($a*pow($base,$t));
	        }
	    return $out;
	}
	function getPhoto($photo_name) {
		$photo_name = is_string($photo_name) ? $photo_name : false;
		if ($photo_name) {
			$target_dir = "images/uploads/";
			$photo_name = "{$photo_name}_photo";
			$photocheck_name = "photocheck_{$photo_name}";
			$date = new DateTime();
			$timestamp = $date->getTimestamp();
			$unique = struuid(false);
			$target_file = $target_dir . $timestamp . "-{$unique}-" . basename($_FILES[$photo_name]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(isset($_POST[$photocheck_name])) {
					$check = getimagesize($_FILES[$photo_name]["tmp_name"]);
					if($check !== false) {
							$uploadOk = 1;
					} else {
							$uploadOk = 0;
					}
			}
			// Check if file already exists
			if (file_exists($target_file)) {
				$unique = struuid(false);
				$target_file = $target_dir . $timestamp . "-{$unique}-" . basename($_FILES[$photo_name]["name"]);
				if (file_exists($target_file)) {
					$uploadOk = 0;
				}
			}
			// Check file size
			if ($_FILES[$photo_name]["size"] > 5242880) {
					$uploadOk = 0;
			}
			// Allow certain file formats
			if(!in_array($imageFileType, array("jpg", "jpeg", "gif", "png"))) {
					$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			$rVal = false;
			if ($uploadOk == 1) {
					if (move_uploaded_file($_FILES[$photo_name]["tmp_name"], $target_file)) {
							$uploadOk = 1;
							$rVal = $target_file;
					} else {
							$uploadOk = 0;
					}
			}
		} else { $rVal = false; }
		return $rVal;
	}

	$featured_enabled = (isset($_POST["featured_enabled"]) && $_POST["featured_enabled"] === "1") ? true : false;

	$blocks_mjml = "";

	$about_title = isset($_POST["about_title"]) ? $_POST["about_title"] : "";
	$about_text = isset($_POST["about_text"]) ? $_POST["about_text"] : "";
	$menu_title = isset($_POST["menu_title"]) ? $_POST["menu_title"] : "";
	$menu_link_1_url = isset($_POST["menu_link_1_url"]) ? $_POST["menu_link_1_url"] : "";
	$menu_link_1_text = isset($_POST["menu_link_1_text"]) ? $_POST["menu_link_1_text"] : "";
	$menu_link_2_url = isset($_POST["menu_link_2_url"]) ? $_POST["menu_link_2_url"] : "";
	$menu_link_2_text = isset($_POST["menu_link_2_text"]) ? $_POST["menu_link_2_text"] : "";
	$menu_link_3_url = isset($_POST["menu_link_3_url"]) ? $_POST["menu_link_3_url"] : "";
	$menu_link_3_text = isset($_POST["menu_link_3_text"]) ? $_POST["menu_link_3_text"] : "";
	$menu_link_4_url = isset($_POST["menu_link_4_url"]) ? $_POST["menu_link_4_url"] : "";
	$menu_link_4_text = isset($_POST["menu_link_4_text"]) ? $_POST["menu_link_4_text"] : "";

	// $social_title = isset($_POST["social_title"]) ? $_POST["social_title"] : "";
	// $twitter_url = isset($_POST["twitter_url"]) ? $_POST["twitter_url"] : "";
	// $facebook_url = isset($_POST["facebook_url"]) ? $_POST["facebook_url"] : "";
	// $youtube_url = isset($_POST["youtube_url"]) ? $_POST["youtube_url"] : "";
	// $instagram_url = isset($_POST["instagram_url"]) ? $_POST["instagram_url"] : "";

	if ($featured_enabled) {
		$featured_photo = getPhoto("featured");
		$featured_title = isset($_POST["featured_title"]) ? $_POST["featured_title"] : "";
		$featured_subtitle = isset($_POST["featured_subtitle"]) ? $_POST["featured_subtitle"] : "";
		$featured_text = isset($_POST["featured_text"]) ? $_POST["featured_text"] : "";
		$featured_cta = isset($_POST["featured_cta"]) ? $_POST["featured_cta"] : "";
		$featured_url = isset($_POST["featured_url"]) ? $_POST["featured_url"] : "";

		ob_start();
?>
	<!-- START: FEATURE -->
	<div style="margin:0 auto;max-width:10000px;background:#F7ECD5;">
		<table cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#F7ECD5;" align="center" border="0">
		<tbody>
		<tr>
			<td style="text-align:center;vertical-align:top;font-size:0px;padding:30px 10px 16px 10px;">
				<!--[if mso | IE]>
      <table border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:10000px;">
      <![endif]-->
				<div aria-labelledby="mj-column-per-100" class="mj-column-per-100" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;">
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tbody>
					<?php if ($featured_photo): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:0px;" align="center">
							<table cellpadding="0" cellspacing="0" style="color:#000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;" width="auto" border="0">
							<tr>
								<td style="padding: 9px; border: 1px solid #193282;">
									<? if ($featured_url): ?>
									<a href="<?php echo $featured_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=feature_image" target="_blank"><img src="<?php echo "http://{$server_name}/{$featured_photo}"; ?>" style="display: block; width: 100%; height: auto; margin: 0; padding: 0; max-width: 580px;" vspace="0" hspace="0" border="0"></a>
                					<?php else: ?>
               						<img src="<?php echo "http://{$server_name}/{$featured_photo}"; ?>" style="display: block; width: 100%; height: auto; margin: 0; padding: 0; max-width: 580px;" vspace="0" hspace="0" border="0">
               						<?php endif; ?>
								</td>
							</tr>
							</table>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ($featured_title): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:10px 15px 0px;" align="center">
							<div style="cursor:auto;color:#193282;font-family:Verdana, sans-serif;font-size:24px;font-weight:bold;line-height:28px;text-transform:uppercase;">
								<div style="max-width: 580px;">
									<? if ($featured_url): ?>
									<a href="<?php echo $featured_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=feature_title" target="_blank" style="text-decoration: none; color: inherit;"><?php echo $featured_title; ?></a>
                					<?php else: ?>
               						<span style="text-decoration: none; color: inherit;"><?php echo $featured_title; ?></span>
               						<?php endif; ?>
								</div>
							</div>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ($featured_title && $featured_subtitle): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:4px 15px 0px;" align="center">
							<div style="cursor:auto;color:#555555;font-family:Verdana, sans-serif;font-size:14px;font-style:italic;font-weight:bold;line-height:18px;text-transform:uppercase;">
								<div style="max-width: 580px;">
									<? if ($featured_url): ?>
									<a href="<?php echo $featured_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=feature_subtitle" target="_blank" style="text-decoration: none; color: inherit;"><?php echo $featured_subtitle; ?></a>
                					<?php else: ?>
               						<span style="text-decoration: none; color: inherit;"><?php echo $featured_subtitle; ?></span>
               						<?php endif; ?>
								</div>
							</div>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ($featured_text): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:10px 15px 0px;" align="center">
							<div style="cursor:auto;color:#000000;font-family:Verdana, sans-serif;font-size:14px;line-height:18px;">
								<div style="max-width: 580px;">
									<?php echo nl2br($featured_text); ?>
								</div>
							</div>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ($featured_cta && $featured_url): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:15px;" align="center">
							<table cellpadding="0" cellspacing="0" style="border:none;border-radius:0px;" align="center" border="0">
							<tbody>
							<tr>
								<td style="background:#193282;border-radius:0px;color:#FFFFFF;cursor:auto;" align="center" valign="middle" bgcolor="#193282">
									<a href="<?php echo $featured_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=feature_button" style="display:inline-block;text-decoration:none;background:#193282;border:1px solid #193282;border-radius:0px;color:#FFFFFF;font-family:Verdana, sans-serif;font-size:13px;font-weight:bold;padding:15px;" target="_blank"><?php echo $featured_cta; ?></a>
								</td>
							</tr>
							</tbody>
							</table>
						</td>
					</tr>
					<?php endif; ?>
					</tbody>
					</table>
				</div>
				<!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
			</td>
		</tr>
		</tbody>
		</table>
	</div>
	<!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
	<!--[if mso | IE]>
      <table border="0" cellpadding="0" cellspacing="0" width="10000" align="center" style="width:10000px;">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
	<!-- END: FEATURE -->
<?php
		$blocks_mjml .= ob_get_contents();
		ob_end_clean();
	}

	$number_email_blocks = (isset($_POST["number_email_blocks"]) && intval($_POST["number_email_blocks"])) ? (int)$_POST["number_email_blocks"] : 0;

	if ($number_email_blocks > 0) {
		for ($i =1; $i <= $number_email_blocks; $i++) {
			$block_type = isset($_POST["block_{$i}_type"]) ? $_POST["block_{$i}_type"] : "";
			switch ($block_type) {
				case "double-chips":
					$block_a_photo = getPhoto("block_{$i}a");
					$block_b_photo = getPhoto("block_{$i}b");
					$block_a_title = isset($_POST["block_{$i}a_title"]) ? $_POST["block_{$i}a_title"] : "";
					$block_b_title = isset($_POST["block_{$i}b_title"]) ? $_POST["block_{$i}b_title"] : "";
					$block_a_url = isset($_POST["block_{$i}a_url"]) ? $_POST["block_{$i}a_url"] : "";
					$block_b_url = isset($_POST["block_{$i}b_url"]) ? $_POST["block_{$i}b_url"] : "";

					if ($block_a_photo && $block_b_photo && $block_a_url && $block_b_url) {

						ob_start(); ?>

<!-- START: CHIPS -->
	<div style="margin:0 auto;max-width:10000px;background:#FFFFFF;">
		<table cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#FFFFFF;" align="center" border="0">
		<tbody>
		<tr>
			<td style="text-align:center;vertical-align:top;font-size:0px;padding:30px 10px 16px 10px;">
				<!--[if mso | IE]>
      <table border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:295px;">
      <![endif]-->
				<div aria-labelledby="mj-column-px-295" class="mj-column-px-295" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;">
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tbody>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:0px;" align="left">
							<table cellpadding="0" cellspacing="0" style="color:#000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;" width="auto" border="0">
							<tr>
								<td style="padding: 9px; border: 1px solid #008C5C;">
									<a href="<?php echo $block_a_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=chip_image" target="_blank"><img src="<?php echo "http://{$server_name}/{$block_a_photo}"; ?>" style="display: block; width: 100%; height: auto; margin: 0; padding: 0;" vspace="0" hspace="0" border="0"></a>
								</td>
							</tr>
							</table>
						</td>
					</tr>
					<?php if ($block_a_title): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:5px 15px 14px;" align="center">
							<div style="cursor:auto;color:#008C5C;font-family:Verdana, sans-serif;font-size:14px;font-weight:bold;line-height:18px;text-transform:uppercase;">
								<a href="<?php echo $block_a_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=chip_title" target="_blank" style="text-decoration: none; color: inherit;"><?php echo $block_a_title; ?></a>
							</div>
						</td>
					</tr>
					<?php endif; ?>
					</tbody>
					</table>
				</div>
				<!--[if mso | IE]>
      </td><td style="vertical-align:top;width:10px;">
      <![endif]-->
				<div aria-labelledby="mj-column-px-10" class="mj-column-px-10" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;">
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tbody>
					</tbody>
					</table>
				</div>
				<!--[if mso | IE]>
      </td><td style="vertical-align:top;width:295px;">
      <![endif]-->
				<div aria-labelledby="mj-column-px-295" class="mj-column-px-295" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;">
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tbody>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:0px;" align="left">
							<table cellpadding="0" cellspacing="0" style="color:#000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;" width="auto" border="0">
							<tr>
								<td style="padding: 9px; border: 1px solid #008C5C;">
									<a href="<?php echo $block_b_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=chip_image" target="_blank"><img src="<?php echo "http://{$server_name}/{$block_b_photo}"; ?>" style="display: block; width: 100%; height: auto; margin: 0; padding: 0;" vspace="0" hspace="0" border="0"></a>
								</td>
							</tr>
							</table>
						</td>
					</tr>
					<?php if ($block_b_title): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:5px 15px 14px;" align="center">
							<div style="cursor:auto;color:#008C5C;font-family:Verdana, sans-serif;font-size:14px;font-weight:bold;line-height:18px;text-transform:uppercase;">
								<a href="<?php echo $block_b_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=chip_title" target="_blank" style="text-decoration: none; color: inherit;"><?php echo $block_b_title; ?></a>
							</div>
						</td>
					</tr>
					<?php endif; ?>
					</tbody>
					</table>
				</div>
				<!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
			</td>
		</tr>
		</tbody>
		</table>
	</div>
	<!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
	<!--[if mso | IE]>
      <table border="0" cellpadding="0" cellspacing="0" width="10000" align="center" style="width:10000px;">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
	<!-- END: CHIPS -->
<?php
						$blocks_mjml .= ob_get_contents();
						ob_end_clean();
					}
					break;
				case "single-two-col":
					$block_photo = getPhoto("block_{$i}");
					$block_title = isset($_POST["block_{$i}_title"]) ? $_POST["block_{$i}_title"] : "";
					$block_subtitle = isset($_POST["block_{$i}_subtitle"]) ? $_POST["block_{$i}_subtitle"] : "";
					$block_text = isset($_POST["block_{$i}_text"]) ? $_POST["block_{$i}_text"] : "";
					$block_text = isset($_POST["block_{$i}_url"]) ? $_POST["block_{$i}_url"] : "";
					$block_cta = isset($_POST["block_{$i}_cta"]) ? $_POST["block_{$i}_cta"] : "";

					if ($block_photo) {
						ob_start(); ?>

<!-- START: PHOTO LEFT -->
	<div style="margin:0 auto;max-width:10000px;background:#FFFFFF;">
		<table cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#FFFFFF;" align="center" border="0">
		<tbody>
		<tr>
			<td style="text-align:center;vertical-align:top;font-size:0px;padding:30px 10px 16px 10px;">
				<!--[if mso | IE]>
      <table border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:300px;">
      <![endif]-->
				<div aria-labelledby="mj-column-px-300" class="mj-column-px-300" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;">
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tbody>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:0px;" align="left">
							<table cellpadding="0" cellspacing="0" style="color:#000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;" width="100%" border="0">
							<tr>
								<td style="padding: 9px; border: 1px solid #008C5C;">
									<?php if ($block_url): ?>
									<a href="<?php echo $block_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=article_image" target="_blank"><img src="<?php echo "http://{$server_name}/{$block_photo}"; ?>" style="display: block; width: 100%; height: auto; margin: 0; padding: 0;" vspace="0" hspace="0" border="0"></a>
									<?php else: ?>
									<img src="<?php echo "http://{$server_name}/{$block_photo}"; ?>" style="display: block; width: 100%; height: auto; margin: 0; padding: 0;" vspace="0" hspace="0" border="0">
									<?php endif; ?>
								</td>
							</tr>
							</table>
						</td>
					</tr>
					</tbody>
					</table>
				</div>
				<!--[if mso | IE]>
      </td><td style="vertical-align:top;width:300px;">
      <![endif]-->
				<div aria-labelledby="mj-column-px-300" class="mj-column-px-300" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;">
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tbody>
					<?php if ($block_title): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:10px 15px 0px;" align="left">
							<div style="cursor:auto;color:#008C5C;font-family:Verdana, sans-serif;font-size:24px;font-weight:bold;line-height:28px;text-transform:uppercase;">
								<?php if ($block_url): ?>
								<a href="<?php echo $block_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=article_title" target="_blank" style="text-decoration: none; color: inherit;"><?php echo $block_title; ?></a>
								<?php else: ?>
								<span style="text-decoration: none; color: inherit;"><?php echo $block_title; ?></span>
								<?php endif; ?>
							</div>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ($block_title && $block_subtitle): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:4px 15px 0px;" align="left">
							<div style="cursor:auto;color:#8CC63F;font-family:Verdana, sans-serif;font-size:14px;font-style:italic;font-weight:bold;line-height:18px;text-transform:uppercase;">
								<?php if ($block_url): ?>
								<a href="<?php echo $block_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=article_subtitle" target="_blank" style="text-decoration: none; color: inherit;"><?php echo $block_subtitle; ?></a>
								<?php else: ?>
								<span style="text-decoration: none; color: inherit;"><?php echo $block_subtitle; ?></span>
								<?php endif; ?>
							</div>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ($block_text): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:10px 15px 0px;" align="left">
							<div style="cursor:auto;color:#000000;font-family:Verdana, sans-serif;font-size:14px;line-height:18px;">
								<?php echo nl2br($block_text); ?>
							</div>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ($block_url && $block_cta): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:15px;" align="left">
							<table cellpadding="0" cellspacing="0" style="border:none;border-radius:0px;" align="left" border="0">
							<tbody>
							<tr>
								<td style="background:#008C5C;border-radius:0px;color:#FFFFFF;cursor:auto;" align="center" valign="middle" bgcolor="#008C5C">
									<a href="<?php echo $block_url; ?>?utm_source=newsletter&amp;utm_medium=email&amp;utm_campaign=article_button" style="display:inline-block;text-decoration:none;background:#008C5C;border:1px solid #008C5C;border-radius:0px;color:#FFFFFF;font-family:Verdana, sans-serif;font-size:13px;font-weight:bold;padding:15px;" target="_blank"><?php echo $block_cta; ?></a>
								</td>
							</tr>
							</tbody>
							</table>
						</td>
					</tr>
					<?php endif; ?>
					</tbody>
					</table>
				</div>
				<!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
			</td>
		</tr>
		</tbody>
		</table>
	</div>
	<!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
	<!--[if mso | IE]>
      <table border="0" cellpadding="0" cellspacing="0" width="10000" align="center" style="width:10000px;">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
	<!-- END: PHOTO LEFT -->

<?php
						$blocks_mjml .= ob_get_contents();
						ob_end_clean();
					}
				case "single-full-width":
				default:
					$block_photo = getPhoto("block_{$i}");
					$block_title = isset($_POST["block_{$i}_title"]) ? $_POST["block_{$i}_title"] : "";
					$block_subtitle = isset($_POST["block_{$i}_subtitle"]) ? $_POST["block_{$i}_subtitle"] : "";
					$block_text = isset($_POST["block_{$i}_text"]) ? $_POST["block_{$i}_text"] : "";
					$block_url = isset($_POST["block_{$i}_url"]) ? $_POST["block_{$i}_url"] : "";
					$block_cta = isset($_POST["block_{$i}_cta"]) ? $_POST["block_{$i}_cta"] : "";

					if ($block_photo || $block_title) {

						ob_start(); ?>
<!-- START: FULL / CENTER -->
	<div style="margin:0 auto;max-width:10000px;background:#FFFFFF;">
		<table cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#FFFFFF;" align="center" border="0">
		<tbody>
		<tr>
			<td style="text-align:center;vertical-align:top;font-size:0px;padding:30px 10px 16px 10px;">
				<!--[if mso | IE]>
      <table border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:10000px;">
      <![endif]-->
				<div aria-labelledby="mj-column-per-100" class="mj-column-per-100" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;">
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tbody>
					<?php if ($block_photo): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:0px;" align="center">
							<table cellpadding="0" cellspacing="0" style="color:#000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;" width="auto" border="0">
							<tr>
								<td style="padding: 9px; border: 1px solid #008C5C;">
									<?php if ($block_url): ?>
									<a href="<?php echo $block_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=article_image" target="_blank"><img src="<?php echo "http://{$server_name}/{$block_photo}"; ?>" style="display: block; width: 100%; height: auto; margin: 0; padding: 0; max-width: 580px;" vspace="0" hspace="0" border="0"></a>
									<?php else: ?>
									<img src="<?php echo "http://{$server_name}/{$block_photo}"; ?>" style="display: block; width: 100%; height: auto; margin: 0; padding: 0; max-width: 580px;" vspace="0" hspace="0" border="0">
									<?php endif; ?>
								</td>
							</tr>
							</table>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ($block_title): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:10px 15px 0px;" align="center">
							<div style="cursor:auto;color:#008C5C;font-family:Verdana, sans-serif;font-size:24px;font-weight:bold;line-height:28px;text-transform:uppercase;">
								<div style="max-width: 580px;">
									<?php if ($block_url): ?>
									<a href="<?php echo $block_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=article_title" target="_blank" style="text-decoration: none; color: inherit;"><?php echo $block_text; ?></a>
									<?php else: ?>
									<span style="text-decoration: none; color: inherit;"><?php echo $block_text; ?></span>
									<?php endif; ?>
								</div>
							</div>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ($block_title && $block_subtitle): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:4px 15px 0px;" align="center">
							<div style="cursor:auto;color:#8CC63F;font-family:Verdana, sans-serif;font-size:14px;font-style:italic;font-weight:bold;line-height:18px;text-transform:uppercase;">
								<div style="max-width: 580px;">
									<?php if ($block_url): ?>
									<a href="<?php echo $block_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=article_subtitle" target="_blank" style="text-decoration: none; color: inherit;"><?php echo $block_subtitle; ?></a>
									<?php else: ?>
									<span style="text-decoration: none; color: inherit;"><?php echo $block_subtitle; ?></span>
									<?php endif; ?>
								</div>
							</div>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ($block_text): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:10px 15px 0px;" align="center">
							<div style="cursor:auto;color:#000000;font-family:Verdana, sans-serif;font-size:14px;line-height:18px;">
								<div style="max-width: 580px;">
									<?php echo nl2br($block_text); ?>
								</div>
							</div>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ($block_url && $block_cta): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:15px;" align="center">
							<table cellpadding="0" cellspacing="0" style="border:none;border-radius:0px;" align="center" border="0">
							<tbody>
							<tr>
								<td style="background:#008C5C;border-radius:0px;color:#FFFFFF;cursor:auto;" align="center" valign="middle" bgcolor="#008C5C">
									<a href="<?php echo $block_url; ?>?utm_source=newsletter&amp;utm_medium=email&amp;utm_campaign=article_button" style="display:inline-block;text-decoration:none;background:#008C5C;border:1px solid #008C5C;border-radius:0px;color:#FFFFFF;font-family:Verdana, sans-serif;font-size:13px;font-weight:bold;padding:15px;" target="_blank"><?php echo $block_cta; ?></a>
								</td>
							</tr>
							</tbody>
							</table>
						</td>
					</tr>
					<?php endif; ?>
					</tbody>
					</table>
				</div>
				<!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
			</td>
		</tr>
		</tbody>
		</table>
	</div>
	<!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
	<!--[if mso | IE]>
      <table border="0" cellpadding="0" cellspacing="0" width="10000" align="center" style="width:10000px;">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
	<!-- END: FULL / CENTER -->

<?php
						$blocks_mjml .= ob_get_contents();
						ob_end_clean();
					}
			}
		}
	}
	header("Content-Type: text/plain");
	ob_start();
?><!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>
<style type="text/css">
	#outlook a { padding: 0; }
	.ReadMsgBody { width: 100%; }
	.ExternalClass { width: 100%; }
	.ExternalClass * { line-height:100%; }
	body { margin: 0; padding: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
	table, td { border-collapse:collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
	img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; }
	p { display: block; margin: 13px 0; }
</style>
<!--[if !mso]><!-->
<style type="text/css">
	@import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
</style>
<style type="text/css">
	@media only screen and (max-width:480px) {
		@-ms-viewport { width:320px; }
		@viewport { width:320px; }
	}
</style>
<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css">
<!--<![endif]-->
<!--[if mso]>
<xml>
  <o:OfficeDocumentSettings>
    <o:AllowPNG/>
    <o:PixelsPerInch>96</o:PixelsPerInch>
  </o:OfficeDocumentSettings>
</xml>
<![endif]-->
<style type="text/css">
	@media only screen and (min-width:480px) {
		.mj-column-per-100, * [aria-labelledby="mj-column-per-100"] { width:100%!important; }
		.mj-column-px-300, * [aria-labelledby="mj-column-px-300"] { width:300px!important; }
		.mj-column-px-295, * [aria-labelledby="mj-column-px-295"] { width:295px!important; }
		.mj-column-px-10, * [aria-labelledby="mj-column-px-10"] { width:10px!important; }
		.mj-column-px-200, * [aria-labelledby="mj-column-px-200"] { width:200px!important; }
	}
</style>
<style type="text/css">
	@media only screen and (max-width:480px) {
		.mj-hero-content {
			width: 100% !important;
		}
	}
</style>
</head>
<body>
<div style="font-size:14px;">
	<!--[if mso | IE]>
      <table border="0" cellpadding="0" cellspacing="0" width="10000" align="center" style="width:10000px;">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
	<!-- START: HEADER -->
	<div style="margin:0 auto;max-width:10000px;background:#008C5C;">
		<table cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#008C5C;" align="center" border="0">
		<tbody>
		<tr>
			<td style="text-align:center;vertical-align:top;font-size:0px;padding:0px;">
				<!--[if mso | IE]>
      <table border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:10000px;">
      <![endif]-->
				<div aria-labelledby="mj-column-per-100" class="mj-column-per-100" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;">
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tbody>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:30px 0px;" align="center">
							<table cellpadding="0" cellspacing="0" style="border-collapse:collapse;border-spacing:0px;" align="center" border="0">
							<tbody>
							<tr>
								<td style="width:280px;">
									<a href="http://www.buylocalglv.org/?utm_source=newsletter&amp;amp;utm_medium=email&amp;amp;utm_campaign=header_logo" target="_blank"><img alt="" height="auto" src="http://www.buylocalglv.org/wp-content/themes/bfblglv-wp/images/bfbl_logo.png" style="border:none;display:block;outline:none;text-decoration:none;width:100%;height:auto;" width="280"></a>
								</td>
							</tr>
							</tbody>
							</table>
						</td>
					</tr>
					</tbody>
					</table>
				</div>
				<!--[if mso | IE]>
      </td><td style="vertical-align:top;width:10000px;">
      <![endif]-->
				<div aria-labelledby="mj-column-per-100" class="mj-column-per-100" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;">
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tbody>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:0px;">
							<p style="font-size:1px;margin:0 auto;border-top:2px solid #8CC63F;width:100%;">
							</p>
							<!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="font-size:1px;margin:0 auto;border-top:2px solid #8CC63F;width:100%;" width="10000"><tr><td style="height:0;line-height:0;">&nbsp;</td></tr></table><![endif]-->
						</td>
					</tr>
					</tbody>
					</table>
				</div>
				<!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
			</td>
		</tr>
		</tbody>
		</table>
	</div>
	<!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
	<!--[if mso | IE]>
      <table border="0" cellpadding="0" cellspacing="0" width="10000" align="center" style="width:10000px;">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
	<!-- END: HEADER -->

<?php echo $blocks_mjml; ?>

	<!-- START: FOOTER -->
	<div style="margin:0 auto;max-width:10000px;background:#015C3C;">
		<table cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#015C3C;" align="center" border="0">
		<tbody>
		<tr>
			<td style="text-align:center;vertical-align:top;font-size:0px;padding:30px 0px 0px;">
				<!--[if mso | IE]>
      <table border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:10000px;">
      <![endif]-->
				<div aria-labelledby="mj-column-per-100" class="mj-column-per-100" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;">
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tbody>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:0px;" align="center">
							<div style="cursor:auto;color:#8CC63F;font-family:Verdana, sans-serif;font-size:12px;font-weight:bold;line-height:16px;text-transform:uppercase;">
								<div style="max-width: 580px;">
									<?php echo $about_title; ?>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:10px 0px 0px;" align="center">
							<div style="cursor:auto;color:#FFFFFF;font-family:Verdana, sans-serif;font-size:12px;line-height:16px;">
								<div style="max-width: 580px;">
									<?php echo nl2br($about_text); ?>
								</div>
							</div>
						</td>
					</tr>
					</tbody>
					</table>
				</div>
				<!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
			</td>
		</tr>
		</tbody>
		</table>
	</div>
	<!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
	<!--[if mso | IE]>
      <table border="0" cellpadding="0" cellspacing="0" width="10000" align="center" style="width:10000px;">
        <tr>
          <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
      <![endif]-->
	<div style="margin:0 auto;max-width:10000px;background:#015C3C;">
		<table cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#015C3C;" align="center" border="0">
		<tbody>
		<tr>
			<td style="text-align:center;vertical-align:top;font-size:0px;padding:0px 0px 16px;">
				<!--[if mso | IE]>
      <table border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:300px;">
      <![endif]-->
				<div aria-labelledby="mj-column-px-300" class="mj-column-px-300" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;">
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tbody>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:0px;padding-top:20px;" align="center">
							<div style="cursor:auto;color:#8CC63F;font-family:Verdana, sans-serif;font-size:12px;font-weight:bold;line-height:16px;text-transform:uppercase;">
								 <?php echo $menu_title; ?>
							</div>
						</td>
					</tr>
					<?php if ($menu_link_1_text && $menu_link_1_url): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:4px 0px 0px;" align="center">
							<div style="cursor:auto;color:#FFFFFF;font-family:Verdana, sans-serif;font-size:12px;font-weight:bold;line-height:16px;">
								<a href="<?php echo $menu_link_1_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=footer_menu" target="_blank" style="color: #FFFFFF; text-decoration: none; font-weight: bold;"><?php echo $menu_link_1_text; ?></a>
							</div>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ($menu_link_2_text && $menu_link_2_url): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:4px 0px 0px;" align="center">
							<div style="cursor:auto;color:#FFFFFF;font-family:Verdana, sans-serif;font-size:12px;font-weight:bold;line-height:16px;">
								<a href="<?php echo $menu_link_2_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=footer_menu" target="_blank" style="color: #FFFFFF; text-decoration: none; font-weight: bold;"><?php echo $menu_link_2_text; ?></a>
							</div>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ($menu_link_3_text && $menu_link_3_url): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:4px 0px 0px;" align="center">
							<div style="cursor:auto;color:#FFFFFF;font-family:Verdana, sans-serif;font-size:12px;font-weight:bold;line-height:16px;">
								<a href="<?php echo $menu_link_3_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=footer_menu" target="_blank" style="color: #FFFFFF; text-decoration: none; font-weight: bold;"><?php echo $menu_link_3_text; ?></a>
							</div>
						</td>
					</tr>
					<?php endif; ?>
					<?php if ($menu_link_4_text && $menu_link_4_url): ?>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:4px 0px 0px;" align="center">
							<div style="cursor:auto;color:#FFFFFF;font-family:Verdana, sans-serif;font-size:12px;font-weight:bold;line-height:16px;">
								<a href="<?php echo $menu_link_4_url; ?>?utm_source=newsletter&utm_medium=email&utm_campaign=footer_menu" target="_blank" style="color: #FFFFFF; text-decoration: none; font-weight: bold;"><?php echo $menu_link_4_text; ?></a>
							</div>
						</td>
					</tr>
					<?php endif; ?>
					</tbody>
					</table>
				</div>
				<!--[if mso | IE]>
      </td><td style="vertical-align:top;width:300px;">
      <![endif]-->
				<div aria-labelledby="mj-column-px-300" class="mj-column-px-300" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;">
					<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tbody>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:0px;padding-top:20px;" align="center">
							<div style="cursor:auto;color:#8CC63F;font-family:Verdana, sans-serif;font-size:12px;font-weight:bold;line-height:16px;text-transform:uppercase;">
								Connect
							</div>
						</td>
					</tr>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:4px 0px 0px;" align="center">
							<div style="cursor:auto;color:#FFFFFF;font-family:Verdana, sans-serif;font-size:12px;font-weight:bold;line-height:16px;">
								<a href="https://twitter.com/BFBLGLV" target="_blank" style="color: #FFFFFF; text-decoration: none; font-weight: bold;">Twitter</a>
							</div>
						</td>
					</tr>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:4px 0px 0px;" align="center">
							<div style="cursor:auto;color:#FFFFFF;font-family:Verdana, sans-serif;font-size:12px;font-weight:bold;line-height:16px;">
								<a href="https://www.facebook.com/BuyFreshBuyLocalGreaterLehighValley" target="_blank" style="color: #FFFFFF; text-decoration: none; font-weight: bold;">Facebook</a>
							</div>
						</td>
					</tr>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:4px 0px 0px;" align="center">
							<div style="cursor:auto;color:#FFFFFF;font-family:Verdana, sans-serif;font-size:12px;font-weight:bold;line-height:16px;">
								<a href="https://www.youtube.com/user/BFBLGLV" target="_blank" style="color: #FFFFFF; text-decoration: none; font-weight: bold;">YouTube</a>
							</div>
						</td>
					</tr>
					<tr>
						<td style="word-break:break-word;font-size:0px;padding:4px 0px 0px;" align="center">
							<div style="cursor:auto;color:#FFFFFF;font-family:Verdana, sans-serif;font-size:12px;font-weight:bold;line-height:16px;">
								<a href="https://www.instagram.com/BFBLGLV" target="_blank" style="color: #FFFFFF; text-decoration: none; font-weight: bold;">Instagram</a>
							</div>
						</td>
					</tr>
					</tbody>
					</table>
				</div>
				<!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
			</td>
		</tr>
		</tbody>
		</table>
	</div>
	<!-- END: FOOTER -->
	<!--[if mso | IE]>
      </td></tr></table>
      <![endif]-->
</div>
</body>
</html>
<?php

$htmlStr = ob_get_contents();
ob_end_clean();
$htmlStr = trim($htmlStr);
file_put_contents("html-out.html", $htmlStr);

header("Location: display.php");