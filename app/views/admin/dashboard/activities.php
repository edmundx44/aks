<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<script>
    var $url = '<?=PROOT?>activities/act';
    $(function() {

        recentActivity();

        // filter section -------------------------------------------------------------------
        $(document).on('click', '#activities-submit-filter', function(){
            if($('.select-btn-employee').html() == 'Employee' || $('.select-btn-action').html() == 'Action' || $('.select-btn-site').html() == 'Site') {
                alertMsg('Invalid Entry, Cindly check it carefully.')
            }else{
               toRequestEmployee = $('.select-btn-employee').attr('data-getEmployee');
               toRequestAction =$('.select-btn-action').attr('data-getAction');
               toRequestSite = $('.select-btn-site').attr('data-getSite');
               var $_query = { action: 'recent-activity', employee: toRequestEmployee, website: toRequestSite, useraction: toRequestAction };
               recentActivity($_query)
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
            $('.select-btn-action').attr('data-getAction', $(this).attr('data-action'))
        });
        $(document).on('click', '.select-btn-site-di', function(){
            $('.select-btn-site').html($(this).html());
            $('.select-btn-site-remove').remove();
            $('.select-btn-site-dm').prepend("<span class='dropdown-item act-dropdown select-btn-site-di select-btn-site-remove' style='cursor: pointer;pointer-events: none;color: #6b6d70;'>Select Site</span>");

            $('.select-btn-site').attr('data-getSite', $(this).attr('data-site'))
        });
        $(document).on('click', '.select-btn-employee-di', function(){
            $('.select-btn-employee').html($(this).html());
            $('.select-btn-employee-remove').remove();
            $('.select-btn-employee-dm').prepend("<span class='dropdown-item act-dropdown select-btn-employee-di select-btn-employee-remove' style='cursor: pointer;pointer-events: none;color: #6b6d70;'>Select Worker</span>");

            $('.select-btn-employee').attr('data-getEmployee', $(this).attr('data-employee'));
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
                let employee = data[i].username.substr(0,1).toUpperCase()+data[i].username.substr(1).toLowerCase();
                $('.select-btn-employee-dm').append('<span class="dropdown-item act-dropdown select-btn-employee-di" style="cursor: pointer;" data-employee='+data[i].username+'>'+ employee +'</span>')
            }
            console.log(data)
        }).always(function(){});
    }

    function recentActivity($_query = null){
        if($_query == null)
            var $_query = { action: 'recent-activity', employee: null, website: 'aks', useraction: 'created' };
        AjaxCall(url+'dashboard/activities', $_query).done( recentActAjax )
    }

    function recentActAjax(data){
        $("#recent-activity-body").empty();
        console.log(data)
        if(data.length != 0){
            for(var i in data){
                var game_id = (data[i].normalised_name == null) ? '----' : data[i].normalised_name;
                var worker = data[i].worker.substr(0,1).toUpperCase()+ data[i].worker.substr(1).toLowerCase();
                var app  = '<tr class="tr-content">';
                    app +=    '<td class="date">'+strtotime_javascript_time(data[i].time,"Asia/Manila")+'</td>';
                    app +=    '<td class="name">'+worker+'</td>'
                    app +=    '<td class="action">'+data[i].action+'</td>'
                    app +=    '<td class="game_id">'+game_id+'</td>'
                    app +=    '<td class="link">'+data[i].url+'</td>'
                    app +=    '<td class="site">'+data[i].site+'</td>'
                    app += '</tr>'
                $("#recent-activity-body").append(app);
            }
        }else{
            alertMsg("No Data Found")
        }
    }

    function strtotime_javascript_time(epoch,$tzString) {
        var dateY = new Date(epoch*1000).toLocaleString("en-US",{timeZone: $tzString});
        return (dateY != '') ? dateY : 'No Data';
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
                       <p style="position: relative;top: 20px;padding-left: 20px;padding-right: 20px;color: #fff;letter-spacing: 1px;">Recently Created</p>
                       <p style="position: relative;top: 3px;padding-left: 20px;padding-right: 20px;color: #fff;font-size: 13px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </div>
                    <div class="activities-content" style=" padding-bottom:20px;" >
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
                                        <span class="dropdown-item act-dropdown select-btn-action-di" style="cursor: pointer;" data-action="created">Create</span>
                                        <span class="dropdown-item act-dropdown select-btn-action-di" style="cursor: pointer;" data-action="modified">Modified</span>
                                        <span class="dropdown-item act-dropdown select-btn-action-di" style="cursor: pointer;" data-action="opens">Opens</span>
                                        <span class="dropdown-item act-dropdown select-btn-action-di" style="cursor: pointer;" data-action="changed_price">Changed Price</span>
                                        <span class="dropdown-item act-dropdown select-btn-action-di" style="cursor: pointer;" data-action="deleted">Deleted</span>
                                     </div>
                                </div>

                                <div class="dropdown" style="display: inline-block;margin: 5px 0 0 0;">
                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" style="width: 160px;">
                                        <span class="float-left select-btn-site">Site</span>
                                    </button>
                                    
                                    <div class="dropdown-menu select-btn-site-dm">
                                        <span class="dropdown-item act-dropdown select-btn-site-di" style="cursor: pointer;" data-site="aks">AKS</span>
                                        <span class="dropdown-item act-dropdown select-btn-site-di" style="cursor: pointer;" data-site="cdd">CDD</span>
                                        <span class="dropdown-item act-dropdown select-btn-site-di" style="cursor: pointer;" data-site="brexitgbp">BREX</span>
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
                                <tbody id="recent-activity-body">
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

