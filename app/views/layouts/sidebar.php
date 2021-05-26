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
<style>
	.switch-btn {
		top: 3px;
  position: relative;
  display: inline-block;
  width: 30px;
  height: 14px;
}

.switch-btn input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.switch-slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.switch-slider:before {
  position: absolute;
  content: "";
  height: 10px;
  width: 11px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .switch-slider {
  background-color: #2196F3;
}

input:focus + .switch-slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .switch-slider:before {
  -webkit-transform: translateX(15px);
  -ms-transform: translateX(15px);
  transform: translateX(15px);
}

/* Rounded switch-sliders */
.switch-slider.round {
  border-radius: 34px;
}

.switch-slider.round:before {
  border-radius: 50%;
}
.div-img-logout-settings-li {
	margin-bottom: 5px;
	cursor: pointer;
	padding:5px;
	font-size: 13px;
	height: 30px;
	border-radius: 5px;
}
.div-img-logout-settings-li:hover {
	background-color: #e1e1e2;
}
</style>


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
											<i class="fal fa-angle-down li-nav-dd" style="position: relative;left: 205px;top: -8px;"></i>
											<i class="fal fa-angle-down li-nav-dd-mini" style="display: none;font-size: 14px;position: relative;top: -34px; left: 25px;background-color: #0062cc;border-radius: 12px; width: 12px;height: 12px;color: #fff;"></i>
										</div>
									</div>
									
									<ul class="sub-ul-nav <?= $key ?>-sub-ul" >
										<?php foreach($val as $k => $v): 
											echo ($v == parse_url($currentPageUse, PHP_URL_PATH))? "<script type='text/javascript'>$('.$key-sub-ul').addClass('show-div');</script>" : '' ;
											$active = ($v == parse_url($currentPageUse, PHP_URL_PATH))? 'active-class':''; 
											$activeVal = ($v == parse_url($currentPageUse, PHP_URL_PATH))? 'active-class-val':''; 
										?>
											<a href="<?= $v ?>" class="sub-li-a-nav">
												<li class="sub-li-nav" title="<?= ucfirst($k) ?>">
													<div class="sub-li-nav-div <?= $active ?> li-nav-and-sub-normal">
														<span class="sub-li-nav-div-span">
															<i class="fas fa-hand-point-right <?= $activeVal ?> sub-li-nav-div-span-icon"></i> 
															<span class="sidebar-menu-value sidebar-menu-value-normal <?= $activeVal ?>" style="font-size: 12px;left:60px;"><?= ucfirst($k) ?></span>
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
		<div class="dils-div-1" style="width: 20%;height: 100%;position: absolute;"></div>
		<div class="dils-div-2" style="width: 80%;height: 100%;position: absolute;left: 20%;padding-right: 10px;">
			<ul style="list-style-type: none;margin:0;padding: 25px 0 0 0;color: #000;">
				<!-- <li class="div-img-logout-settings-li">Option</li>
				<li class="div-img-logout-settings-li">Option</li>
				<li class="div-img-logout-settings-li">Option</li>
				<li class="div-img-logout-settings-li">Option</li>
				<li class="div-img-logout-settings-li">Option</li> -->
				<li class="div-img-logout-settings-li li-darknormal-switch">
					<span class="float-left span-switch-name">Dark Mode</span>
					<span class="float-right" style="position: relative;z-index: 10;">					
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
