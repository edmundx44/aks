var setOffset = '0',
			setTotal = '';

		$(function() {
			setActiveTab(getUrlParameter('tab'));

// Suspicious Double link section ----------------------------------------------

			$(document).on('click', '.dl-sl-displayall-btn', function(){
				var getSite = ($('.dl-dd-site-span').html() == 'Select Site')? 'AKS' : $('.dl-dd-site-span').html();
				var getAllSum = parseInt(setTotal) - parseInt(setOffset);
				displaySuspiciousDouble($('.sd-select-store-name').data('getstoreid'), setOffset, getAllSum, getSite);
				console.log(setOffset + " " + setTotal);
			});

			$(document).on('click', '.dl-sl-loadmore-btn', function(){
				var getSite = ($('.dl-dd-site-span').html() == 'Select Site')? 'AKS' : $('.dl-dd-site-span').html();
				displaySuspiciousDouble($('.sd-select-store-name').data('getstoreid'), setOffset, 499, getSite);
			});

			$(document).on('input', '.sd-select-store-name', function(){
				setOffset = '0';
				setTotal = '';
				$('.sdl-total-result').html('0');
				$('.display-suspicious-double-div').empty();
				var getSite = ($('.dl-dd-site-span').html() == 'Select Site')? 'AKS' : $('.dl-dd-site-span').html();

				if(CheckListed($(this).val()) == true){
					if($(this).val() != '') {
						$(this).data('getstoreid', $('#stores-data [value="' + $(this).val() + '"]').data('storeid'));
						displaySuspiciousDouble($('#stores-data [value="' + $(this).val() + '"]').data('storeid'), '', 499, getSite);
						displaySuspiciousDoubleTotal($('#stores-data [value="' + $(this).val() + '"]').data('storeid'), getSite);
					}else{
						$(this).data('getstoreid', '');
						displaySuspiciousDouble('', '', 499, getSite);
						displaySuspiciousDoubleTotal('', getSite);
					}
				}else{
					$(this).data('getstoreid', '');
					displaySuspiciousDouble($(this).val(), '', 499, getSite);
					displaySuspiciousDoubleTotal($(this).val(), getSite);
				}
			});

// real double link section -----------------------------------------------------
			$(document).on('click', '.tr-body-display-data', function(){
				// if ($(this).find(":checkbox:eq(0)").is(':checked')) {
				// 	$(this).find(":checkbox:eq(0)").prop( "checked", false );
				// }else{
				// 	$(this).find(":checkbox:eq(0)").prop( "checked", true );
				// }
			});

			$(document).on('click', '#rd-delete-selected', function(){
				var id=[];
				$('.rd-delete-checkbox:checked').each(function(i){
					id[i] = $(this).data('cproductid');
				});

				if(id.length === 0) alertMsg('kindly select atleast one data.', "bg-danger");
				else deleteRealDoubleLinks(id, 'bySelected');
			});

			$(document).on('click', '.dl-delete-real-double', function(){
				deleteRealDoubleLinks($(this).data('productid'), 'byOne')
			});

			$(document).on('click', '.dl-dd-site-di', function(){
				$('.dl-dd-site-span').html($(this).html());

				switch(getUrlParameter('tab')){
					case 'suspicious-double':
						setOffset = '0';
						setTotal = '';
						$('.sdl-total-result').html('0');
						$('.display-suspicious-double-div').empty();

						displaySuspiciousDouble($('.sd-select-store-name').data('getstoreid'), '', 499, $(this).html());
						displaySuspiciousDoubleTotal($('.sd-select-store-name').data('getstoreid'), $(this).html());
					break;
					default:
						displayRealDoubleLinks($(this).html());
					break;

				}
			});
			
// double link menu section -----------------------------------------------------
			$(document).on('click', '.dl-li-btn', function(){
				var getSite = ($('.dl-dd-site-span').html() == 'Select Site')? 'AKS' : $('.dl-dd-site-span').html();

				$('.dl-li-btn').removeClass('active-dl-menu');
				$('#'+$(this).attr('id')).addClass('active-dl-menu');
				$('.dl-content-div').hide();
				$('.'+$(this).attr('id')).show();

				switch($(this).attr('id')){
					case 'dl-real-double-div':
						$('.dl-dd-site').addClass('d-xl-block');

						var param = '';

						displayRealDoubleLinks(getSite);
					break;
					case 'dl-suspicious-double-div':
						$('.display-suspicious-double-div').empty();
						$('.dl-dd-site').addClass('d-xl-block');

						var param = '?tab=suspicious-double';

						displayStore();
						displaySuspiciousDouble($('.sd-select-store-name').data('getstoreid'), '', 499, getSite);
						displaySuspiciousDoubleTotal($('.sd-select-store-name').data('getstoreid'), getSite);
					break;
					case 'dl-metacritics-double-div':
						$('.dl-dd-site').removeClass('d-xl-block');

						var param = '?tab=metacritics-double';
					break;
				}
				var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + param;
				window.history.pushState({ path: newurl }, '', newurl);

			});

			
		}); // end document ready function

		function displaySuspiciousDoubleTotal($merchantid, $site){
			var getSite = ($('.dl-dd-site-span').html() == 'Select Site')? 'AKS' : $('.dl-dd-site-span').html();

			var dataRequest =  { 
				action: 'display-suspicious-double-total',
				getMerchant: $merchantid,
				site : getSite,
			}
			AjaxCall(url, dataRequest).done(function(data){
				setTotal = $.trim(data);
				$('.sdl-total-result').html($.trim(data));
			}).always(function(){
				var hideIfMax = (setOffset == setTotal)? $('.dl-sl-div').hide() : $('.dl-sl-div').show();
			});
		}

		function displaySuspiciousDouble($merchantid, $offset, $limit, $site){
			var getSite = ($('.dl-dd-site-span').html() == 'Select Site')? 'AKS' : $('.dl-dd-site-span').html();
			
			var dataRequest =  { 
				action: 'display-suspicious-double',
				getMerchant: $merchantid,
				getOffset: $offset,
				getlimit: $limit,
				site: $site
			}

			AjaxCall(url, dataRequest).done(function(data){
				for(var i in data){
					var getCreated = (data[i].created_by == '')? 'Created by "Unknown" in '+getSite+'' : 'Created by "'+data[i].created_by+'" in '+getSite+'';
					var	append =	'<div style="padding: 10px;box-shadow: 0 1px 4px 0 rgb(0 0 0 / 24%);margin: 0 0 15px 0;">';
						append +=	'	<p style="padding: 5px 0 5px 0;margin: 0;font-size: 13px;">'+ moment(data[i].created_time).format('MMMM Do YYYY, h:mm:ss a'); +'</p>';
						append +=	'	<p style="padding: 5px 0 5px 0;margin: 0;font-size: 13px;">'+getCreated+'</p>';
						append +=	'	<p style="padding: 5px 0 5px 0;margin: 0;font-size: 13px;"><a href="'+data[i].buy_url+'">'+data[i].buy_url+'</a></p>';
						append +=	'	<p style="padding: 5px 0 5px 0;margin: 0;font-size: 13px;">'+data[i].search_name+'</p>';
						append +=	'	<p style="padding: 5px 0 5px 0;margin: 0;font-size: 13px;"><span>PRICE : <span>'+data[i].price+'</span></span>  &nbsp; <span>REGION : <span>'+data[i].region+'</span></span>  &nbsp; <span>EDITION : <span>'+data[i].edition+'</span></span></p>';
						append +=	'</div>';
						$('.display-suspicious-double-div').append(append);								
				}

				setOffset = parseInt(setOffset) + parseInt(data.length);
			}).always(function(){
				var hideIfMax = (setOffset == setTotal)? $('.dl-sl-div').hide() : $('.dl-sl-div').show();
			});
		}

		function displayRealDoubleLinks($site){
			$('#dl-real-double-display-content-div').empty()
			var dataRequest =  { 
				action: 'display-real-double-link',
				site : $site
			}

			AjaxCall(url, dataRequest).done(function(data){
				$('.total-result').html(data.length)
				var counter = 1;

				for(var i in data){
					var backColor = (counter % 2 == 0)? 'tr-background-even' : '';
					var getStock = (data[i].dispo == 1)? 'In stock' : 'Out of Stock';

					var	append =	'<tr class="'+backColor+' tr-body-display-data">';
						append +=	'	<td class="hide-on-smmd" style="padding: 10px;">'+ data[i].buy_url +'</td>';
						append +=	'	<td style="padding: 10px;">'+ data[i].price +'</td>';
						append +=	'	<td style="padding: 10px;">'+ getStock +'</td>';
						append +=	'	<td style="padding: 10px;text-align:center;">'
						append +=	'		<button class="btn btn-primary">Copy link</button> &nbsp;';
						append +=	'		<button class="btn btn-warning dl-delete-real-double text-white" data-productid="'+data[i].id+'">Delete</button> &nbsp;';
						append +=	'		<input type="checkbox" class="rd-delete-checkbox" data-cproductid="'+data[i].id+'">';
						append +=	'	</td>';
						append +=	'</tr>';
						append +=	'<tr class="'+backColor+' sub-tr-head">';
						append +=	'	<td colspan="3">';
						append +=	'		<div style="padding: 0 10px 10px 10px;word-break: break-all;">';
						append +=	'			<p>Activity : <span>'+ data[i].buy_url +'</span></p>';
						append +=	'		</div>';
						append +=	'	</td>';
						append +=	'</tr>';
					$("#dl-real-double-display-content-div").append(append);
					counter++;
				}
			}).always(function(){});
		}

		function displayStore(){
			$('.stores-data-class').empty();

			var dataRequest =  { 
				action: 'displayStore',
			}

			AjaxCall(url, dataRequest).done(function(data){
				for(var i in data) {
					$('.stores-data-class').append('<option data-storeid="'+data[i].vols_id+'" value="'+data[i].vols_nom+'" >');
				}
			}).always(function(){});
		}

		function deleteRealDoubleLinks($id, $byWhat){
			var getSite = ($('.dl-dd-site-span').html() == 'Select Site')? 'AKS' : $('.dl-dd-site-span').html();
			var dataRequest =  { 
				action: 'delete-real-double-link',
				site : getSite,
				getId : $id,
				getWhat: $byWhat
			}
			AjaxCall(url, dataRequest).done(function(){
				displayRealDoubleLinks(getSite);
			}).always(function(){});
		}

		function CheckListed( txtSearch  ) {
			var objList = document.getElementById("stores-data")  ;
			for (var i = 0; i < objList.options.length; i++) {
				if ( objList.options[i].value.trim().toUpperCase() == txtSearch.trim().toUpperCase() ) {
					return true;
				}
			}
			return false ; // text does not matched ;
		}

		function setActiveTab($param){
			var getSite = ($('.dl-dd-site-span').html() == 'Select Site')? 'AKS' : $('.dl-dd-site-span').html();
			$('.dl-li-btn').removeClass('active-dl-menu');
			$('.dl-content-div').hide();

			switch($param){
				case 'suspicious-double':
					$('.display-suspicious-double-div').empty();
					$('.dl-dd-site').addClass('d-xl-block');

					var divClassID = 'dl-suspicious-double-div';

					displayStore();
					displaySuspiciousDouble('', '', 499, getSite);
					displaySuspiciousDoubleTotal('', getSite);
				break;
				case 'metacritics-double':
					$('.dl-dd-site').removeClass('d-xl-block');
					var divClassID = 'dl-metacritics-double-div';
					
				break;
				default:
					$('.dl-dd-site').addClass('d-xl-block');

					var divClassID = 'dl-real-double-div';
					
					displayRealDoubleLinks('AKS');
				break;
			}

			$('.'+divClassID).show();
			$('#'+divClassID).addClass('active-dl-menu');
		}