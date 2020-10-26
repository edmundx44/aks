<?php
  use Core\Router;
  use Core\H;
  use App\Models\Users;
  $menu = Router::getMenu('menu_acl');
  // $currentPage = H::currentPage(); //for active only
?>
<div class="col-sm-12 side-bar-logo no-padding">
  <div class="sbl-pic">
    <img src="<?=PROOT?>/image/aks-logo.png"/>
  </div>
  <p class="sbl-title">ALLKEYSHOP</p>

</div>
<div class="col-sm-12 side-bar-profile no-padding">
  <div class="col-sm-4 no-padding">
    <div class="sbp-div">
      <img src="<?=PROOT?>/image/avatar.png"/>
    </div>
  </div>
  <div class="col-sm-8">
    <p class="sbp-user">
      <?php if(Users::currentUser()): ?>
				<?= ucfirst(Users::currentUser()->fname) ?>
			<?php endif; ?>
    </p>
    <p class="sbp-user-position">Employee</p>
  </div>
</div>
<div class="col-sm-12 no-padding">
  <ul class="ul-nav">
    <p class="ul-p">UI Menu</p>
    <?php foreach ($menu as $key => $val): ?>
      <?php if($key != 'Logout'): ?>
        <?php if(is_array($val)): ?>
          <a href="#" class="li-a-nav">
            <li class="li-nav dropdown-li">
              <div class="li-nav-div">
                <span class="li-nav-div-span"><i class="fa a1" aria-hidden="true" id="nav-icon"></i> &nbsp; <?= $key ?></span>
                <i class="fa fa-angle-down li-nav-dd" aria-hidden="true"></i>
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
              <?php if($key == 'Dashboard'): ?>
                <div class="li-nav-div active-class">
                  <span class="li-nav-div-span"><i class="fa a2" aria-hidden="true" id="nav-icon"></i> &nbsp; <?= $key ?></span>
                </div>
              <?php else: ?>
                <div class="li-nav-div">
                  <span class="li-nav-div-span"><i class="fa a2" aria-hidden="true" id="nav-icon"></i> &nbsp; <?= $key ?></span>
                </div>
              <?php endif; ?>
            </li>
          </a>
        <?php endif; ?>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
</div>

<!-- <div  class="text-center">
  <i class="fa fa-arrow-circle-o-left push-div" aria-hidden="true" style="font-size: 30px;cursor: pointer;margin-top: 20px;margin-left: -20px;"></i>
</div> -->
