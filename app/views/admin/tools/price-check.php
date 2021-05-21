<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>
	<script type="text/javascript">
		var dailyActTotal = '';
		var dailyActOffset = 0;

		$(function() {
			setActiveTab(getUrlParameter('tab'));
			

//if modal close function
			$('#pc-add-shift-modal, #price_check_tool_modal_add_game, #add-wrong-aff-link-modal').on('hidden.bs.modal', function () {
				$('.edit-id-text, .edit-id-text-daily, #price_check_tool_game_id, #price_check_tool_game_name, .edit-id-text-wrong, .txt-input-wrong-link, .div-clone-val, .div-get-avail').val('');

				$('select').prop('selectedIndex',0);
				$('.modal-assign-title-txt').text('Add Shift');
				$('.modal-daily-title-txt').text('Add Game To Check');
				$('.modal-wrong-title-txt').text('Add Wrong Affiliate Links');
				$('.err-msg').hide();
	        });

// tab menu function -----------------------------------------------------------------
			$(document).on('click', '.pc-li-btn', function(){
				var getId = $(this).attr('id');
				$('.pc-li-btn').removeClass('active-pc-menu');
				$('#'+$(this).attr('id')).addClass('active-pc-menu');
				$('.pc-content-div').hide();
				$('.'+$(this).attr('id')).show();

				switch(getId){
					case 'pc-cda-div':
						var param = '';
						displayDailyActivity();
						$('#pc-cda-search').val('')
					break;
					case 'pc-ac-div':
						var param = '?tab=assign-checker';
						displayAssignChecker();
						displayChecker();
						selectHour();
						selectMin();
					break;
					case 'pc-adlg-div':
						var param = '?tab=add-daily-listing';
						displayDailyListing();
					break;
					case 'pc-pr-div':
						var param = '?tab=affiliate-problem-report';
						displayWrongAffLink();
						getWrongAffDaily();
					break;
				}
				var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + param;
				window.history.pushState({ path: newurl }, '', newurl);

			});
// affiliate problem report section ----------------------------------------------------------------------
			$(document).on('click', '.btn-add-wrong-link', function(){
	            	var toEditPr = ($('.edit-id-text-wrong').val())? $('.edit-id-text-wrong').val() : '';

	                if(($('.daily-aff').val() == "11" && $('.edit-id-text-wrong').val() != '') || ($('.daily-aff').val() == "00")) {
	                	var dataRequest =  { 
							action: 'add-wrong-aff-link',
							toEditId: toEditPr,
							wrongAffLink: $('.txt-input-wrong-link').val()
						}

						AjaxCall(url, dataRequest).done(function(){
							displayWrongAffLink();
							getWrongAffDaily();
						}).always(function(){ 
							$('#add-wrong-aff-link-modal').modal('hide');
						});

	                }else{
	                    alert('Already Added Today.')
	                }
	        });


// add daily listing function ---------------------------------------------------------------
			$("#release-date").datepicker({ dateFormat: 'yy-mm-dd' });

			$(document).on('click', '#release-date', function(){
				$('#release-date').datepicker('show');
			});
			
			$(document).on('keyup', '#price_check_tool_game_id', function(){
				checkAvailable($(this).val())
			});

			$(document).on('click', '.price_check_tool_add', function(event){
				var toEditDailyListing = ($('.edit-id-text-daily').val() != '')? $('.edit-id-text-daily').val() : '';
	            
	            if($('.div-get-avail').val() == "00" || $('.div-get-avail').val() == "" || $('#price_check_tool_game_name').val() == ""){
	                alert("Invalid Information, Kindly input the right data.");

	                event.preventDefault();
	                return false; 
	            }else{
	                var $dateInput = $('#release-date').val();
	              
	              	var dataRequest =  { 
						action: 'add-daily-listing',
						toEditId: toEditDailyListing,
						gameId: $('#price_check_tool_game_id').val(),
						gameName: $('#price_check_tool_game_name').val(),
						releaseDate: $("#release-date").val()
					}
					AjaxCall(url, dataRequest).done(function(){
						displayDailyListing();
					}).always(function(){ 
						$('#price_check_tool_modal_add_game').modal('hide');
					});
	            }
	    
	        });

// revemod data function ---------------------------------------------------------------
			$(document).on('click', '.btn-remove-data', function(){
				switch($(this).attr('data-action')){
					case 'on-assign-checker':
						var	appendtoheader = 'Are you sure you want to remove this checker?';
						var	appendtobody = 	'';
						var appendtofooter = '<button data-asid="'+$(this).attr('id')+'" type="button" class="btn btn-danger" id="btn-remove-assign-checker">Submit</button>';
					break;
					case 'on-daily-listing':
						var	appendtoheader = 'Are you sure you want to remove this game?';
						var	appendtobody = 	'';
						var appendtofooter = '<button data-asid="'+$(this).attr('id')+'" type="button" class="btn btn-danger" id="btn-remove-daily-listing">Submit</button>';
					break;
					case 'on-wrong-link':

					break;
				}

				confirmationModal(appendtoheader,appendtobody,appendtofooter);
			});

			$(document).on('click', '#btn-remove-assign-checker', function(){
				var dataRequest =  { 
					action: 'pc-removed-assign-checker', 
					idToRemove: $(this).data('asid')
				}
				AjaxCall(url, dataRequest).done(function(){}).always(function(){ 
					displayAssignChecker();
					$('#report-modal-confirmation').modal('hide');
				});
			});

			$(document).on('click', '#btn-remove-daily-listing', function(){
				var dataRequest =  { 
					action: 'pc-removed-daily-listing', 
					idToRemove: $(this).data('asid')
				}
				AjaxCall(url, dataRequest).done(function(){}).always(function(){ 
					displayDailyListing();
					$('#report-modal-confirmation').modal('hide');
				});
			});

// edit shift function ---------------------------------------------------------------
			$(document).on('click', '.btn-edit-data', function(){
				var getEditId = $(this).attr('id');

				switch($(this).attr('data-action')){
					case 'on-daily-listing':
						$('.edit-id-text-daily').val(getEditId);
						$('.modal-daily-title-txt').text('Edit Game To Check');
						$('#price_check_tool_game_id').val($(this).attr('data-gameId'));
						$('#price_check_tool_game_name').val($(this).attr('data-gameName'));
						$('.div-get-avail, .div-clone-val').val($(this).attr('data-gameId'));
						$("#release-date").datepicker({ dateFormat: 'yy-mm-dd' }).val($(this).attr('data-dateni'));
						$('#price_check_tool_modal_add_game').modal('show');
					break;
					case 'on-assign-checker':
						$('.edit-id-text').val(getEditId);
						$('.modal-assign-title-txt').text('Edit Shift');
						$('.select-checker').val($(this).attr('data-assignChecker'));

						var weekSched = $(this).attr('data-weekdaySchedule');
						var sundSched = $(this).attr('data-sundaySchedule');

						$('.s-start-time-h').val($.trim(weekSched.substr(0, 1)));
						$('.s-start-time-min').val($.trim(weekSched.substr(2, 2)));
						$('.s-start-ampm').val($.trim(weekSched.substr(5, 2)));
						$('.s-end-time-h').val($.trim(weekSched.substr(-7, 1)));
						$('.s-end-time-min').val($.trim(weekSched.substr(-5, 2)));
						$('.s-end-ampm').val($.trim(weekSched.substr(-2, 2)));

						if (sundSched != "None") {
							$('.s-start-time-h-sunday').val($.trim(sundSched.substr(0, 1)));
							$('.s-start-time-min-sunday').val($.trim(sundSched.substr(2, 2)));
							$('.s-start-ampm-sunday').val($.trim(sundSched.substr(5, 2)));
							$('.s-end-time-h-sunday').val($.trim(sundSched.substr(-7, 1)));
							$('.s-end-time-min-sunday').val($.trim(sundSched.substr(-5, 2)));
							$('.s-end-ampm-sunday').val($.trim(sundSched.substr(-2, 2)));
						}

						$('#pc-add-shift-modal').modal('show');
					break;
					case 'on-wrong-link':
						$('.edit-id-text-wrong').val(getEditId);
						$('.modal-wrong-title-txt').text('Edit Wrong Affiliate Links');
						$('.txt-input-wrong-link').val($(this).attr('data-wrongAffLink'));
						$('#add-wrong-aff-link-modal').modal('show');
					break;
				}

				// if(getEditAction == 'on-daily-listing'){
				// 	$('.edit-id-text-daily').val(getEditId);
				// 	$('.modal-daily-title-txt').text('Edit Game To Check');
				// 	$('#price_check_tool_game_id').val($(this).attr('data-gameId'));
				// 	$('#price_check_tool_game_name').val($(this).attr('data-gameName'));
				// 	$('.div-get-avail, .div-clone-val').val($(this).attr('data-gameId'));
				// 	$('#price_check_tool_modal_add_game').modal('show');
				// }else if(getEditAction == 'on-assign-checker'){
					
				// }else if(getEditAction == 'on-wrong-link'){
				// 	$('.edit-id-text-wrong').val(getEditId);
				// 	$('.modal-wrong-title-txt').text('Edit Wrong Affiliate Links');
				// 	$('.txt-input-wrong-link').val($(this).attr('data-wrongAffLink'));

				// 	$('#add-wrong-aff-link-modal').modal('show');
				// }
			});
// add shift function ---------------------------------------------------------------
			$(document).on('click', '.btn-set-shift', function(e){
				var weekdaySchedule = '';
				var sundaySchedule = '';

				// error trapping -------------------------------------
				if ($('.s-start-time-h').val() == null || $('.s-start-time-min').val() == null || $('.s-end-time-h').val() == null || $('.s-end-time-min').val() == null){
					alert("Week Day's schedule is incorrect, Kindly set the time properly.");
					weekdaySchedule = '';
				}else weekdaySchedule = $('.s-start-time-h').val() + ":" + $('.s-start-time-min').val() + " " + $('.s-start-ampm').val() + " - " + $('.s-end-time-h').val() + ":" + $('.s-end-time-min').val() + " " + $('.s-end-ampm').val();

				if ($('.s-start-time-h-sunday').val() != null || $('.s-start-time-min-sunday').val() != null || $('.s-end-time-h-sunday').val() != null || $('.s-end-time-min-sunday').val() != null){  
					if ($('.s-start-time-h-sunday').val() != null && $('.s-start-time-min-sunday').val() != null && $('.s-end-time-h-sunday').val() != null && $('.s-end-time-min-sunday').val() != null){
						sundaySchedule = $('.s-start-time-h-sunday').val() + ":" + $('.s-start-time-min-sunday').val() + " " + $('.s-start-ampm-sunday').val() + " - " + $('.s-end-time-h-sunday').val() + ":" + $('.s-end-time-min-sunday').val() + " " + $('.s-end-ampm-sunday').val();
					}else{
						alert('Sunday schedule is incorrect, Kindly set the time properly.');
						$('.s-start-time-h-sunday, .s-start-time-min-sunday, .s-end-time-h-sunday, .s-end-time-min-sunday').prop('selectedIndex',0);
						e.preventDefault();
						sundaySchedule = '';
						return false;
					}
				}
	
				var toEditShift = ($('.edit-id-text').val() != '')? $('.edit-id-text').val(): '';

				if (weekdaySchedule != '' ) {
					if ( $('.select-checker').val() != null ){
						var sundayS = (sundaySchedule == '')? 'None': sundaySchedule;
						
						var dataRequest =  {
							action: 'add-shift',
							toEditId: toEditShift,
							assignChecker: $(".select-checker option:selected").text(),
							weekdaySchedule : weekdaySchedule,
							sundaySchedule: sundayS
						}
						AjaxCall(url, dataRequest).done(function(data) {
							displayAssignChecker();
						}).always(function(){
							$('#pc-add-shift-modal').modal('hide');
						});
					}else alert('Kindly Select a Checker.');
				}
			});

// check daila activity or cda search function ---------------------------------------------------------------
			$(document).on('keyup ', '#pc-cda-search', _.debounce(function(event){
				$(".pc-cda-div-display").empty();
				var dataRequest =  {
					action: 'pc-cda-search-data',
					toSearch: $(this).val()
				}
				AjaxCall(url, dataRequest).done(function(data) {
					for(var i in data) {
						appendtoDailyAct(data[i].checkerName, data[i].gameId, data[i].gameName, data[i].checkerActivity, data[i].url, data[i].date);
					}
				}).always(function(){
					$('.pc-cda-tfoot').hide();
				});
			}, 200));
// display more function -------------------------------------------------------------------------------------
			$(document).on('click', '.pc-lmore-fucntion', function(){
				var dataRequest =  {
					action: 'displayMoreDailyActivity',
					getOffset: dailyActOffset
				}
				AjaxCall(url, dataRequest).done(function(data) {
					for(var i in data) {
						appendtoDailyAct(data[i].checkerName, data[i].gameId, data[i].gameName, data[i].checkerActivity, data[i].url, data[i].date);
					}
				}).always(function(data){
					dailyActOffset = dailyActOffset + data.length
					if(dailyActOffset == dailyActTotal) $('.pc-cda-tfoot').hide();
				});
			});

// display all function -------------------------------------------------------------------------------------
			$(document).on('click', '.pc-dall-function', function(){
				var dataRequest =  {
					action: 'displayAllDailyActivity',
					getTotal: dailyActTotal,
					getOffset: dailyActOffset
				}
				AjaxCall(url, dataRequest).done(function(data) {
					for(var i in data) {
						for(var j in data[i].data){
							appendtoDailyAct(data[i].data[j].checkerName, data[i].data[j].gameId, data[i].data[j].gameName, data[i].data[j].checkerActivity, data[i].data[j].url.url, data[i].data[j].date);
						}
					}
				}).always(function(data){
					$('.pc-cda-tfoot').hide();
				});
			});
		}); // end ready *************************************************************************************


		function displayDailyActivity(){
			$(".pc-cda-div-display").empty();
			var dataRequest =  {
				action: 'pc-cda-div',
			}

			AjaxCall(url, dataRequest).done(function(data) {
				for(var i in data[0].data){
					appendtoDailyAct(data[0].data[i].checkerName, data[0].data[i].gameId, data[0].data[i].gameName, data[0].data[i].checkerActivity, data[0].data[i].url, data[0].data[i].date);
				}
			}).always(function(data){
				dailyActTotal = data[0].total
				dailyActOffset = data[0].data.length;
			});
		}

		function appendtoDailyAct($checkername, $gameid, $gamename, $checkeractivity, $url, $date){
			var	append =	'<tr class="pc-cda-div-display-tr">';
				append +=	'<td class="" style="padding: 10px;">'+ $checkername +'</td>';
				append +=	'<td class="" style="padding: 10px;">'+ $gameid +'</td>';
				append +=	'<td class="" style="padding: 10px;">'+ $gamename +'</td>';
				append +=	'<td class="" style="padding: 10px;">'+ $checkeractivity +'</td>';
				append +=	'<td class="" style="padding: 10px; word-break: break-all;">'+ html_decode($url) +'</td>';
				append +=	'<td class="" style="padding: 10px; ">'+ moment($date).format('MMMM Do YYYY, h:mm:ss a'); +'</td>';
				append +=	'</tr>';
			$(".pc-cda-div-display").append(append);
		}

		function displayAssignChecker(){
			$('.pc-ac-div-display').empty()
			var dataRequest =  {
				action: 'display-assign-checker',
			}
			AjaxCall(url, dataRequest).done(function(data) {
				for (var i in data){
					var append =  "<tr>";
						append +=   "<td style='padding: 5px 10px 0 10px;'>"+data[i].assignChecker+"</td>";
						append +=   "<td style='padding: 5px 10px 0 10px;'>"+data[i].weekdaySchedule+"</td>";
						append +=   "<td style='padding: 5px 10px 0 10px;'>"+data[i].sundaySchedule+"</td>";
						append +=   "<td style='padding: 5px 10px 0 10px; text-align: center;'><button type='button' class='btn btn-primary btn-edit-data' id='"+data[i].id+"' data-action='on-assign-checker' data-assignChecker='"+data[i].assignChecker+"' data-weekdaySchedule='"+data[i].weekdaySchedule+"' data-sundaySchedule='"+data[i].sundaySchedule+"'><i class='fa fa-pencil' aria-hidden='true'></i> Edit</button> <button type='button' class='btn btn-warning btn-remove-data' id='"+data[i].id+"' data-action='on-assign-checker'><i class='fa fa-trash-o' aria-hidden='true'></i> Remove</button></td>";
						append += "</tr>";
					$(".pc-ac-div-display").append(append);
				}
			}).always(function(){});
		}

		function displayDailyListing(){
			$('.pc-adlg-div-display').empty()
			var dataRequest =  {
				action: 'display-daily-listing',
			}
			AjaxCall(url, dataRequest).done(function(data) {
				for (var i in data){
					var append =  "<tr>";
                        append +=   "<td style='padding: 5px 10px 0 10px;'>"+data[i].gameId+"</td>";
                        append +=   "<td style='padding: 5px 10px 0 10px;'>"+data[i].gameName+"</td>";
                        append +=   "<td style='padding: 5px 10px 0 10px;'>"+data[i].releaseDate+"</td>";
                        append +=   "<td style='padding: 5px 10px 0 10px;'>"+data[i].createdBy+"</td>";
                        append +=   "<td style='padding: 5px 10px 0 10px;'>"+data[i].createdAt+"</td>";
                        append +=   "<td style='padding: 5px 10px 0 10px; text-align: center;'><button type='button' class='btn btn-primary btn-edit-data' id='"+data[i].id+"' data-dateni='"+data[i].releaseDate+"' data-action='on-daily-listing' data-gameId='"+data[i].gameId+"' data-gameName='"+data[i].gameName+"'>Edit</button> <button type='button' class='btn btn-warning btn-remove-data' id='"+data[i].id+"' data-action='on-daily-listing'>Remove</button></td>";
                        append += "</tr>";
					$(".pc-adlg-div-display").append(append);
				}
			}).always(function(){});
		}

		function displayWrongAffLink(){
			$('.pc-pr-div-display').empty()
	        var d = new Date();
	        var nowDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();

	        var dataRequest =  {
				action: 'display-wrong-affilliate-link',
			}
			AjaxCall(url, dataRequest).done(function(data) {
				var total = 0;

				for (var i in data){
					var append =  "<tr>";
						append +=   "<td style='padding: 5px 10px 0 10px;font-weight: 700;'>"+data[i].wrongAffLink+"</td>";
						append +=   "<td style='padding: 5px 10px 0 10px;'>"+ moment(data[i].addedDate).format('MMMM Do YYYY, h:mm:ss a') +"</td>";
						append +=   "<td style='padding: 5px 10px 0 10px; text-align: center;'><button type='button' class='btn btn-primary btn-edit-data' id='"+data[i].id+"' data-action='on-wrong-link' data-wrongAffLink='"+data[i].wrongAffLink+"'>Edit</button> <button type='button' class='btn btn-warning btn-remove-data' id='"+data[i].id+"' data-action='on-wrong-link' style='display:none;'>Remove</button></td>";
						append += "</tr>";
					$(".pc-pr-div-display").append(append);

					var de = new Date(data[i].addedDate);
					var datethis = de.getFullYear() + "-" + (de.getMonth()+1) + "-" + de.getDate();
					if(nowDate == datethis) {
						var num = parseInt(data[i].wrongAffLink);
						total += num 
					}
				}
				$('.result-today').html(total);   
			}).always(function(){});
		}


		function displayChecker(){
			var dataRequest =  {
				action: 'displayChecker',
			}
			AjaxCall(url, dataRequest).done(function(data) {
				for (var i in data){
					$(".select-checker").append("<option value='"+data[i].username+"'>"+data[i].username+"</option>");
				}
			}).always(function(){});
		}

		function selectHour(){
			for (var i = 1; i <= 12; i++) $(".s-start-time-h, .s-end-time-h, .s-start-time-h-sunday, .s-end-time-h-sunday").append("<option value='"+i+"'>"+i+"</option>");
		}

		function selectMin(){
			for (var i = 0; i <= 60; i++) {
				if (i <= 9) i = "0"+i;
				$(".s-start-time-min, .s-end-time-min, .s-start-time-min-sunday, .s-end-time-min-sunday").append("<option value='"+i+"'>"+i+"</option>");
			}
		}

		function checkAvailable($checkGameId){
			var dataRequest =  {
				action: 'check-gameID-availability',
				toCheck: $checkGameId
			}
			AjaxCall(url, dataRequest).done(function(data) {
				if($('.div-clone-val').val() == $('#price_check_tool_game_id').val() && data == '00'){
					$('.div-get-avail').val('22');
					$('.err-msg').fadeOut();
				}else if(data == '00'){
					$('.div-get-avail').val('00');
					$('.err-msg').fadeIn().css({'color':'red'}).text('This ID is already added');
				}else if($('#price_check_tool_game_id').val() == '' && data == '11'){
					$('.div-get-avail').val('00');
					$('.err-msg').fadeOut();
				}else{
					$('.div-get-avail').val('11');
				$('.err-msg').fadeIn().css({'color':'green'}).text('Game ID available');
				}
			}).always(function(){});
		}

		function getWrongAffDaily(){
			var dataRequest =  {
				action: 'get-wrong-affilliate-daily',
			}
			AjaxCall(url, dataRequest).done(function(data) {
				$('.daily-aff').val(data);
			}).always(function(){});
		}

		function setActiveTab($param){
			$('.pc-li-btn').removeClass('active-pc-menu');
			$('.pc-content-div').hide();
			switch($param){
				case 'assign-checker':
					var divClassID = 'pc-ac-div';
					displayAssignChecker();
					displayChecker();
					selectHour();
					selectMin();
				break;
				case 'add-daily-listing':
					var divClassID = 'pc-adlg-div';
					displayDailyListing();
				break;
				case 'affiliate-problem-report':
					var divClassID = 'pc-pr-div';
					displayWrongAffLink();
					getWrongAffDaily();
				break;
				default:
					var divClassID = 'pc-cda-div';
					displayDailyActivity();
					$('#pc-cda-search').val('')
				break;
			}

			$('.'+divClassID).show();
			$('#'+divClassID).addClass('active-pc-menu');
		}
	</script>
	<style type="text/css">
		.pc-li-btn {
			cursor: pointer;
		}
		.active-pc-menu {
			background-color: rgba(255, 255, 255, .2);
		}
		.pc-cda-div-display-tr:nth-child(even) {
 			background-color: #cccccc;
		}
		.pc-cda-table-h-sticky {
			position: sticky;
			background-color: #0062cc;
			top: 88px; /* Don't forget this, required for the stickiness */
		}
		.pc-content-div {
			display: none;
		}
		.pc-th-class {
			padding: 10px;font-weight: normal !important
		}
		.pc-th-class-wc {
			text-align: center;
		}
	</style>
<?php $this->end(); ?>
<?php $this->start('body')?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-body no-padding"> 
					<div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-1">
						<p class="card-bulletin" style="position: relative;top: 20px;padding-left: 20px;padding-right: 20px;padding-bottom:15px;color: #fff;letter-spacing: 1px;">Menu :</p>
						<ul style="list-style-type: none;padding:  0; position: absolute; top: 15px;left: 100px;color: #fff;">
							<li class="pc-li-btn active-pc-menu" id="pc-cda-div" style="display: inline-block;padding: 5px 15px 5px 15px;border-radius: 5px;">Daily Activity</li>
							<li class="pc-li-btn" id="pc-ac-div" style="display: inline-block;padding: 5px 15px 5px 15px;border-radius: 5px;">Assign Checker</li>
							<li class="pc-li-btn" id="pc-adlg-div" style="display: inline-block;padding: 5px 15px 5px 15px;border-radius: 5px;">Add Daily Listing</li>
							<li class="pc-li-btn" id="pc-pr-div" style="display: inline-block;padding: 5px 15px 5px 15px;border-radius: 5px;">Affiliate Problem Report</li>
						</ul>
					</div>

					<div class="pc-content" style="padding-bottom: 10px;">
						<div class="pc-content-div pc-cda-div">
							<div class="form-group " style="width: 100%;">
								<div class="user-input-wrp">
									<br/>
									<input type="text" value='' class="inputText" id="pc-cda-search" onkeyup="this.setAttribute('value', this.value);" style="background-color: transparent; color: #6b6d70; padding-left: 10px;" />
									<span class="floating-label" style="color: #6b6d70 !important; font-size: 15px;">Search checker or activity</span>
									<i class="fa fa-search" style="position: absolute; right: 10px;"></i>
								</div>
							</div>

							<table class="" style="width: 100%;">
								<thead>
									<tr class="" style="color: #fff;background: linear-gradient(60deg, #004ea3, #0062cc);">
										<th class="pc-cda-table-h-sticky pc-th-class">Checker</th>
										<th class="pc-cda-table-h-sticky pc-th-class">Game ID</th>
										<th class="pc-cda-table-h-sticky pc-th-class">Game Name</th>
										<th class="pc-cda-table-h-sticky pc-th-class">Activity</th>
										<th class="pc-cda-table-h-sticky pc-th-class">Url</th>
										<th class="pc-cda-table-h-sticky pc-th-class">Date</th>
									</tr> 
								</thead>
								<tbody class="pc-cda-div-display">
									<!-- dynamic data here from database -->
								</tbody>
								<tfoot class="pc-cda-tfoot">
									<tr>
										<td colspan="6" style="padding-top: 20px;">
											<p style="text-align: center;">
												<span class="data-display-function pc-lmore-fucntion" style="cursor: pointer; border-radius:5px;background-color: #0062cc; color: #fff;padding: 10px;right: 5px;position: relative;"> 
													<i class="fa fa-spinner" aria-hidden="true"></i> Load More 
												</span> 
												<span class="data-display-function pc-dall-function" style="cursor: pointer; border-radius:5px;background-color: #0062cc; color: #fff;padding: 10px;left: 5px;position: relative;"> 
													<i class="fa fa-globe" aria-hidden="true"></i> Display All
												</span>
											</p>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="pc-content-div pc-ac-div" style="display: none;">
							<div class="form-group pull-right">
								<button class="btn btn-primary" data-toggle="modal" data-target="#pc-add-shift-modal" style="width: 200px;"><i class="fa fa-plus-square" aria-hidden="true"></i> &nbsp; Add shift</button>
							</div>

							<table class="" style="width: 100%;">
								<thead>
									<tr class="" style="color: #fff;background: linear-gradient(60deg, #004ea3, #0062cc);">
										<th class="pc-cda-table-h-sticky pc-th-class" style="padding: 10px;font-weight: normal !important;">Assign Checker</th>
										<th class="pc-cda-table-h-sticky pc-th-class" style="padding: 10px;font-weight: normal !important;">Week Day's</th>
										<th class="pc-cda-table-h-sticky pc-th-class" style="padding: 10px;font-weight: normal !important;">Sunday</th>
										<th class="pc-cda-table-h-sticky pc-th-class pc-th-class-wc" style="padding: 10px;font-weight: normal !important;text-align: center;">Action</th>
									</tr> 
								</thead>
								<tbody class="pc-ac-div-display">
									<!-- dynamic data here from database -->
								</tbody>
							</table>
						</div>
						<div class="pc-content-div pc-adlg-div" style="display: none;">
							<div class="form-group pull-right">
								<button class="btn btn-primary" data-toggle="modal" data-target="#price_check_tool_modal_add_game" style="width: 200px;"><i class="fa fa-plus-square" aria-hidden="true"></i> &nbsp; Add Games</button>
							</div>

							<table class="" style="width: 100%;">
								<thead>
									<tr class="" style="color: #fff;background: linear-gradient(60deg, #004ea3, #0062cc);">
										<th class="pc-cda-table-h-sticky pc-th-class" style="padding: 10px;font-weight: normal !important;">ID</th>
										<th class="pc-cda-table-h-sticky pc-th-class" style="padding: 10px;font-weight: normal !important;">Game Name</th>
										<th class="pc-cda-table-h-sticky pc-th-class" style="padding: 10px;font-weight: normal !important;">Release Date</th>
										<th class="pc-cda-table-h-sticky pc-th-class" style="padding: 10px;font-weight: normal !important;">Created By</th>
										<th class="pc-cda-table-h-sticky pc-th-class" style="padding: 10px;font-weight: normal !important;">Date Created</th>
										<th class="pc-cda-table-h-sticky pc-th-class pc-th-class-wc" style="padding: 10px;font-weight: normal !important;text-align: center;">Action</th>
									</tr> 
								</thead>
								<tbody class="pc-adlg-div-display">
									<!-- dynamic data here from database -->
								</tbody>
							</table>
						</div>
						<div class="pc-content-div pc-pr-div" style="display: none;">
							<div class="form-group pull-left">
								<div class="p-2 bg-danger text-white rounded text-center" style="width: 250px;">Today's Problem  &nbsp; : &nbsp; <b><span class="result-today"></span></b> </div>
							</div>

							<div class="form-group pull-right">
								<button class="btn btn-primary" data-toggle="modal" data-target="#add-wrong-aff-link-modal" style="width: 200px;"><i class="fa fa-plus-square" aria-hidden="true"></i> &nbsp; Add Wrong Affiliate</button>
							</div>

							<table class="" style="width: 100%;">
								<thead>
									<tr class="" style="color: #fff;background: linear-gradient(60deg, #004ea3, #0062cc);">
										<th class="pc-cda-table-h-sticky pc-th-class" style="padding: 10px;font-weight: normal !important;">Number of affiliate links problem</th>
										<th class="pc-cda-table-h-sticky pc-th-class" style="padding: 10px;font-weight: normal !important;">Date added</th>
										<th class="pc-cda-table-h-sticky pc-th-class pc-th-class-wc" style="padding: 10px;font-weight: normal !important;text-align: center;">Action</th>
									</tr> 
								</thead>
								<tbody class="pc-pr-div-display">
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
