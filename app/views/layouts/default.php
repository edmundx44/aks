<?php
use Core\Session;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
	
		<title><?=$this->siteTitle(); ?></title>
		<?php include 'stylesheets.php'; ?>
		<?= $this->content('head'); ?>

	</head>
	<body>
		<?php if(preg_match('/user\/login/m', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") == 1 or preg_match('/user\/register/m', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]")): ?>
			<?= Session::displayMsg() ?>
			<?= $this->content('body'); ?>
		<?php else: ?>
			<div class="wrapper" id="wrapper">
				<?php include 'page-loader.php'; ?>

				<!-- <div class="bg-div"></div> -->
				<div class="sidebar">
					<?php include 'sidebar.php'; ?>
				</div>

				<div class="hcf-back hcf-back-normal"></div>
				<div class="header-content-footer">
					<?php include 'scripts.php'; ?>
					<?= $this->content('body-script'); ?>
					<?php include 'header.php'; ?>
					<?= $this->content('body'); ?>
					<?php include 'footer.php'; ?>
				</div>

				<?php include 'floating-menu.php'; ?>
				<?php include 'modal.php'; ?>
			</div>
		<?php endif; ?>
	</body>
</html>
