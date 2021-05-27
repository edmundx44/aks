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
            // console.log(data)
        }).always(function(){});
    }

    function recentActivity($_query = null){
        if($_query == null)
            var $_query = { action: 'recent-activity', employee: null, website: 'aks', useraction: 'created' };
        AjaxCall(url+'dashboard/activities', $_query).done( recentActAjax )
    }

    function recentActAjax(data){
        $("#recent-activity-body").empty();
        // console.log(data)
        if(data.length != 0){
            var counter = 1;

            for(var i in data){
                var backColor = (counter % 2 == 0)? 'tableBody-Even-background' : '';
                var game_id = (data[i].normalised_name == null) ? '----' : data[i].normalised_name;
                var worker = data[i].worker.substr(0,1).toUpperCase()+ data[i].worker.substr(1).toLowerCase();
                var app  =  '<tr class="'+backColor+' tr-content">';
                    app +=  '   <td class="date" style="padding: 10px;">'+strtotime_javascript_time(data[i].time,"Asia/Manila")+'</td>';
                    app +=  '   <td class="name" style="padding: 10px;">'+worker+'</td>';
                    app +=  '   <td class="action" style="padding: 10px;"> '+data[i].action+'</td>';
                    app +=  '   <td class="game_id hide-on-smmd-lg" style="padding: 10px;">'+game_id+'</td>';
                    app +=  '   <td class="link hide-on-smmd-lg" style="padding: 10px;">'+data[i].url+'</td>';
                    app +=  '   <td class="site hide-on-smmd-lg" style="padding: 10px;">'+data[i].site+'</td>';
                    app +=  '</tr>';
                    app +=  '<tr class="'+backColor+' hide-act-data">';
                    app +=  '   <td colspan="3">';
                    app +=  '       <div style="padding: 0 10px 10px 10px;word-break: break-all;">';
                    app +=  '           <p>Game ID : <span>'+ game_id +'</span></p>';
                    app +=  '           <p>Site : <span>'+ data[i].site +'</span></p>';
                    app +=  '           <p>Link : <span>'+ html_decode(data[i].url) +'</span></p>';
                    app +=  '       </div>';
                    app +=  '   </td>';
                    app +=  '</tr>';
                $("#recent-activity-body").append(app);
                counter++;
            }
        }else{
            alertMsg("No Data Found")
        }
    }

    function strtotime_javascript_time(epoch,$tzString) {
        var dateY = new Date(epoch*1000).toLocaleString("en-US",{timeZone: $tzString});
        return (dateY != '') ? dateY : 'No Data';
    }