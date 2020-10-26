<?php
  use Core\Router;
  use Core\H;
  use App\Models\Users;
  $menu = Router::getMenu('menu_acl');
  // $currentPage = H::currentPage(); //for active only
?>

<div class="dashboard-header">
	<p class="dh-title pull-left">Dashboard</p>
	<ul class="dh-ul list-inline pull-right" >
		<li><i class="fa fa-search hidden-xs" aria-hidden="true"></i></li>
		<li><i class="fa fa-bell-o hidden-xs" aria-hidden="true"></i></li>
		<li><i class="fa fa-envelope-o hidden-xs" aria-hidden="true"></i></li>
		<li><i class="fa fa-cog hidden-xs show-extra-div" aria-hidden="true" style="cursor: pointer;"></i></li>
		<li><i class="fa fa-bars visible-xs show-side-bar" aria-hidden="true"></i></li>
	</ul>
</div>

<div class="extra-div hidden-xs">
	<ul>
		<li><i class="fa fa-user" aria-hidden="true"></i><span>Option</span></li>
		<li><i class="fa fa-user-circle-o" aria-hidden="true"></i><span>Option</span></li>
		<li><i class="fa fa-arrows" aria-hidden="true"></i><span>Option</span></li>
	</ul>
	<hr>
	<?php foreach ($menu as $key => $val): ?>
		<?php if($key == 'Logout'): ?>
			<a href="<?=$val?>"><i class="fa fa-sign-out" aria-hidden="true"></i><span><?=$key?></span></a>
		<?php endif; ?>
	<?php endforeach; ?>
</div>