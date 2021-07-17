<?php
	use Core\Router;
	use Core\H;
	use App\Models\Users;
	$menu = Router::getMenu('menu_acl');
	$currentPage = H::currentPage(); //for active only
	//testing the preg_match
	//$test = preg_match('/^(\/[^\/]+)(\/[^\/]+)(\/[^\/]+)\/?|.+/',$currentPage, $con);
	//echo "<pre>", print_r($con,1), "</pre>";
	//echo $currentPage = preg_replace('/^(\/[^\/]+)(\/[^\/]+)(\/[^\/]+)\/?|.+/','${1}${2}${3}',$currentPage);
?>

<link rel="stylesheet" href="<?=PROOT?>vendors/css/sidebar.css" media="screen" title="no title" charset="utf-8">

<div class="sidebar-content-wrapper sidebar-content-wrapper-normal">
	<div class="sidebar-content">
		<div class="sidebar-minimize text-center">
			<i class="sidebar-minimize-icon fal fa-angle-double-left"></i>
		</div>
		<div class="sidebar-logo">
			<img src="<?=PROOT?>vendors/image/logo-word.png" class="sidebar-logo-img-1 main-word"/>
			<img src="<?=PROOT?>vendors/image/logo-black.png" class="sidebar-logo-img-2 main-logo"/>
		</div>
		<hr>

		<div class="sidebar-menu scrollbar-custom">
			<p class="sidebar-ui-menu font-weight-bold">ADM-3 Menu</p>
			<ul class="sidebar-ul">
				<?php foreach ($menu as $key => $val): ?>
					<?php if($key != 'Logout'):
						$currentPageUse = (is_array($val)) ? trim(preg_replace('/^(\/[^\/]+)(\/[^\/]+)(\/[^\/]+)\/?|.+/','${1}${2}${3}',$currentPage)) : $currentPage;
						$active = ($val == parse_url($currentPageUse, PHP_URL_PATH))? 'active-class':''; 
						$activeVal = ($val == parse_url($currentPageUse, PHP_URL_PATH))? 'active-class-val':'';
					?>
						
						<?php if(is_array($val)): ?>
							<a href="#" class="li-a-nav">
								<li class="li-nav dropdown-li" id="<?= $key ?>-sub-ul" title="<?= $key ?>">
									<div class="li-nav-div li-nav-and-sub-normal">
										<span class="li-nav-div-span">
											<i class="fas a1 sidebar-menu-icon" id="nav-icon"></i>
											<span class="sidebar-menu-value sidebar-menu-value-normal"><?= $key ?></span>
										</span> 
										<div>
											<i class="fal fa-angle-down li-nav-dd"></i>
											<i class="fal fa-angle-down li-nav-dd-mini"></i>
										</div>
									</div>
									
									<ul class="sub-ul-nav <?= $key ?>-sub-ul"  id="sub-ul-<?= $key ?>-sub-ul">
										<?php foreach($val as $k => $v): 
											if($v == $currentPage) echo "<script type='text/javascript'>document.getElementById('sub-ul-".$key."-sub-ul').classList.add('show-div')</script>";
											$active = ($v == $currentPage)? 'active-class':''; 
											$activeVal = ($v == $currentPage)? 'active-class-val':''; 
										?>
											<a href="<?= $v ?>" class="sub-li-a-nav">
												<li class="sub-li-nav" title="<?= ucfirst($k) ?>">
													<div class="sub-li-nav-div <?= $active ?> li-nav-and-sub-normal">
														<span class="sub-li-nav-div-span">
															<i class="fas fa-hand-point-right <?= $activeVal ?> sub-li-nav-div-span-icon"></i> 
															<span class="sidebar-menu-value sidebar-menu-value-normal sidebar-menu-value-with-style <?= $activeVal ?>"><?= ucfirst($k) ?></span>
														</span>
													</div>
												</li>
											</a>
										<?php endforeach; ?>
									</ul>
								</li>
							</a>	
						<?php else:?>
							<a href="<?= $val ?>" class="li-a-nav">
								<li class="li-nav" title="<?= $key ?>">
									<div class="li-nav-div <?= $active ?> li-nav-and-sub-normal">
										<span class="li-nav-div-span">
											<i class="fas a2 sidebar-menu-icon <?= $activeVal ?>" id="nav-icon"></i> 
											<span class="sidebar-menu-value sidebar-menu-value-normal <?= $activeVal ?>"><?= $key ?></span>
										</span>
									</div>
								</li>
							</a>
							
						<?php endif; ?>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>

	<div class="sidebar-footer sidebar-footer-normal">
		<div class="sidebar-footer-online-dot"></div>
		<div class="sidebar-footer-img"></div>
		<p class="sidebar-footer-welcome">#<?= (Users::currentUser()->acl == '')? 'WELCOME' : ucfirst(Users::currentUser()->acl) ?></p>
		<p class="sidebar-footer-name"><?= ucfirst(Users::currentUser()->fname) ?></p>
		<?php foreach ($menu as $key => $val): ?>
			<?php if($key == 'Logout'): ?>
				<a href="<?= $val ?>"><i class="fas fa-sign-out-alt sidebar-footer-logout-icon" alt="Logout" title="Logout"></i></a>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<div class="div-img-logout-settings" style="" id="div-img-logout-settings-id">
		<div class="dils-div-1"></div>
		<div class="dils-div-2">
			<ul class="dils-ul">
				<!-- <li class="div-img-logout-settings-li">Option</li>
				<li class="div-img-logout-settings-li">Option</li>
				<li class="div-img-logout-settings-li">Option</li>
				<li class="div-img-logout-settings-li">Option</li>
				<li class="div-img-logout-settings-li">Option</li> -->
				<li class="div-img-logout-settings-li li-darknormal-switch">
					<span class="float-left span-switch-name">Dark Mode</span>
					<span class="float-right span-switchbox">					
						<label class="switch-btn">
							<input type="checkbox" class="switch-checkbox">
							<span class="switch-slider round"></span>
						</label>
					</span>
				</li>
				<?php foreach ($menu as $key => $val): ?>
					<?php if($key == 'Logout'): ?>
						<li class="div-img-logout-settings-li logout-function-on-li" data-urlni="<?= $val ?>">
							<span class="float-left">Logout</span>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
