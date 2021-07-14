<?php
	use Core\Router;
	use Core\H;
	use App\Models\Users;
	$menu = Router::getMenu('menu_acl');
	$currentPage = H::currentPage(); //for active only
	$currentPageUse = (is_array($val)) ? trim(preg_replace('/^(\/[^\/]+)(\/[^\/]+)(\/[^\/]+)\/?|.+/','${1}${2}${3}',$currentPage)) : $currentPage;
?>

<link rel="stylesheet" href="<?=PROOT?>vendors/css/header.css" media="screen" title="no title" charset="utf-8">

<div class="header-content">
	<nav class="navbar navbar-expand-md navbar-light navbar-style">
		<a href="#" class="navbar-brand">
			<?php foreach ($menu as $key => $val): 
				$title = ($val == parse_url($currentPage, PHP_URL_PATH))? $key:''; ?>
				<?php if(is_array($val)): ?>
				<?php $currentPageUse = (is_array($val)) ? trim(preg_replace('/^(\/[^\/]+)(\/[^\/]+)(\/[^\/]+)\/?|.+/','${1}${2}${3}',$currentPage)) : $currentPage; ?>
					<?php foreach($val as $k => $v): 
						$titles = ($v == parse_url($currentPageUse, PHP_URL_PATH))? $k:''; ?>
						<span class="header-title"><?= $titles ?></span>
					<?php endforeach; ?>
				<?php else:?>
					<span class="header-title header-title-normal"><?= $title ?></span>
				<?php endif; ?>
			<?php endforeach; ?>

			<?php 
				switch ($_SERVER['REQUEST_URI']) {
					case '/aks/dashboard/activities':
						?><span class="header-title header-title-normal">ACTIVITIES</span><?php
					break;
					case '/aks/dashboard/notification':
						?><span class="header-title header-title-normal">Notification</span><?php
					break;
					case '/aks/dashboard/employeeTable':
						?><span class="header-title header-title-normal">Employee's Table</span><?php
					break;
				}
			?>
		</a>

		<button type="button" class="navbar-toggler sidebar-menu-btn" data-toggle="collapse">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
			<div class="navbar-nav">
				<!-- <a href="#" class="nav-item nav-link active">Home</a>
				<a href="#" class="nav-item nav-link">Profile</a>
				<div class="nav-item dropdown">
					<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Messages</a>
					<div class="dropdown-menu">
						<a href="#" class="dropdown-item">Inbox</a>
						<a href="#" class="dropdown-item">Sent</a>
						<a href="#" class="dropdown-item">Drafts</a>
					</div>
				</div> -->
			</div>
			<form class="form-inline search-btn-form">
					<!-- <div class="user-input-wrp" style="width: calc(100% - 88px);overflow: hidden;top: -10px;">
						<br>
						<input type="text" value="" class="inputText" id="" onkeyup="this.setAttribute('value', this.value);" style="background-color: transparent;color: #6b6d70;border-radius: 0 0 5px 0;">
						<span class="floating-label">Search</span>
					</div> -->
					<ul class="header-ul">
						<li class="btn btn-primary header-search-btn" title="Search product">
							<i class="fas fa-search"></i>
						</li>
						<a href="<?= PROOT ?>dashboard/activities" class="header-ul-a">
							<li title="Activities" class="header-ul-li">
								<i class="fas fa-clipboard-list" title="Activities"></i>
							</li>
						</a>
						<a href="<?= PROOT ?>dashboard/notification" class="header-ul-a">
							<li title="Notification" class="header-ul-li">
								<i class="fas fa-bell" title="Notification"></i>
							</li>
						</a>
					</ul>
				
			</form>
		</div>
	</nav>
</div>

