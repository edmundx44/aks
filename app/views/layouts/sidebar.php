<?php
	use Core\Router;
	use Core\H;
	use App\Models\Users;
	$menu = Router::getMenu('menu_acl');
	$currentPage = H::currentPage(); //for active only
?>

<div class="sidebar-content-wrapper">
	<div class="sidebar-content">
		<div class="sidebar-minimize text-center">
			<i class="sidebar-minimize-icon fa fa-angle-double-left" aria-hidden="true"></i>
		</div>
		<div class="sidebar-logo">
			<img src="<?=PROOT?>vendors/image/logo-word.png" class="sidebar-logo-img-1"/>
			<img src="<?=PROOT?>vendors/image/logo-black.png" class="sidebar-logo-img-2"/>
		</div>
		<hr>

		<div class="sidebar-menu scrollbar-custom scrollbar-custom scrollbar-custom-ds">
			<p class="sidebar-ui-menu font-weight-bold">UI Menu</p>
			<ul class="sidebar-ul">
				
					
				<?php foreach ($menu as $key => $val): ?>
					<?php if($key != 'Logout'): 
						$active = ($val == $currentPage)? 'active-class':''; 
						$activeVal = ($val == $currentPage)? 'active-class-val':'';
					?>
						
						<?php if(is_array($val)): ?>
							<a href="#" class="li-a-nav">
								<li class="li-nav dropdown-li" id="<?= $key ?>-sub-ul">
									<div class="li-nav-div" >
										<span class="li-nav-div-span">
											<i class="fa a1 sidebar-menu-icon" aria-hidden="true" id="nav-icon"></i>
											<span class="sidebar-menu-value"><?= $key ?></span></span> 
										<i class="fa fa-angle-down li-nav-dd pull-right" aria-hidden="true"></i>
									</div>
									
									<ul class="sub-ul-nav <?= $key ?>-sub-ul">
										<?php foreach($val as $k => $v): 
											echo ($v == $currentPage)? "<script type='text/javascript'>$('.sub-ul-nav').addClass('show-div');</script>" : '' ;
											$active = ($v == $currentPage)? 'active-class':''; 
											$activeVal = ($v == $currentPage)? 'active-class-val':''; 
										?>
											<a href="<?= $v ?>" class="sub-li-a-nav">
												<li class="sub-li-nav ">
													<div class="sub-li-nav-div <?= $active ?>">
														<span class="sub-li-nav-div-span">
															<i class="fa fa-hand-o-right <?= $activeVal ?> sub-li-nav-div-span-icon" aria-hidden="true"></i> 
															<span class="sidebar-menu-value <?= $activeVal ?>" style="font-size: 12px;left:60px;"><?= ucfirst($k) ?></span>
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
								<li class="li-nav">
									<div class="li-nav-div <?= $active ?>">
										<span class="li-nav-div-span">
											<i class="fa a2 sidebar-menu-icon <?= $activeVal ?>" aria-hidden="true" id="nav-icon"></i> 
											<span class="sidebar-menu-value <?= $activeVal ?>"><?= $key ?></span>
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

	<div class="sidebar-footer">
		<div class="sidebar-footer-online-dot"></div>
		<div class="sidebar-footer-img"></div>
		<p class="sidebar-footer-welcome">#WELCOME</p>
		<p class="sidebar-footer-name">Herpaul</p>
		<i class="fa fa-sign-out sidebar-footer-logout-icon" aria-hidden="true" alt="Logout" title="Logout"></i>
	</div>
	<div class="div-img-logout-settings" style="" id="div-img-logout-settings-id">
		
	</div>
</div>
