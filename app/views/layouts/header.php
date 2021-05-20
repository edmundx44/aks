<?php
  use Core\Router;
  use Core\H;
  use App\Models\Users;
  $menu = Router::getMenu('menu_acl');
  $currentPage = H::currentPage(); //for active only
  $currentPageUse = (is_array($val)) ? trim(preg_replace('/^(\/[^\/]+)(\/[^\/]+)(\/[^\/]+)\/?|.+/','${1}${2}${3}',$currentPage)) : $currentPage;
?>
<style type="text/css">
	.header-content {
		height: 88px;
		width: 100%;
		padding-right: 15px;
		padding-left: 15px;
		-webkit-transition: .3s ease-in-out;
		-moz-transition: .3s ease-in-out;
		-o-transition: .3s ease-in-out;
		transition: .3s ease-in-out;
	}
	.navbar-style {
		padding-top: 20px;
		padding-bottom: 20px;
		border-radius: 0 0 5px 5px;

	}
	.navbar-brand {
		color: #000;
		letter-spacing: 2px;
		text-transform: uppercase;
	}
	.header-content-stickey {
		position: fixed;
		background: rgba(255, 255, 255, 1);
		box-shadow: 0 1px 4px 0 rgb(0 0 0 / 14%);
		width: calc(100% - 290px);
		z-index: 6;
		border-radius: 0 0 5px  5px;
	}
	.minimized-sb-sticky-header {
		width: calc(100% - 130px) !important;
	}
	.sidebar-menu-btn {
		z-index: 9;
		color: #fff;
		background-color: #fff;
		outline: none;
	}
</style>
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
			<!-- <form class="form-inline search-btn-form">
				<div class="input-group search-btn-div">
					<input type="text" class="form-control" placeholder="Search">
					<div class="input-group-append">
						<button type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
					</div>
				</div>
			</form> -->
		</div>
	</nav>
</div>

