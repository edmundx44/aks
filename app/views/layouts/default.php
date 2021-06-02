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
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="<?=PROOT?>vendors/css/custom.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="<?=PROOT?>vendors/css/media.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style type="text/css">
      #toast-container > .toast {
        width: 450px; 
        text-transform: uppercase;
        letter-spacing: 1px;
      }
    </style>


    <script src="<?=PROOT?>vendors/js/jQuery-2.2.4.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
          <i class="fas fa-cog settings-icon" style=""></i>

          <div class="float-settings-menu">
            <a href="/aks/dashboard/activities" style="color: #fff;text-decoration: none;"><i class="fas fa-history float-settings-icon" data-toggle="tooltip" title="Activity logs"></i></a>
          </div>
          <div class="float-settings-menu" id="btn-create-report">
            <i class="fas fa-user-circle float-settings-icon" data-toggle="tooltip" title="Add tooltip title"></i>
          </div>
          <div class="float-settings-menu" id="btn-add-edit">
            <i class="fas fa-plus-circle float-settings-icon" data-toggle="tooltip" title="Add OR Edit Games" ></i>
          </div>
          <div class="float-settings-menu">
            <i class="fas fa-envelope-open-text float-settings-icon" data-toggle="tooltip" title="Add tooltip title"></i>
          </div>
          <div class="float-settings-menu">
            <i class="fas fa-home float-settings-icon" data-toggle="tooltip" title="Add tooltip title"></i>
          </div>
          <div class="float-settings-menu">
            <i class="fas fa-bell float-settings-icon" data-toggle="tooltip" title="Add tooltip title"></i>
          </div>
          <div class="float-settings-menu">
            <i class="fas fa-podcast float-settings-icon" data-toggle="tooltip" title="Add tooltip title"></i>
          </div>
          <div class="float-settings-menu">
            <i class="fas fa-bullseye float-settings-icon" data-toggle="tooltip" title="Add tooltip title"></i>
          </div>
          <div class="float-settings-menu" style="top:6px;background-color: #eee;width: 35px;height: 35px;"></div> 
        </div> 

        <?php include 'modal.php'; ?>
      </div>
    <?php endif; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="<?=PROOT?>vendors/js/custom.js"></script>
   <!--  <script type="text/javascript">
      toastr.options = {
        "closeButton": true,
        "newestOnTop": false,
        // "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }

      const delay = (ms) => {
        return new Promise((resolve) => {
          setTimeout(() => resolve(), ms);
        }, ms);
      };

      $(function() {

        logsNotification()

        function logsNotification(){
          var idToUpdate = '';
          var dataRequest =  {
            action: 'display-notification'
          }
          
          AjaxCall(url, dataRequest).done(function(data) {
            if(data != false){
              // console.log(data)
              let task = delay(2000);

              var counter = 0
                data.forEach((element,i) => {
                  task = task
                    .finally(() => {
                      toastr.info("<span> " + element.fname + "</span> <span>" + element.action + "<span> on " + element.vols_nom + ".");
                      counter = counter + 1

                      var dataRequest =  {
                       action: 'update-notifiction',
                         id: element.id
                       }
                      AjaxCall(url, dataRequest).done(function(data) {})
                      if(data.length == counter) logsNotification();
                      
                    })
                    .then(() =>  delay(2000))
                })

            }else{
              // console.log(data)
              setTimeout( function(){ 

                logsNotification()
              }, 2000 );
            
            }
          });
        }
      });
    </script> -->
  </body>
</html>
