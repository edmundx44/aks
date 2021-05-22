var onOpen = '';


		$(function (){
			var dateNow = d.getFullYear() + '-' + month + '-' + day;
			
			$("#datepickerReport").datepicker({ dateFormat: 'yy-mm-dd' }).val(dateNow);
			$("#datepickerComplete").datepicker({ dateFormat: 'yy-mm-dd' });
			crProblemList($( "#datepickerReport" ).val());


			// $(document).on('keypress',function(e) {
			//     if(onOpen == 1 && e.which == 13) {
			//         var counter = 0;
			// 		for(var i in crProblemArr) counter++;

			// 		if($('.cr-select-problem-btn').html() != 'Select Problem' && counter != 0 ){
			// 			var filterCrProbs = crProblemArr.filter(item => item);
			// 			var crgetProblem = ($('.cr-select-problem-btn').html() == "Other's" && $('.cr-txtbox-problem').val() != '')? $('.cr-txtbox-problem').val() : $('.cr-select-problem-btn').html();
						
			// 			var dataRequest =  {
			// 				action: 'cr-submit-report',
			// 				toInsert: filterCrProbs,
			// 				getProblem: crgetProblem
			// 			}
			// 			AjaxCall(url+'reports', dataRequest).done(function(data) {
			// 				$('#createReportModal').modal('hide');
			// 				crProblemList($( "#datepickerReport" ).val());
			// 			});
			// 		}else{
			// 			alert('Invalid entry, Please check it carefully.');
			// 		}
			//     }
			// });

			$(document).on('change', '#datepickerReport', function(){
				crProblemList($(this).val());
			});

			$('body').tooltip({
				selector: '.cr-action-li'
			});

			$('#crcac').on('hidden.bs.modal', function () {
				onOpen = '';
				$('#'+$('.span-what-id').html()).removeClass('cr-tbody-tr-active');
			});

			$(document).on('click', '.cr-btn-cac', function(){
				$(".site-data, .mfeed-data, .msite-data").empty();
				$('#crcac').modal('show');
				$('.cr-cac-site').html($(this).data('site'))
				$('.cr-tbody-tr').removeClass('cr-tbody-tr-active')
				$('#'+$(this).data('id')).addClass('cr-tbody-tr-active');
				$(".cr-msite-btn").attr("href", $(this).data('url'))
				$('.basic-loader-padding, .basic-loader').show();

				$('.span-what-problem').html($(this).data('probs'));
				$('.span-what-id').html($(this).data('id'));
				$('.span-what-rating').html($(this).data('rating'));
				$('.span-what-reported').html($(this).data('reported'));
				$('.span-what-tblid').html($(this).data('tblid'));
				$('.span-what-merchant-id').html($(this).data('merchantid'))
				$('.span-what-normalized-name').html($(this).data('normalizedname'))
				$('.span-what-link').html($(this).data('url'))
				$('.checker-span').html($(this).data('checker'))

				$('#crcac .cr-cac-tittle').addClass(returnSiteClass($(this).data('site')));

				var dataRequest =  {
					action: 'cr-get-cac-data',
					site: $(this).data('site'),
					url: $(this).data('url'),
					dataID: $(this).data('id')
				}

				AjaxCall(url+'reports', dataRequest).done(function(data) {
					console.log(data)
					// var getStock = (data.site[0].dispo == 1)? 'In Stock':'Out of Stock';
					// var appendSite = '<p class="ms-data-price"><span><b>PRICE : </b></span><span>'+data.site[0].price+'</span></p>';
					// 	appendSite += '<p class="ms-data-stock"><span><b>STOCK : </b></span><span>'+getStock+'</span></p>';
					// 	appendSite += '<p class="ms-data-url"><span><b>URL : </b></span><span><a href='+data.site[0].buy_url+' target="_blank">'+data.site[0].buy_url+'</a></span></p>';
					// 	appendSite += '<p class="ms-data-stock"><span><b>RATING : </b></span><span>'+data.site[0].rating+'</span></p>';
					// 	$(".span-what-site-price").html(data.site[0].price)
					// 	$(".span-what-site-stock").html(data.site[0].dispo)

					// if(data.mfeed.length != 0){
					// 	var appendMfeed = '<p class="ms-data-price"><span><b>PRICE : </b></span><span class="cac-get-feedprice">'+data.mfeed[0].price+'</span></p>';
					// 		appendMfeed += '<p class="ms-data-stock"><span><b>STOCK : </b></span><span class="cac-get-feedstock">'+data.mfeed[0].stock+'</span></p>';
					// 		appendMfeed += '<p class="ms-data-url"><span><b>URL : </b></span><span><a href='+data.mfeed[0].url+' target="_blank">'+data.mfeed[0].url+'</a></span></p>';

					// 	$(".span-what-mfeed-price").html(data.mfeed[0].price)
					// 	$(".span-what-mfeed-stock").html(data.mfeed[0].stock)
					// }else{
					// 	var appendMfeed = '<b><p class="nfof-feedback">NOT FOUND ON FEED</p></b>';
					// }

					// var getSiteStock = (data.msite.siteStock != '')? data.msite.siteStock : 'In stock';
					
					// var appendSiteData = '<p class="ms-data-price" style="margin-top: 8px;"><span><b>PRICE : </b></span><span class="merchant-site-price">'+data.msite.sitePrice+'</span></p>';
					// 	appendSiteData += '<p class="ms-data-stock"><span><b>STOCK : </b></span><span class="merchant-site-stock">'+ getSiteStock +'</span></p>';
					
					// $(".site-data").append(appendSite);
					// $(".mfeed-data").append(appendMfeed);
					// $(".msite-data").append(appendSiteData);

				}).always(function(){
					$('.basic-loader-padding, .basic-loader').hide();
				});
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
					crProblemList($( "#datepickerReport" ).val());
				}), 200);
				
			});
//removed report serction 
$(document).on('click', '#remove-report', function(){
	// alert($(this).data('tblid'));
	var dataRequest =  {
		action: 'cr-remove-report',
		idToRemove: $.trim($(this).data('tblid'))
	}
	AjaxCall(url+'reports', dataRequest).done(function(data) {
		crProblemList($( "#datepickerReport" ).val());
	});
});

// open-info section -----------------------------------------------------------------------------------
// $('#open-additional-info').modal('show');
$(document).on('click', '.open-info', function(){
	$('.disp-site').html($(this).data('merchantSite'));
	$('.disp-id').html($(this).data('merchantSqlID'));
	$('.disp-merchant').html($(this).data('gmerchantID'));
	$('.disp-nmid').html($(this).data('gmerchantNMID'));
	$('.disp-link').html($(this).data('gmerchantLink'));
	$('.disp-prob').html($(this).data('gproblem'));
	$('.disp-ons').html($(this).data('gsiteProbs'));
	$('.disp-onmf').html($(this).data('gfeedProbs'));
	$('.disp-onms').html($(this).data('gmsiteProbs'));
	$('.disp-cfeedback').html($(this).data('greportFeedback'));
	$('.disp-checker').html($(this).data('gchecker'));
	$('.disp-datecompleted').html($(this).data('gdate'));
 
	$('#open-additional-info').modal('show');
});

// button re-open section ------------------------------------------------------------------------------
			$(document).on('click', '.cr-reopen', function(){
				var	appendtoheader = 'Are you sure you want to reopen this report?';
				var	appendtobody = 	'';
				var appendtofooter = '<button data-csite="'+$(this).data('csite')+'" data-cmysqlid="'+$(this).data('cmysqlid')+'" data-cmid="'+$(this).data('cmid')+'" data-cmnm="'+$(this).data('cmnm')+'" data-cmlink="'+$(this).data('cmlink')+'" data-cproblem="'+$(this).data('cproblem')+'" data-crating="'+$(this).data('crating')+'" data-cid="'+$(this).data('cid')+'" type="button" class="btn btn-default" id="submit-reopen-report">Submit</button>';

				confirmationModal(appendtoheader,appendtobody,appendtofooter);

			});

			$(document).on('click', '#submit-reopen-report', function(){
				var dataRequest =  {
					action: 'cr-reopen-problem',
					getcsite: $(this).data('csite'),
					getccmysqlid: $(this).data('cmysqlid'),
					getcmid: $(this).data('cmid'),
					getcmnm: $(this).data('cmnm'),
					getcmlink: $(this).data('cmlink'),
					getcproblem: $(this).data('cproblem'),
					getcrating: $(this).data('crating'),
					getcid: $(this).data('cid')
				}
				AjaxCall(url+'reports', dataRequest).done(function(data) {
							
				}).always(_.debounce(function(){
					$('#report-modal-confirmation').modal('hide')
					displayCompleted();
					crProblemList($( "#datepickerReport" ).val());
				}), 200);
			});

// datepicker customize section ------------------------------------------------------------------------
			$(document).on('click', '#datepickerReport', function(){
				$('.span-all-report').show();
			});

			$(document).on('click', '.span-all-report', function(){
				$('#datepickerReport').val('');
				crProblemList('');
				$(this).hide();
			});



// tab button section ----------------------------------------------------------------------------------
			$(document).on('click', '.problem-lis-tab-btn', function(){
				switch($(this).attr('id')){
					case 'pltb-report':
						$('#pltb-report').removeClass('problem-lis-tab-btn-not-active');
						$('#pltb-completed').addClass('problem-lis-tab-btn-not-active');
						$('.pltb-completed, .hide-extra2').hide();
						$('.pltb-report, .hide-extra1').show();
						
					break;
					case 'pltb-completed':
						$('#pltb-completed').removeClass('problem-lis-tab-btn-not-active');
						$('#pltb-report').addClass('problem-lis-tab-btn-not-active');
						$('.pltb-report, .hide-extra1').hide();
						$('.pltb-completed, .hide-extra2').show();
						displayCompleted();
					break;
				}
			});

// fixed report section --------------------------------------------------------------------------------
			$(document).on('click', '.select-option-confirmation-modal-item', function(){
				$('.select-option-confirmation-modal-btn').html($(this).html());
			});

			$(document).on('click', '#btn-fixed', function(){
				switch($('.span-what-problem').html()){
					case 'Wrong price':
						var merchantsiteData = 'price';
						var feedVal = $('.cac-get-feedprice').html();
					break;
					case 'Wrong stock':
						var merchantsiteData = 'stock';
						var feedVal = $('.cac-get-feedstock').html();
					break;
					case 'Price to zero':
						var merchantsiteData = 'Price to zero';
					break;
					default:
						var merchantsiteData = '';
					break;
				}
				var captionFix = (merchantsiteData == 'Price to zero')? 'Price to zero' : 'Fixed';
				//var getVal = (merchantsiteData == 'Price to zero')? 'Price to zero' : $('.merchant-site-'+merchantsiteData).html();
				var feedVal = (merchantsiteData == 'Price to zero')? 'Price to zero' : feedVal;

				var	appendtoheader = 'ARE YOU SURE THIS IS FIXED?';
				var	appendtobody = 	'<div class="user-input-wrp">';
					appendtobody +=	'<br/>';
					appendtobody += '<input type="text" value="'+ feedVal +'" class="inputText merchantSiteData-txt" placeholder="Merchant site '+merchantsiteData+'"/>';
					appendtobody += '</div>';
					appendtobody += '<br>';
					appendtobody += '<div class="dropdown">';
					appendtobody += '<button class="btn btn-primary dropdown-toggle select-option-confirmation-modal-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;text-align: left;">Feedback</button>';
					appendtobody += '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%;">';
					appendtobody += '<a class="dropdown-item select-option-confirmation-modal-item" href="#">'+ captionFix +'</a>';
					appendtobody += '<a class="dropdown-item select-option-confirmation-modal-item" href="#">Small price difference</a>';
					appendtobody += '<a class="dropdown-item select-option-confirmation-modal-item" href="#">Proxy problem</a>';
					appendtobody += '<a class="dropdown-item select-option-confirmation-modal-item" href="#">Others</a>';
					appendtobody += '</div>';
					appendtobody += '</div>';
				var appendtofooter = '<button type="button" class="btn btn-default for-fixed-submit">Submit</button>';

				confirmationModal(appendtoheader,appendtobody,appendtofooter);
				
			});

			$(document).on('click', '.for-fixed-submit', function(){
				fixed($.trim($('.span-what-problem').html()), '');
			});

// check and compare section --------------------------------------------------------------------------
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

						var changeRatingss = ($('.cac-list-btn-rating').html() == 0)? 101 : 0;
						$('.cac-list-btn-rating').html(changeRatingss)
						$('.span-what-rating').html(changeRatings)
					break;
					case 'cr-ptz':
						fixed($.trim($('.span-what-problem').html()), 'Price to zero main');
					break;
				}

				AjaxCall(url+'reports', dataRequest).done(function(data) {
				}).always(_.debounce(function(){
					crProblemList($( "#datepickerReport" ).val());
				}), 200);
				
			});
			
			$(document).on('click', '#cr-cac-recheck-btn', function(){
				$('.span-probs').html('Still '+ $('.span-what-problem').html());
				$('.div-recheck').toggle();
			});
			
			$(document).on('click', '.div-recheck-ul-li', function(){
				$('.ols-display').empty();

				switch($('.span-what-problem').html()){
					case "Wrong price":
						var toAddProbsFeed = $('.cac-get-feedprice').html();
						var toAddProbsSite = $('.merchant-site-price').html();
						var feedback = 'Still wrong price'
					break;
					case "Wrong stock":
						var toAddProbsFeed = $('.cac-get-feedstock').html();
						var toAddProbsSite = $('.merchant-site-stock').html();
						var feedback = 'Still wrong stock'
					break;
					case "Price to zero":
					break;
					case "Other's":
					break;
				}

				var dataRequest =  {
					action: 'cr-recheck',
					toWhat: $(this).attr('id'),
					feedback: feedback,
					toAddProbsFeed: toAddProbsFeed,
					toAddProbsSite: toAddProbsSite,
					rID: $.trim($('.span-what-tblid').html()),
				}
				AjaxCall(url+'reports', dataRequest).done(function(data) {
					if(data != null) {
						for(var i in data){
							var	append =	'<tr class="">';
								append +=	'<td class="" style="padding: 5px 15px 5px 15px">'+ data[i].reportFeedback +'</td>';
								append +=	'<td class="" style="padding: 5px 15px 5px 15px">'+ data[i].feedProbs +'</td>';
								append +=	'<td class="" style="padding: 5px 15px 5px 15px">'+ data[i].siteProbs +'</td>';
								append +=	'<td class="" style="padding: 5px 15px 5px 15px">'+ data[i].checker +'</td>';
								append +=	'<td class="" style="padding: 5px 15px 5px 15px;font-weight:700;">'+ moment(data[i].date).format('MMMM Do YYYY, h:mm:ss a'); +'</td>';
								append +=	'</tr>';
							$(".ols-display").append(append);
						}

						$('#report-recheck-modal').modal('show');
					}else{
						$('.div-recheck').fadeOut();
					}
				});
			});

			$(document).on('click', '.checked-log-main', function(){
				$('.ols-display').empty();
				var dataRequest =  {
					action: 'cr-recheck',
					toWhat: 'r-ols',
					rID: $.trim($(this).data('tblid'))
				}
				AjaxCall(url+'reports', dataRequest).done(function(data) {
					for(var i in data){
						var	append =	'<tr class="">';
							append +=	'<td class="" style="padding: 5px 15px 5px 15px">'+ data[i].reportFeedback +'</td>';
							append +=	'<td class="" style="padding: 5px 15px 5px 15px">'+ data[i].feedProbs +'</td>';
							append +=	'<td class="" style="padding: 5px 15px 5px 15px">'+ data[i].siteProbs +'</td>';
							append +=	'<td class="" style="padding: 5px 15px 5px 15px">'+ data[i].checker +'</td>';
							append +=	'<td class="" style="padding: 5px 15px 5px 15px;font-weight:700;">'+ moment(data[i].date).format('MMMM Do YYYY, h:mm:ss a'); +'</td>';
							append +=	'</tr>';
						$(".ols-display").append(append);
					}

					$('#report-recheck-modal').modal('show');
				});
			});
			
			$(document).on('click', '.cr-modal-show-list', function(){
				var changeRatings = ($('.span-what-rating').html() == 0)? 101 : 0;
				$('.cac-list-btn-rating').html(changeRatings);
				$('.cr-modal-cac-list').fadeToggle();
			});

			$(document).on('click', '#createReportBtn', function(){
				crProblemArr = [];
				$('.url-msg').empty();
				$('.cr-url-txtbox-class').val('').attr('value','');
				$('.checkbox-site').attr('checked', false); // Unchecks All
				$('.checkbox-site').attr('disabled','disabled');
				$('.cr-select-problem-btn').html('Select Problem');
				$('.display-found-url').empty();
				$('#createReportModal').modal('show');
				onOpen = 1;
			});


			$(document).on('change input paste', '#cr-url-txtbox', function(event){
				if(event.type == 'input'){
					$('.checkbox-site').attr('checked', false); // Unchecks All

					if($(this).val() != '') $('.checkbox-site').removeAttr('disabled');
					else {	
						$('.checkbox-site').attr('disabled','disabled'); 
						$('.url-msg').empty();
					}

					textboxCheckUrl($.trim($(this).val()));
				}
			});

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
						crProblemList($( "#datepickerReport" ).val());
					});
				}else{
					alertMsg('Invalid entry, Please check it carefully.');
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
							alertMsg('NO DATA FOUND IN ' + data[0].site);
						}else{
							var appendTo = '<section class="sec-'+data[0].site+'">'
								appendTo +=	'<p style="position: relative;">Data found on '+data[0].site+'</p>'
								appendTo += '<ul style="margin: 0; position: relative; top: -15px;" class="display-found-url-ul-'+data[0].site+'"></ul>'
								appendTo += '</section>'
							$('.display-found-url').append(appendTo);

							for(var i in data[0].data){
								crProblemArr.push({
									'merchantSite': data[0].site, 
									'merchantSqlID': data[0].data[i].id, 
									'merchantID': data[0].data[i].merchant, 
									'merchantNMID': data[0].data[i].normalised_name, 
									'merchantLink':  data[0].data[i].buy_url,
									'merchantRating':  data[0].data[i].rating
								});
								$('.display-found-url-ul-'+data[0].site+'').append('<li>Merchant '+data[0].data[i].merchant+' , Game ID '+ data[0].data[i].normalised_name +'</li>');
							}
						}
					});

				}else{
					
					$('.sec-'+$(this).attr('id')).remove();
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

				if(!$(event.target).is('#cr-cac-recheck-btn, .cr-cac-recheck-btn-icon, .div-recheck, .div-recheck-ul *')){
					$('.div-recheck').hide();
				}

				if(!$(event.target).is('#datepickerReport, .span-all-report, #ui-datepicker-div *')){
					$('.span-all-report').hide();
				}

			});		
			
			
		});
		
		function crProblemList($date){
			$(".cr-tbody").empty();
			var dataRequest =  {
				action: 'cr-problem-list',
				date: $date
			}

			AjaxCall(url+'reports', dataRequest).done(function(data) {
				for(var i in data){
						var getreport = (data[i].toMerchant == 0)? "": "reported-back";
						var getRating = (data[i].rating == 0)? "": "rating-101-back";

						if($("#"+data[i].merchantSqlID).length == 0) {
							var append = 	'<tr class="cr-tbody-tr '+getRating+'" id="'+data[i].merchantSqlID+'">';
								append +=	'<td class="cr-tbody-td-1 cr-tbody-td '+getreport+'" data-tblid="'+data[i].id+'" data-reported="'+data[i].toMerchant+'"  title="Click If already reported to merchant"><i class="fas fa-truck"></i></td>';
								append +=	'<td class="cr-tbody-td-2 cr-tbody-td"><a href="'+ data[i].merchantLink +'" target="_blank">'+ html_decode(data[i].merchantLink) +'</a></td>';
								append +=	'<td class="cr-tbody-td-3 cr-tbody-td">'+ data[i].merchantSite +'</td>';
								append +=	'<td class="cr-tbody-td-4 cr-tbody-td">'+ data[i].problem +'</td>';
								append +=	'<td class="cr-tbody-td-5 cr-tbody-td">';
								append +=	'<ul class="cr-ul-action">';
								append += 	'<li class="cr-action-li cr-btn-cac" data-checker="'+data[i].checker+'" data-normalizedname="'+data[i].merchantNMID+'" data-merchantid="'+data[i].merchantID+'" data-tblid="'+data[i].id+'" data-reported="'+data[i].toMerchant+'" data-rating="'+data[i].rating+'" data-probs="'+data[i].problem+'" data-id="'+data[i].merchantSqlID+'" data-site="'+data[i].merchantSite+'" data-url="'+data[i].merchantLink+'" data-toggle="tooltip" title="Check and compare"><i class="cr-action-btn fas fa-exchange-alt"></i></li>';
								append += 	'<li class="cr-action-li checked-log-main" data-toggle="tooltip" title="Check log" data-tblid="'+data[i].id+'"><i class="cr-action-btn fas fa-check-circle"></i></li>';
								append += 	'<li class="cr-action-li" data-toggle="tooltip" title="remove report" id="remove-report" data-tblid="'+data[i].id+'"><i class="cr-action-btn fas fa-trash"></i></li>';
								// append += 	'<li class="cr-action-li" data-toggle="tooltip" title="Small price Difference, set status fixed"><i class="cr-action-btn fa fa-gavel" ></i></li>';
								// append += 	'<li class="cr-action-li" data-toggle="tooltip" title="Price to Zero"><i class="cr-action-btn fa fa-ban"></i></li>';
								// append += 	'<li class="cr-action-li" data-toggle="tooltip" title="Rating 101"><i class="cr-action-btn fa fa-level-down"></i></li>';
								// append +=	'</ul>';
								append += 	'</td>';
								append +=	'<td class="cr-tbody-td-6 cr-tbody-td">'+ data[i].date +'</td>';
								append +=	'</tr>';
							$(".cr-tbody").append(append);
						}
				}
			});
		}

		function displayCompleted(){
			$(".display-completed-data").empty();

			var dataRequest =  {
				action: 'cr-display-completed',
				// date: $date
			}
			AjaxCall(url+'reports', dataRequest).done(function(data) {
				for(var i in data){
					var appendData = '<tr class="display-completed" style="letter-spacing: 2px;font-weight: 700;box-shadow: 0 1px 4px 0 rgb(0 0 0 / 20%);">'
						// appendData += '<td class="" style="padding: 10px 15px 10px 15px;">'+data[i].merchantID+'</td>'
						// appendData += '<td class="" style="padding: 10px 15px 10px 0;">'+data[i].merchantSite+'</td>'
						// appendData += '<td class="" style="padding: 10px 15px 10px 0;">'+data[i].problem+'</td>'
						appendData += '<td class="" style="padding: 10px 15px 10px 0;text-align:center;">'+data[i].siteProbs+'</td>'
						appendData += '<td class="" style="padding: 10px 15px 10px 0;text-align:center;">'+data[i].feedProbs+'</td>'
						appendData += '<td class="" style="padding: 10px 15px 10px 0;text-align:center;">'+data[i].msiteProbs+'</td>'
						appendData += '<td class="" style="padding: 10px 15px 10px 0;">'+data[i].reportFeedback+'</td>'
						// appendData += '<td class="" style="padding: 10px 15px 10px 0;">'+data[i].checker+'</td>'
						appendData += '<td class="" style="padding: 10px 15px 10px 0;">'+data[i].date+'</td>'
						appendData += '<td class="" style="padding: 10px;text-align:center;">'
						appendData += '<i class="fas fa-info-circle open-info"  data-merchantSite="'+data[i].merchantSite+'" data-merchantSqlID="'+data[i].merchantSqlID+'" data-gmerchantID="'+data[i].merchantID+'" data-gmerchantNMID="'+data[i].merchantNMID+'" data-gmerchantLink="'+data[i].merchantLink+'" data-gproblem="'+data[i].problem+'" data-gsiteProbs="'+data[i].siteProbs+'" data-gfeedProbs="'+data[i].feedProbs+'" data-gmsiteProbs="'+data[i].msiteProbs+'" data-greportFeedback="'+data[i].reportFeedback+'" data-gchecker="'+data[i].checker+'" data-gdate="'+data[i].date+'" title="Open additional info." style="font-size:20px;position:relative; top:4px;cursor: pointer;"></i>'
						appendData += '<button data-cid="'+data[i].id+'" data-crating="'+data[i].rating+'" data-cproblem="'+data[i].problem+'" data-cmlink="'+data[i].merchantLink+'" data-cmnm="'+data[i].merchantNMID+'" data-cmid="'+data[i].merchantID+'" data-cmysqlid="'+data[i].merchantSqlID+'" data-csite="'+data[i].merchantSite+'" class="btn btn-primary cr-reopen" style="position: relative;left: 10px;" title="Reopen report">Reopen &nbsp; <i class="fas fa-pen-square" style="position:relative;top:2px;"></i></button>'
						appendData += '<a href='+data[i].merchantLink+' target="_blank"><i class="fas fa-external-link-alt" title="Open Link" style="font-size:20px;position:relative; top:4px; left: 20px;"></i></a>'
						appendData += '</td>'
						appendData += '</tr>'
					$(".display-completed-data").append(appendData);
				}


			});
		}

		function fixed($getProblem, $priceToZero){
			var getSite = $.trim($('.cr-cac-site').html());
				var getID = $.trim($('.span-what-id').html());
				var getMerchantId = $.trim($('.span-what-merchant-id').html());
				var getNormalizedName = $.trim($('.span-what-normalized-name').html());
				var getLink = $.trim($('.span-what-link').html());
				var getProblem = $getProblem; 

				switch(($priceToZero != '')? $priceToZero : getProblem){
					case 'Wrong price':
						var getSiteProblem = $.trim($('.span-what-site-price').html());
						var getFeedProblem = $.trim($('.span-what-mfeed-price').html());
					break;
					case 'Wrong stock':
						var getSiteProblem = ($.trim($('.span-what-site-stock').html()) == 0)? 'Out of stock': 'In stock';
						var getFeedProblem = $.trim($('.span-what-mfeed-stock').html());
						
					break;
					case 'Price to zero':
						var getSiteProblem = "Set Price to zero";
						var getFeedProblem = "NOT FOUND ON FEED";
						// var getFeedProblem = $('.nfof-feedback').html();
					break
					case 'Price to zero main':
						var getSiteProblem = "Set Price to zero";
						var getFeedProblem = "NOT FOUND ON FEED";
						// var getFeedProblem = $('.nfof-feedback').html();

					break;
					default:
						var getSiteProblem = '';
						var getFeedProblem = '';
					break;
				}

				var getmerchantSiteProbs = $.trim($('.merchantSiteData-txt').val()) + " " + $('.merchant-site-stock').html();
				var getRating = $.trim($('.span-what-rating').html()); 
				if($priceToZero != '') {
					var getreportFeedback = 'Price to zero';
				}else{
					var getreportFeedback = ($('.select-option-confirmation-modal-btn').html() != 'Feedback')? $('.select-option-confirmation-modal-btn').html() : '';
				}
				var getReportID = $.trim($('.span-what-tblid').html()); // to remove on tbl report
				var mfeedPrice = $.trim($('.span-what-mfeed-price').html());
				var mfeedStock = $.trim($('.span-what-mfeed-stock').html());
			

				var dataRequest =  {
					action: 'cr-fixed-problem',
					getSite: getSite,
					getID: getID,
					getMerchantId: getMerchantId,
					getNormalizedName: getNormalizedName,
					getLink: getLink,
					getProblem: getProblem,
					getSiteProblem: getSiteProblem,
					getFeedProblem: getFeedProblem,
					getmerchantSiteProbs: getmerchantSiteProbs,
					getRating: getRating,
					getreportFeedback: getreportFeedback,
					idToUpdateReport: getReportID,
					mfeedPrice: mfeedPrice,
					mfeedStock: mfeedStock
				}

				AjaxCall(url+'reports', dataRequest).done(function(data) {
					
				}).always(_.debounce(function(){
					$('#report-modal-confirmation, #crcac').modal('hide')
					crProblemList($( "#datepickerReport" ).val());
				}), 200);
		}

function textboxCheckUrl($url){
	var dataRequest =  {
		action: 'cr-checkurl',
			getUrl: $url
		}

		AjaxCall(url+'reports', dataRequest).done(function(data) {
			if(data.length >= 1) {
				var getSite = '';
				for(var i in data){
					if(getSite != data[i].merchantSite){
						if($("#span"+data[i].merchantSqlID).length == 0) {
							var appendData = "<span id='span"+data[i].merchantSqlID+"' >";
								appendData += "<i class='fas fa-circle' style='font-size: 12px;'></i> Already reported on <b>'"+data[i].merchantSite+"'</b> <br>";
								appendData += "</span>";
								getSite = data[i].merchantSite;

							$('.url-msg').append(appendData);
							$('#'+data[i].merchantSite).prop('checked', true).attr('disabled','disabled');
						}
					}
				}
			}
		});
}