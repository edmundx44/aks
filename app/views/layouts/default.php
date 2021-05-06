<?php
use Core\Session;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    
    <title><?=$this->siteTitle(); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=PROOT?>vendors/css/custom.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="<?=PROOT?>vendors/css/media.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <script src="<?=PROOT?>vendors/js/jQuery-2.2.4.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    <script> var url = '<?= PROOT ?>'; </script>

    <?= $this->content('head'); ?>
  </head>
  <body>
    <?php if(preg_match('/user\/login/m', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") == 1 or preg_match('/user\/register/m', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]")): ?>
      <?= Session::displayMsg() ?>
      <?= $this->content('body'); ?>
    <?php else: ?>
      <div class="wrapper" id="wrapper">

        <!-- <div class="bg-div"></div> -->
        <div class="sidebar">
          <?php include 'sidebar.php'; ?>
        </div>
        <div class="hcf-back hcf-back-normal"></div>
        <div class="header-content-footer">
          <?php include 'header.php'; ?>
          <?= $this->content('body'); ?>
          <?php include 'footer.php'; ?>
        </div>

        <div class="float-anywhere" id="float-anywhere">
          <i class="fa fa-cog settings-icon" aria-hidden="true" style=""></i>

          <div class="float-settings-menu">
            <i class="fa fa-history float-settings-icon" aria-hidden="true" data-toggle="tooltip" title="Activity logs"></i>
          </div>
          <div class="float-settings-menu" id="btn-create-report">
            <i class="fa fa-user-circle float-settings-icon" aria-hidden="true" data-toggle="tooltip" title="Add tooltip title"></i>
          </div>
          <div class="float-settings-menu" id="btn-add-edit">
            <i class="fa fa-plus-circle float-settings-icon" aria-hidden="true" data-toggle="tooltip" title="Add OR Edit Games" ></i>
          </div>
          <div class="float-settings-menu">
            <i class="fa fa-envelope float-settings-icon" aria-hidden="true" data-toggle="tooltip" title="Add tooltip title"></i>
          </div>
          <div class="float-settings-menu">
            <i class="fa fa-home float-settings-icon" aria-hidden="true" data-toggle="tooltip" title="Add tooltip title"></i>
          </div>
          <div class="float-settings-menu">
            <i class="fa fa-bell float-settings-icon" aria-hidden="true" data-toggle="tooltip" title="Add tooltip title"></i>
          </div>
          <div class="float-settings-menu">
            <i class="fa fa-eercast float-settings-icon" aria-hidden="true" data-toggle="tooltip" title="Add tooltip title"></i>
          </div>
          <div class="float-settings-menu">
            <i class="fa fa-bullseye float-settings-icon" aria-hidden="true" data-toggle="tooltip" title="Add tooltip title"></i>
          </div>
          <div class="float-settings-menu" style="top:6px;background-color: #eee;width: 35px;height: 35px;"></div> <!-- *background -->
        </div>

        <?php include 'modal.php'; ?>
      </div>
    <?php endif; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="<?=PROOT?>vendors/js/custom.js"></script>

  </body>
</html>
