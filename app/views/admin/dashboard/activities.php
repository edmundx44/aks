<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<script>
    $(function() {
        

// filter section -------------------------------------------------------------------
        $(document).on('click', '#activities-submit-filter', function(){
            if($('.select-btn-employee').html() == 'Employee' || $('.select-btn-action').html() == 'Action' || $('.select-btn-site').html() == 'Site') {
                alertMsg('Invalid Entry, Cindly check it carefully.')
            }else{
               // toRequestEmployee = $('.select-btn-employee').html();
               // toRequestAction =$('.select-btn-action').html();
               // toRequestSite = $('.select-btn-site').html();
            }
        });
        

        $(document).on('click', '.ac-add-filter', function(){
            $('.filter-functions').slideToggle('fast');
            displayEmployee('');
        });

        $(document).on('click', '.select-btn-team-di', function(){
            $('.select-btn-team').html($(this).html());
            $('.select-btn-team-di-remove').remove();
            $('.select-btn-team-dm').prepend("<span class='dropdown-item act-dropdown select-btn-team-di select-btn-team-di-remove' style='cursor: pointer;pointer-events: none;color: #6b6d70;'>Select Team's</span>");

            displayEmployee($(this).data('whatni'));
            $('.select-btn-employee').html('Employee');
        });
        $(document).on('click', '.select-btn-action-di', function(){
            $('.select-btn-action').html($(this).html());
            $('.select-btn-action-remove').remove();
            $('.select-btn-action-dm').prepend("<span class='dropdown-item act-dropdown select-btn-action-di select-btn-action-remove' style='cursor: pointer;pointer-events: none;color: #6b6d70;'>Select Action</span>");
            // $(this).data('whatni')
        });
        $(document).on('click', '.select-btn-site-di', function(){
            $('.select-btn-site').html($(this).html());
            $('.select-btn-site-remove').remove();
            $('.select-btn-site-dm').prepend("<span class='dropdown-item act-dropdown select-btn-site-di select-btn-site-remove' style='cursor: pointer;pointer-events: none;color: #6b6d70;'>Select Site</span>");
        });
        $(document).on('click', '.select-btn-employee-di', function(){
            $('.select-btn-employee').html($(this).html());
            $('.select-btn-employee-remove').remove();
            $('.select-btn-employee-dm').prepend("<span class='dropdown-item act-dropdown select-btn-employee-di select-btn-employee-remove' style='cursor: pointer;pointer-events: none;color: #6b6d70;'>Select Worker</span>");
        });
        
        
    }); //end document ready
    function displayEmployee($role){
        $('.select-btn-employee-dm').empty();
        var dataRequest =  { 
            action: 'display-employee',
            getRole: $role
        }
        AjaxCall(url, dataRequest).done(function(data){
            for(var i in data){
                $('.select-btn-employee-dm').append('<span class="dropdown-item act-dropdown select-btn-employee-di" style="cursor: pointer;">'+ data[i].username +'</span>')
            }
            console.log(data)
        }).always(function(){});
    }
</script>
<style>
    .ac-add-filter:hover > .ac-add-filter-span{
        text-decoration: underline;  
    }
    .act-dropdown:hover {
        background-color:   #007bff;
        color:  #fff;
    }
    .display-activities-content {
        margin: 15px 0 0 0;
    }
    .select-btn-employee-dm {
        height:     auto;   
        max-height: 500px;
        overflow-y: scroll; 
        overflow-x: hidden  ; 
    }
</style>
<?php $this->end(); ?>
<?php $this->start('body')?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 mtop-35px">
            <div class="card card-style card-normalmode">
                <div class="card-body no-padding" style=""   > 
                    <div class="card-div-overflow-style row-1-card-div-overflow-style-1" style="    padding-bottom: 8px;">
                       <p style="position: relative;top: 20px;padding-left: 20px;padding-right: 20px;color: #fff;letter-spacing: 1px;">Recent Activities</p>
                       <p style="position: relative;top: 3px;padding-left: 20px;padding-right: 20px;color: #fff;font-size: 13px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </div>
                    <div class="activities-content" style=" padding-bottom:     20px;" >
                        <div class="filter-activities" style="padding: 0 20px 0 20px;" >

                            <span class="ac-add-filter" style="cursor: pointer;"><i class="fas fa-plus-square" style="color:#007bff;"></i> &nbsp; <span class="ac-add-filter-span">Add Filter</span></span>
                            
                            <div class="filter-functions" style="display: none;margin: 5px 0 0 0;">

                                <div class="dropdown" style="display: inline-block;margin: 5px 0 0 0;">
                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" style="width: 160px;">
                                        <span class="float-left select-btn-team">Select Team's</span>
                                    </button>
                                    
                                    <div class="dropdown-menu select-btn-team-dm">
                                        <span class="dropdown-item act-dropdown select-btn-team-di" data-whatni="" style="cursor: pointer;">All</span>
                                        <span class="dropdown-item act-dropdown select-btn-team-di" data-whatni="bots_team" style="cursor: pointer;">Bot's team</span>
                                        <span class="dropdown-item act-dropdown select-btn-team-di" data-whatni="developer" style="cursor: pointer;">Developer's</span>
                                        <span class="dropdown-item act-dropdown select-btn-team-di" data-whatni="price" style="cursor: pointer;">Price team</span>
                                     </div>
                                </div>

                                <div class="dropdown" style="display: inline-block;margin: 5px 0 0 0;">
                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" style="width: 160px;">
                                        <span class="float-left select-btn-employee">Employee</span>
                                    </button>

                                    <div class="dropdown-menu select-btn-employee-dm scrollbar-custom">
                                        
                                     </div>
                                </div>

                                <div class="dropdown" style="display: inline-block;margin: 5px 0 0 0;">
                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" style="width: 160px;">
                                        <span class="float-left select-btn-action">Action</span>
                                    </button>
                                    
                                    <div class="dropdown-menu select-btn-action-dm">
                                        <span class="dropdown-item act-dropdown select-btn-action-di" style="cursor: pointer;">Create</span>
                                        <span class="dropdown-item act-dropdown select-btn-action-di" style="cursor: pointer;">Modified</span>
                                        <span class="dropdown-item act-dropdown select-btn-action-di" style="cursor: pointer;">Opens</span>
                                        <span class="dropdown-item act-dropdown select-btn-action-di" style="cursor: pointer;">Changed Price</span>
                                        <span class="dropdown-item act-dropdown select-btn-action-di" style="cursor: pointer;">Deleted</span>
                                     </div>
                                </div>

                                <div class="dropdown" style="display: inline-block;margin: 5px 0 0 0;">
                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" style="width: 160px;">
                                        <span class="float-left select-btn-site">Site</span>
                                    </button>
                                    
                                    <div class="dropdown-menu select-btn-site-dm">
                                        <span class="dropdown-item act-dropdown select-btn-site-di" style="cursor: pointer;">AKS</span>
                                        <span class="dropdown-item act-dropdown select-btn-site-di" style="cursor: pointer;">CDD</span>
                                        <span class="dropdown-item act-dropdown select-btn-site-di" style="cursor: pointer;">BREX</span>
                                     </div>
                                </div>

                                <div class="dropdown" style="display: inline-block;margin: 5px 0 0 0;">
                                    <button class="btn btn-success" id="activities-submit-filter">Submit</button>
                                </div>
                            </div>
                        </div>

                        <div class="display-activities-content"> 
                            <table class="col-12">
                                <thead>
                                    <tr style="color: #fff;background-color: #007bff;">
                                        <th class="" style="padding: 10px;border-radius:  5px 0 0 0;">Date</th>
                                        <th class="" style="padding: 10px;">Employee</th>
                                        <th class="" style="padding: 10px;">Action</th>
                                        <th class="" style="padding: 10px;">Game ID</th>
                                        <th class="" style="padding: 10px;">Link</th>
                                        <th class="" style="padding: 10px;border-radius:  0 5px 0 0;">Site</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    <!-- dynamic data here from database -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end()?>

