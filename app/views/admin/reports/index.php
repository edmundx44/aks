<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>
	<script type="text/javascript">
		

		$(function (){
			// var base_url = window.location.origin+"/watcher/records.txt";
			// $.get(window.location.origin+"/watcher/records.txt", function(data) {
			// 	console.log(data)
			// }, 'text');

			// alert(base_url)
			// console.log(base_url);
			crProblemList()

			$('body').tooltip({
				selector: '.cr-action-li'
			});

			$('#crcac').on('hidden.bs.modal', function () {
				$('#'+$('.span-what-id').html()).removeClass('cr-tbody-tr-active');
				crProblemList()
			});

			$(document).on('click', '.cr-btn-cac', function(){
				globalRating = '';
				$(".site-data, .mfeed-data").empty();
				$('#crcac').modal('show');
				$('.cr-cac-site').html($(this).data('site'))
				$('.cr-tbody-tr').removeClass('cr-tbody-tr-active')
				$('#'+$(this).data('id')).addClass('cr-tbody-tr-active');
				$('.span-what-problem').html($(this).data('probs'));
				$('.span-what-id').html($(this).data('id'));
				$('.span-what-rating').html($(this).data('rating'));
				$('.span-what-reported').html($(this).data('reported'));
				$('.span-what-tblid').html($(this).data('tblid'));


				$(".cr-msite-btn").attr("href", $(this).data('url'))
				
				

				// var dataRequest =  {
				// 	action: 'cr-get-cac-data',
				// 	site: $(this).data('site'),
				// 	url: $(this).data('url'),
				// 	dataID: $(this).data('id')
				// }

				// AjaxCall(url+'reports', dataRequest).done(function(data) {
				// 	globalRating = data.site[0].rating;
				// 	var getStock = (data.site[0].dispo == 1)? 'In Stock':'Out of Stock';
				// 	var appendSite = '<p class="ms-data-price"><span><b>PRICE : </b></span><span>'+data.site[0].price+'</span></p>';
				// 		appendSite += '<p class="ms-data-stock"><span><b>STOCK : </b></span><span>'+getStock+'</span></p>';
				// 		appendSite += '<p class="ms-data-url"><span><b>URL : </b></span><span>'+data.site[0].buy_url+'</span></p>';
				// 		appendSite += '<p class="ms-data-stock"><span><b>RATING : </b></span><span>'+data.site[0].rating+'</span></p>';
						
				// 	var appendMfeed = '<p class="ms-data-price"><span><b>PRICE : </b></span><span>'+data.mfeed[0].price+'</span></p>';
				// 		appendMfeed += '<p class="ms-data-stock"><span><b>STOCK : </b></span><span>'+data.mfeed[0].stock+'</span></p>';
				// 		appendMfeed += '<p class="ms-data-url"><span><b>URL : </b></span><span>'+data.mfeed[0].url+'</span></p>';

				// 	$(".site-data").append(appendSite);
				// 	$(".mfeed-data").append(appendMfeed);

				// });
			});
			$(document).on('click', '.cr-tbody-td-1', function(){
				var changeReported = ($(this).data('reported') == 0)? 1 : 0;
				var dataRequest =  {
					action: 'cr-rtm',
					idToUpdate: $.trim($(this).data('tblid')),
					reportStatus: changeReported
				}
				AjaxCall(url+'reports', dataRequest).done(function(data) {

					
				}).always(_.debounce(function(){
					crProblemList()
				}), 200);
				
			});
			
			$(document).on('click', '.cr-cac-list-btn', function(){
				
				var changeRatings = ($('.span-what-rating').html() == 0)? 101 : 0;
				var changeReported = ($('.span-what-reported').html() == 0)? 1 : 0;
				// alert($('.cr-cac-site').html());
				// alert($('.span-what-tblid').html())
				
				switch($(this).attr('id')){
					case 'cr-rtm':

						var dataRequest =  {
							action: 'cr-rtm',
							idToUpdate: $.trim($('.span-what-tblid').html()),
							reportStatus: changeReported
						}
						$('.span-what-reported').html(changeReported)
					break;
					case 'cr-spdf':  
					break;
					case 'cr-pbf':
					break;
					case 'cr-cr':
						var dataRequest =  {
							action: 'cr-cr',
							site: $('.cr-cac-site').html(),
							idToUpdate: $.trim($('.span-what-id').html()),
							idToUpdateReport: $.trim($('.span-what-tblid').html()),
							changeRatings: changeRatings
						}
					break;
					case 'cr-ptz':
					break;
				}

				AjaxCall(url+'reports', dataRequest).done(function(data) {
				}).always(_.debounce(function(){
					crProblemList()
				}), 200);
				
			});
			

			$(document).on('click', '.cr-modal-show-list', function(){
				var changeRatings = ($('.span-what-rating').html() == 0)? 101 : 0;
				$('.cac-list-btn-rating').html(changeRatings);
				$('.cr-modal-cac-list').fadeToggle();
			});

			$(document).on('click', '#createReportBtn', function(){
				crProblemArr = [];
				$('#cr-url-txtbox').val('');
				$('.checkbox-site').attr('checked', false); // Unchecks All
				$('.checkbox-site').attr('disabled','disabled');
				$('.cr-select-problem-btn').html('Select Problem');
				$('#createReportModal').modal('show');
			});

			$(document).on('change', '#cr-url-txtbox', _.debounce(function(){
				crProblemArr = [];
				$('.checkbox-site').attr('checked', false); // Unchecks All

				if($(this).val() != ''){
					$('.checkbox-site').removeAttr('disabled');
				}else {	
					$('.checkbox-site').attr('disabled','disabled'); 
					$('.url-msg').empty();
				}

					var dataRequest =  {
						action: 'cr-checkurl',
						getUrl: $.trim($(this).val())
					}

					AjaxCall(url+'reports', dataRequest).done(function(data) {
						if(data.length >= 1) {
							var getSite = '';
							for(var i in data){
								if(getSite != data[i].merchantSite){
									var appendData = "<span>";
										appendData += "<i class='fa fa-circle' aria-hidden='true' style='font-size: 12px;'></i> Already reported on <b>'"+data[i].merchantSite+"'</b> <br>";
										appendData += "</span>";
										$('.url-msg').append(appendData);
										$('#'+data[i].merchantSite).prop('checked', true).attr('disabled','disabled');
										getSite = data[i].merchantSite;
								}

							}
						}
					});
				
			}, 200));


			$(document).on('click', '#cr-submit-btn', function(){
				var counter = 0;
				for(var i in crProblemArr) counter++;

				if($('.cr-select-problem-btn').html() != 'Select Problem' && counter != 0 ){
					var filterCrProbs = crProblemArr.filter(item => item);
					var crgetProblem = ($('.cr-select-problem-btn').html() == "Other's" && $('.cr-txtbox-problem').val() != '')? $('.cr-txtbox-problem').val() : $('.cr-select-problem-btn').html();
					
					var dataRequest =  {
						action: 'cr-submit-report',
						toInsert: filterCrProbs,
						getProblem: crgetProblem
					}
					AjaxCall(url+'reports', dataRequest).done(function(data) {
						$('#createReportModal').modal('hide');
						crProblemList();
					});
				}else{
					alert('Invalid entry, Please check it carefully.');
				}
			});
			
			$(document).on('click', '.checkbox-site', function(){
				if (this.checked) {
					var dataRequest =  {
						action: 'cr-site',
						getSite: $(this).attr('id'),
						getUrl: $.trim($('#cr-url-txtbox').val())
					}

					AjaxCall(url+'reports', dataRequest).done(function(data) {

						if((data[0].data).length == 0) {
							$('#'+data[0].site).attr('checked', false); // Unchecks it
							alert('NO DATA FOUND IN ' + data[0].site);
						}else{
							for(var i in data[0].data){
								crProblemArr.push({
									'merchantSite': data[0].site, 
									'merchantSqlID': data[0].data[i].id, 
									'merchantID': data[0].data[i].merchant, 
									'merchantNMID': data[0].data[i].normalised_name, 
									'merchantLink':  data[0].data[i].buy_url,
									'merchantRating':  data[0].data[i].rating
								});
							}
						}
					});

				}else{
					var toRemove = $(this).attr('id');
					for(var i in crProblemArr) {
						if(crProblemArr[i].merchantSite == toRemove) delete crProblemArr[i];
					}
				}
			});

			$(document).on('click', '.cr-select-problem-btn-dd', function(){
				$('.cr-select-problem-btn').html($(this).html());
				if($(this).html() == "Other's") {
					$('.cr-txtbox-problem-div').fadeIn();
				}else{
					$('.cr-txtbox-problem-div').fadeOut();
				}
			});

			$(document).on('click', function(event){    
				if(!$(event.target).is('.cr-modal-show-list, .cr-modal-cac-list-ul *')) {
					$('.cr-modal-cac-list').hide();
				}
			});		
			
			
		});

		function crProblemList(){
			$(".cr-tbody").empty();
			var dataRequest =  {
				action: 'cr-problem-list',
			}

			AjaxCall(url+'reports', dataRequest).done(function(data) {
				// console.log(data)
				for(var i in data){
						var getreport = (data[i].toMerchant == 0)? "": "reported-back";
						var getRating = (data[i].rating == 0)? "": "rating-101-back";

						var append = 	'<tr class="cr-tbody-tr '+getRating+'" id="'+data[i].merchantSqlID+'">';
							append +=	'<td class="cr-tbody-td-1 cr-tbody-td '+getreport+'" data-tblid="'+data[i].id+'" data-reported="'+data[i].toMerchant+'"  title="Click If already reported to merchant"><i class="fa fa-truck" aria-hidden="true"></i></td>';
							append +=	'<td class="cr-tbody-td-2 cr-tbody-td"><a href="'+ data[i].merchantLink +'" target="_blank">'+ data[i].merchantLink +'</a></td>';
							append +=	'<td class="cr-tbody-td-3 cr-tbody-td">'+ data[i].merchantSite +'</td>';
							append +=	'<td class="cr-tbody-td-4 cr-tbody-td">'+ data[i].problem +'</td>';
							append +=	'<td class="cr-tbody-td-5 cr-tbody-td">';
							append +=	'<ul class="cr-ul-action">';
							append += 	'<li class="cr-action-li cr-btn-cac" data-tblid="'+data[i].id+'" data-reported="'+data[i].toMerchant+'" data-rating="'+data[i].rating+'" data-probs="'+data[i].problem+'" data-id="'+data[i].merchantSqlID+'" data-site="'+data[i].merchantSite+'" data-url="'+data[i].merchantLink+'" data-toggle="tooltip" title="Check and compare"><i class="cr-action-btn fa fa-exchange" aria-hidden="true"></i></li>';
							append += 	'<li class="cr-action-li" data-toggle="tooltip" title="Set status Fixed"><i class="cr-action-btn fa fa-check-circle-o" aria-hidden="true"></i></li>';
							append += 	'<li class="cr-action-li" data-toggle="tooltip" title="Force status fixed, proxy problem only"><i class="cr-action-btn fa fa-check-circle" aria-hidden="true"></i></li>';
							append += 	'<li class="cr-action-li" data-toggle="tooltip" title="Small price Difference, set status fixed"><i class="cr-action-btn fa fa-gavel" aria-hidden="true"></i></li>';
							append += 	'<li class="cr-action-li" data-toggle="tooltip" title="Price to Zero"><i class="cr-action-btn fa fa-ban" aria-hidden="true"></i></li>';
							append += 	'<li class="cr-action-li" data-toggle="tooltip" title="Rating 101"><i class="cr-action-btn fa fa-level-down" aria-hidden="true"></i></li>';
							append +=	'</ul>';
							append += 	'</td>';
							append +=	'<td class="cr-tbody-td-6 cr-tbody-td">'+ data[i].date +'</td>';
							append +=	'</tr>';
					$(".cr-tbody").append(append);
				}
			});
		}

	</script>
	<style type="text/css">
		.cr-tbody-tr-active {
			background-color: #cccccc !important;
		}
		.rating-101-back {
			background-color: #ffa726;
			color: #fff;
		}

		.cr-tbody-tr{
			box-shadow: 0 1px 4px 0 rgb(0 0 0 / 40%);
			-webkit-transition: .1s ease-in-out;
			-moz-transition: .1s ease-in-out;
			-o-transition: .1s ease-in-out;
			transition: .1s ease-in-out;
		}
		.cr-tbody-tr:hover {
			/*transform: scale(1.02);*/
			background-color: #cccccc;
		}
		.cr-tbody-td {
			padding: 5px;
		}

		.reported-back {
			background-color: #66bb6a !important;
		}
		.cr-tbody-td-1 {
			width: 5%;
			text-align: center;
			cursor: pointer;
			box-shadow: 0 1px 4px 0 rgb(0 0 0 / 30%);
			background-color: #fff;
			color: #777;
		}
		.cr-tbody-td-1:hover > i{
			margin-top: 3px;
			font-size: 20px;
		}
		.cr-tbody-td-2 {
			width: 35%;
			word-break:break-all;
		}
		.cr-tbody-td-3 {
			width: 5%;
			text-align: center;
		}
		.cr-tbody-td-4 {
			width: 15%;
			text-align: center;
		}
		.cr-tbody-td-5 {
			width: 25%;
			text-align: center;
		}
		.cr-tbody-td-6 {
			width: 15%;
			text-align: center;
		}
		.cr-ul-action {
			list-style-type: none;
			padding: 0;
			margin: 0;
		}
		.cr-action-li {
			display: inline-block;cursor: pointer;
			width: 40px;
			border-radius: 5px;
			background-color: #007bff;
			color: #fff;
			height: 30px;
			margin: 5px 5px 5px 0;
		}
		.cr-action-li:hover {
			background-color: #0069d9 !important;
		}
		.cr-action-btn {
			top: 3px;
			position: relative;
		}
	</style>
<?php $this->end(); ?>
<?php $this->start('body')?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-body no-padding "> 
					<div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-1">
						<div style="text-align: right">
							<input type="button" name="" value="Create report" class="btn btn-primary" id="createReportBtn" style="left: -10px;margin-top: 10px; position: relative;">
						</div>
						<p style="position: absolute;top: 18px;left: 15px;color: #fff;letter-spacing: 1px;">PROBLEM LIST</p>
					</div>
						
					
					<div class="cr-list" style="padding-bottom: 15px;">
						<table class="" style="width: 100%;background-color: #fff;">
							<thead>
								<tr class="" style="letter-spacing: 2px;font-weight: 700;">
									<td class="" style="width: 5%; padding: 5px;background-color: #fff;"></td>
									<td class="" style="width: 35%;padding: 5px;">URL</td>
									<td class="" style="width: 5%;padding: 5px;text-align: center;">SITE</td>
									<td class="" style="width: 15%;padding: 5px;text-align: center;">PROBLEM</td>
									<td class="" style="width: 25%;padding: 5px;text-align: center;">ACTION</td>
									<td class="" style="width: 15%;padding: 5px;text-align: center;">Date Added</td>
								</tr>
							</thead>
							<tbody class="cr-tbody">
								
							</tbody>
						</table>
					</div>

					

				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->end()?>