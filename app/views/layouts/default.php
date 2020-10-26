<?php

use Core\Session;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?=$this->siteTitle(); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=PROOT?>css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="<?=PROOT?>css/bootstrap.min.css.map" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="<?=PROOT?>css/custom.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="<?=PROOT?>css/media.css" media="screen" title="no title" charset="utf-8">

    <?= $this->content('head'); ?>

  </head>
  <body>
    
    <?php if(preg_match('/user\/login/m', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") == 1 or preg_match('/user\/register/m', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]")): ?>
      <?= Session::displayMsg() ?>
      <?= $this->content('body'); ?>
    <?php else: ?>
      <div class="container-fluid no-padding container-fluid-wrap">
        <div class="side-bar">
          <?php include 'side-bar.php'; ?>
        </div>
        <div class="content-div" id="content-div">
          <?php include 'header.php'; ?>
          <?= $this->content('body'); ?>
          <?php include 'footer.php'; ?>
        </div>
        <?php include 'modal.php'; ?>
      </div>
    <?php endif; ?>

    

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="<?=PROOT?>js/jQuery-2.2.4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="<?=PROOT?>js/bootstrap.min.js"></script>
    <script src="<?=PROOT?>js/custom.js"></script>

  </body>
</html>
