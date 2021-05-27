<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- data tables -->
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" >
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;
    var first_day_of_month =  yyyy + '-' + mm + '-' + '01';

    $(function(){
	    $("#date-start, #date-end").datepicker({ dateFormat: 'yy-mm-dd' });
        $('#date-start').val(first_day_of_month);
        $('#date-end').val(today);
        var $_firstquery = { action: "user-activities", dateStart: $('#date-start').val(), dateEnd: $('#date-end').val() };
        if( ($('#date-start').val() && $('#date-end').val() ) != '' )
            if(dateValidLen($('#date-start').val()) && dateValidLen($('#date-end').val()))
                    startAjax($_firstquery)

        $(document).on('click', '.ac-add-filter', function(){ $('.filter-functions').slideToggle('fast'); });
        $(document).on('click' , '#date-submit-filter', function(){
           let dateStart = $('#date-start').val();
           let dateEnd   = $('#date-end').val();
           var $_query = { action: "user-activities", dateStart: dateStart, dateEnd: dateEnd };
           if( (dateStart || dateEnd) == '' ){
               alertMsg("Please input a correct date")
           }else{
                if(dateValidLen(dateStart) && dateValidLen(dateEnd))
                    startAjax($_query)
                else
                    alertMsg("Please input a correct date")
           }
        });
    //END 
    });
    
    function startAjax($_query) {
        AjaxCall(url+'dashboard/employeeTable',$_query).done(AjaxSuccess);
    }
    
    function AjaxSuccess(data){
        //console.log(data)
        var items = [];
		for (var i in data){    
			var employee = (data[i].worker != null ) ? data[i].worker : 0 ;
			var created = (data[i].created != null ) ? data[i].created : 0 ;
			var modified = (data[i].modified != null ) ? data[i].modified : 0 ;
			var changedPrice = (data[i].changed_price != null ) ? data[i].changed_price : 0 ;
			var opens = (data[i].opens != null ) ? data[i].opens : 0 ;
            var total = Number(modified) + Number(changedPrice) + Number(opens); 
            var toPush = [ employee, created, modified , changedPrice , opens, total]
			items.push(toPush);
		}
        $('#user-counts-table').show();
		if(items != null){
			$('#user-counts-table').DataTable({
				destroy: true,
			    responsive: true,
			    pageLength: 25,
			    lengthMenu: [[25, 50, 100, -1],[25, 50, 100, "All"]], // Sets up the amount of records to display
			    scrollX: 420,
			    data: items,
			    search: { "addClass": 'search-bar' },
			    language: { "search": "_INPUT_",            // Removes the 'Search' field label
				},
			    columns: [
			        { title : "Employee", class: 'employee'},
			        { title : "Created", class: 'tr-created'},
			        { title : "Modified", class: 'tr-modified'},
			        { title : "Change Price", class: 'tr-changedprice'},
			        { title : "Opens", class: 'tr-opens'},
			        { title : "Total", class: 'tr-total'},
			    ]
			}) 
		}
        $('.dataTables_filter input[type="search"]').
  				attr('placeholder','Search ...').
  				css({'width':'350px','display':'inline-block'});
        //console.log(items);
    }

    function dateValidLen($date){
        let $check = $date.split("-");
        if($check.length != 3)
            return false;
        else{
            let $c_yy = $check[0], $c_mm = $check[1], $c_dd = $check[2];
            return (($c_yy.length == 4 && ($c_mm.length && $c_dd.length) == 2)) ? true : false;
        }
    }
</script>
<style>
    .filter-function-date{
        display: inline-block;
        margin: 5px 0 0 0;
    }
    .filter-functions {
        display: none;
        margin: 15px 0 0 0;
    }
</style>
<?php $this->end(); ?>

<?php $this->start('body')?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 mtop-35px">
            <div class="card card-style">
                <div class="card-body rdl-card-main-wrap no-padding">
                    <!-- HEADER STARTS row-4-card-div-overflow-style-->
						<div class="card-div-overflow-style row-4-card-div-overflow-style-2" style="position:relative; padding-top:20px;">
							<div class="row" style="color:#fff;margin: 0;">
								<div class="div-topheader-1 col-lg-12">
									<h5 style="display: inline-block; margin-right: 10px;">Employees Count Activity</h5>
									<p style="font-size:12px;font-weight: 500;">Display all actions create, open, modify and delete for every employee</p>
								</div>                                
							</div>
						</div >
                    <div class="activities-content">
                        <div class="filter-activities">

                            <span class="ac-add-filter"><i class="fas fa-plus-square"></i> &nbsp; <span class="ac-add-filter-span">Add Filter</span></span>
                            
                            <div class="filter-functions">
                                <div class="dropdown filter-function-date">
                                    <div>
                                        <input id="date-start" class="form-control" type="text" placeholder="Date" value="">
                                    </div>
                                </div>

                                <div class="dropdown filter-function-date">
                                    <div>
                                        <input id="date-end" class="form-control" type="text" placeholder="Date" value="">
                                    </div>
                                </div>
                                <div class="filter-function-date">
                                    <button class="btn btn-success" id="date-submit-filter">Search</button>
                                </div>
                            </div>
                        </div>

                        <div class="display-activities-content"> 
                            <table class="col-12">
                               
                            </table>
                        </div>
                    </div>
                    <!-- CONTENT STARTS -->
                        <div class="col-xs-12 div-body-table mt-4 mb-2" class="merchant-edition">
							<table id="user-counts-table" class="display" width="100%" style="font-size: 14px;">
								
							</table>
						</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end()?>

