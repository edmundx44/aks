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
		<ul>
			<?php
				foreach ($menu as $key => $val) {
					if($key != 'Logout') {
						?><a href="<?= $val ?>"><li><i class="fa fa-bar-chart sn-i" aria-hidden="true"></i><span><?=$key?></span></li></a><?php
					}
				}
			?>

			<!-- <li><i class="fa fa-bar-chart" aria-hidden="true"></i><span>Dashboard</span></li>
			<li><i class="fa fa-car" aria-hidden="true"></i><span>Sample</span></li> -->
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