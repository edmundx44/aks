<?php $this->setSiteTitle("Double Links"); ?>
<?php $this->start('head'); ?>
	<script>
		$(function() {
			setActiveTab(getUrlParameter('tab'));
			

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
				})

				if(id.length === 0) {
			   		alertMsg('kindly select atleast one data.');
			    }else{
			    	deleteRealDoubleLinks(id, 'bySelected');
				}
			});

			$(document).on('click', '.dl-delete-real-double', function(){
				deleteRealDoubleLinks($(this).data('productid'), 'byOne')
			});

			$(document).on('click', '.dl-dd-site-di', function(){
				$('.dl-dd-site-span').html($(this).html());
				displayRealDoubleLinks($(this).html());
			});
			
// double link menu section -----------------------------------------------------
			$(document).on('click', '.dl-li-btn', function(){
				$('.dl-li-btn').removeClass('active-dl-menu');
				$('#'+$(this).attr('id')).addClass('active-dl-menu');
				$('.dl-content-div').hide();
				$('.'+$(this).attr('id')).show();

				switch($(this).attr('id')){
					case 'dl-real-double-div':
						var param = '';
						$('.dl-dd-site').addClass('d-xl-block');
					break;
					case 'dl-suspicious-double-div':
						var param = '?tab=suspicious-double';
						$('.dl-dd-site').addClass('d-xl-block');
					break;
					case 'dl-metacritics-double-div':
						var param = '?tab=metacritics-double';
						$('.dl-dd-site').removeClass('d-xl-block');
					break;
				}
				var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + param;
				window.history.pushState({ path: newurl }, '', newurl);
			});

			
		}); // end document ready function

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

		function setActiveTab($param){
			$('.dl-li-btn').removeClass('active-dl-menu');
			$('.dl-content-div').hide();

			switch($param){
				case 'suspicious-double':
					var divClassID = 'dl-suspicious-double-div';
					$('.dl-dd-site').addClass('d-xl-block');
				break;
				case 'metacritics-double':
					var divClassID = 'dl-metacritics-double-div';
					$('.dl-dd-site').removeClass('d-xl-block');
				break;
				default:
					var divClassID = 'dl-real-double-div';
					$('.dl-dd-site').addClass('d-xl-block');
					displayRealDoubleLinks('AKS');
				break;
			}

			$('.'+divClassID).show();
			$('#'+divClassID).addClass('active-dl-menu');
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

	</script>
	<style>
		.sub-tr-head {
			display: none;
		}
		.dl-card-bulitin {
			position: relative;
			top: 20px;
			padding-left: 20px;
			padding-right: 20px;
			padding-bottom:15px;
			color: #fff;
			letter-spacing: 2px;
			font-weight: 400;
		}
		.dl-cb-ul-menu {
			list-style-type: none;
			padding:  0; 
			position: absolute; 
			top: 15px;
			left: 100px;
			color: #fff;
		}
		.dl-li-btn {
			cursor: pointer;
			display: inline-block;
			padding: 5px 15px 5px 15px;
			border-radius: 5px;
		}
		.active-dl-menu {
			background-color: rgba(255, 255, 255, .2);
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
							<p class="card-bulletin dl-card-bulitin">MENU :</p>
							<div class="d-xl-none" style="position: absolute; top: 20px;right: 20px; color: #fff;cursor: pointer;font-size: 18px;"><i class="fal fa-bars"></i></div>

							<div class="dropdown d-xl-block dl-dd-site" style="display: none;position: absolute;top: 12.5px;right: 12.5px;">
								<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" style="width: 150px;">
									<span class="float-left dl-dd-site-span">Select Site</span>
								</button>
								<div class="dropdown-menu">
									<span class="dropdown-item dl-dd-site-di" data-whatni="aks">AKS</span>
									<span class="dropdown-item dl-dd-site-di" data-whatni="cdd">CDD</span>
									<span class="dropdown-item dl-dd-site-di" data-whatni="brex">BREX</span>
								</div>
	                        </div>

							<ul class="dl-cb-ul-menu d-xl-block" style="display: none;">
								<li class="dl-li-btn active-dl-menu" id="dl-real-double-div">Real Double</li>
								<li class="dl-li-btn" id="dl-suspicious-double-div">Suspicious Double</li>
								<li class="dl-li-btn" id="dl-metacritics-double-div">Metacritics Double</li>
							</ul>
						</div>
					</div>
					<div class="dl-content" style="padding-bottom: 10px;">
						<div class="dl-content-div dl-real-double-div">
							<div style="padding: 0 0 35px 0;">
								<div class="bg-warning text-white rounded text-center float-left" style="width: 200px;padding: 7px;">Total Result's  &nbsp; : &nbsp; <b><span class="total-result">0</span></b> </div>
								<button class="btn btn-warning float-right text-white" id="rd-delete-selected" style="width: 200px;padding: 7px;">Delete Selected</button>
							</div>

							<table class="col-12" style="margin: 20px 0 0 0;">
                                <thead>
                                    <tr class="" style="color: #fff;background-color: #007bff;">
                                        <th class="hide-on-smmd" style="padding: 10px;width: 45%;">Link</th>
                                        <th class="" style="padding: 10px;width: 10%;">Price</th>
                                        <th class="" style="padding: 10px;width: 10%;;">Stock</th>
                                        <th class="" style="padding: 10px;width: 35%;text-align:center;">Action</th>
                                    </tr> 
                                </thead>
                                <tbody id="dl-real-double-display-content-div">
                                    <!-- dynamic data here from database -->
                                </tbody>
                            </table>
						</div>
						<div class="dl-content-div dl-suspicious-double-div" style="display: none;">
							Suspicious Double
						</div>
						<div class="dl-content-div dl-metacritics-double-div" style="display: none;">
							Metacritics Double
						</div>
					</div>	
				</div>	
			</div>
		</div>
	</div>
<?php $this->end()?>
