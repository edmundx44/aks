<?php
  use Core\Router;
  use Core\H;
  use App\Models\Users;
  $menu = Router::getMenu('menu_acl');
  // $currentPage = H::currentPage(); //for active only
?>
<div class="side-nav">
	<div class="div-logo col-md-12 no-padding"></div>
	<div class="div-profile col-md-12 no-padding">
		<div class="dp-picture">
			<img src="<?=PROOT?>/image/avatar.png" />
		</div>
		<p class="dp-user">
			<?php if(Users::currentUser()): ?>
				<?= ucfirst(Users::currentUser()->fname) ?>
			<?php endif; ?>
        </p>
		<div class="dp-wdid text-center">
			<i class="i-style fa fa-cart-plus" aria-hidden="true" alt="Added Today" title="Added Today"></i>
			<i class="i-style fa fa-pencil-square" aria-hidden="true" alt="Edited Today" title="Edited Today"></i>
			<i class="i-style fa fa-trash" aria-hidden="true" alt="Deleted Today" title="Deleted Today"></i>	
		</div>
	</div>
	<div class="side-nav-ul col-md-12 no-padding">
		<ul class="ul-nav">
			<?php foreach ($menu as $key => $val): ?>
				<?php if($key != 'Logout'): ?>
					<?php if(is_array($val)): ?>
						<a href="#" class="li-a-nav">
							<li class="li-nav dropdown-li">
								<div class="li-nav-div">
									<span class="li-nav-div-span"><i class="fa a1" aria-hidden="true" id="nav-icon"></i> &nbsp; <?= $key ?></span>
								</div>
								<ul class="sub-ul-nav">
									<?php foreach($val as $k => $v): ?>
										<a href="<?= $v ?>" class="sub-li-a-nav">
											<li class="sub-li-nav">
												<div class="sub-li-nav-div">
													<span class="sub-li-nav-div-span"><i class="fa fa-paper-plane" aria-hidden="true"></i> &nbsp; <?= $k ?></span>
												</div>
											</li>
										</a>
									<?php endforeach; ?>
								</ul>
							</li>
						</a>
					<?php else: ?>
						<a href="<?= $val ?>" class="li-a-nav">
							<li class="li-nav">
								<div class="li-nav-div">
									<span class="li-nav-div-span"><i class="fa a2" aria-hidden="true" id="nav-icon"></i> &nbsp; <?= $key ?></span>
								</div>
							</li>
						</a>
					<?php endif; ?>
				<?php endif; ?> 
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="div-logout">
		<?php
			foreach ($menu as $key => $val) {
				if($key == 'Logout') {
					?><a href="<?=$val?>" class="lsn-a"><i class="fa fa-sign-out" aria-hidden="true"></i><span class="lsn-span"><?=$key?></span></a><?php
				}
			}
		?>	
	</div>
</div>