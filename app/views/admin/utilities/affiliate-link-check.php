<?php
	$url_check = (isset($_GET['url_check']) AND $_GET['url_check'] == 'buy_url_raw')? $_GET['url_check']: 'buy_url';
	$text = ($url_check == 'buy_url_raw') ? 'Buy Url Raw' : 'Buy Url';
?>

<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
	<link rel="stylesheet" href="<?=PROOT?>vendors/css/utilities-page.css" media="screen" title="no title" charset="utf-8">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>

<script type="text/javascript">
	let $url_check = '<?= $url_check ?>';
	var $url = url+'utilities/affiliateCheck';	

	$(function(){
		//rendered on first load
		$('.dropdown-div').html(OptionSite(inputsSite,'opt-site-alc','slc-options','custom-bkgd')); //OptionSite na a sa custom.js

		if(sessionStorageCheck()){
			$('.change-site').text('LOADING...');
			var object = JSON.parse(getStorage('sessionStorage','OptionSite'));
			if(object != null){
				site = returnSite(object.site);
				if(site != 'invalid'){
					_ajaxCall($url,"POST","ajaxAffiliateLinkCheck",{'site':site}).done(function(data){
						affiliateLinkCheck(data)
					});
				}else{ if(removedKeyNormal('sessionStorage','OptionSite')) console.log("Item has been removed") } //remove key if invalid site
			}else{
				console.log('NO VALUE DEFAULT IS AKS');
				_ajaxCall($url,"POST","ajaxAffiliateLinkCheck",{'site':inputsSite[0].site}).done(function(data){
					affiliateLinkCheck(data)
				});
			}
		}		
		//FOR DROP DOWN SELECT ANIMATION // na na ni sa index.php sa dashboards
		$('.dropdown-div').click(function () {
			$(this).find('.dropdown-menu').slideToggle(200);
		});
		$('.dropdown-div').focusout(function () {
			$(this).find('.dropdown-menu').slideUp(200);
		});

		$(document).on('click', '.opt-site-alc', function(){
			$('.dropdown-div').html(OptionSite(inputsSite,'opt-site-alc','slc-options','custom-bkgd')); //OptionSite na a sa custom.js
			$('.change-site').text('LOADING...');
			var indexInput = $(this).parent().prevObject.index(); //get the index of li
			if($(this).parent()[0].childNodes.length == 3 ){
				site = (indexInput == 0 ) ? inputsSite[0].site : (indexInput == 1 ) ? inputsSite[1].site : (indexInput == 2 ) ? inputsSite[2].site : '';
				var $data = { 'site': site, 'path': $url }
				if(sessionStorageCheck()){ setStorage('sessionStorage','OptionSite',JSON.stringify($data)) } //store
				_ajaxCall($url,"POST","ajaxAffiliateLinkCheck",{'site':site}).done(function(data){
					affiliateLinkCheck(data)
				});
	
			}else{ window.location.reload(); }
		});
		//filtered errors
		$(document).on('click', '#filterd-btn', function(){
			$(".alert-success-v2, .no-aff-link, .alert-warning-v2").show(); //show all first
			if($(this).val() == "Show Errors")
				$(this).val($(this).attr('data-old-val'));
			else
				$(this).val("Show Errors");
			
			if($(".alert-success-v2").attr("data-show") == "show" && $(".no-aff-link-v2").attr("data-show") == "show"){
				$(".alert-success-v2, .no-aff-link-v2").removeAttr("data-show");
				$(".alert-success-v2, .no-aff-link-v2").attr("data-show","hide");
				$(".alert-success-v2, .no-aff-link-v2").hide();
			}else{
				$(".alert-success-v2, .alert-warning-v2").removeAttr("data-show");
				$(".alert-success-v2, .no-aff-link-v2").attr("data-show","show");
				$(".alert-success-v2, .no-aff-link-v2").show();
			}
		});
		//search 
		$(document).on('keyup','.input-site',function(e) {
			var typo = $(this).val();  //or var value = $(this).val().toLowerCase(); // in if $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			//for earch the div that having names class
			$('.search .store .names').each(function(){ 
	         	var $this = $(this);//console.log($this.text());
	         	//console.log($(this).text().search(new RegExp(typo, "i")) < 0) //"i" to perform case-insensitive //returns true if find or false if not
	         	if($(this).text().search(new RegExp(typo, "i")) < 0){
	         		$this.closest('div.store').fadeOut(500);}
	        	else 
	        		$this.closest('div.store').fadeIn(500);
	    	});
        });

		//Display EDIT affiliate
		$(document).on('click', '#edit-aff-link-modal', function(){
			//lert($(this).attr('data-withAff-merId'));
			var $modalId = $(this).attr('data-withAff-merId');
			$.ajax({
				url: '<?=PROOT?>utilities/affiliateLinkCheck',
	            method:'POST',
	            data:{ action: 'ajaxAffiliateLinkIdRequest',
	                ajaxRequestId : $modalId,
	            },
	            success:function(data){
	            	$("#aff-link-merchant-idv2").val(data[0].merchant_id);
	                $("#aff-link-namev2").val(data[0].name);
	                $("#aff-link-aksv2").val(data[0].aks_affiliate_link);
	                $("#aff-link-cddv2").val(data[0].cdd_affiliate_link);
	                $("#aff-link-brexitgbpv2").val(data[0].brexit_affiliate_link);

	            }
			});
			$('#affiliate-link-edit-modal').modal('hide'); //hide for now
		});


		//Confirmation save affiliate
		$(document).on('click', '#btn-affiliate-edit-save', function(){
				
			var $modalId = $('#aff-link-merchant-idv2').val();
	        var $affName = $("#aff-link-namev2").val();
	        var $affAksv2 = $("#aff-link-aksv2").val();
	        var $affCddv2 = $("#aff-link-cddv2").val();
	        var $affBrexitgbpv2 = $("#aff-link-brexitgbpv2").val();
	        var $currentSite = $('.select-text-aflc').attr('site');

			$.ajax({
				url: '<?=PROOT?>utilities/affiliateLinkCheck',
	            method:'POST',
	            data:{ action: 'ajaxAffiliateEditRequest',
	                ajaxRequestId : $modalId,
	                ajaxRequestName : $affName,
	                ajaxRequestAks : $affAksv2,
	                ajaxRequestCdd : $affCddv2,
	                ajaxRequestBrexitgbp : $affBrexitgbpv2,
	                ajaxRequestsite : $currentSite,
	            },
	            success:function(data){
	            	console.log(data);
	            	var resultData = data.success.data;
	            	var resultsite = data.success.site;
	            	if(resultData.match(/^Successfully/))
	                {
	                	alert(resultData)
	                	//$('#alert-modal-popup').modal('show');
	                	//$('.eMessage').text(resultData);

	                	$('#affiliate-link-edit-modal').modal('hide');
	                    getAffiliateLinkCheck(resultsite);
	                }else{
	                	//$('#alert-modal-popup').modal('show');
	                	//$('.eMessage').text(resultData);
	                	alert(resultData)
	            		$('#affiliate-link-edit-modal').modal('hide');
	                	getAffiliateLinkCheck(resultsite);
	                }

	            }
			});
		});

		//Display ADD affiliate
		$(document).on('click', '.btn-add-afflinkv2', function(){
	        var getId = $(this).attr('data-noAff-merId');
	        var getName = $(this).attr('data-noAff-merName');
	             
	        $("#aff-link-merchant-idv2-add").val(getId);
	        $("#aff-link-namev2-add").val(getName);
	        $('#affiliate-link-add-modal').modal('hide'); //hide for now
	    });

    	//Confirmation ADD affiliate
		$(document).on('click', '#btn-affiliate-add-save', function(){
			var btn = document. getElementById("edit-aff-link-modal"). disabled = true;
       		if(!btn){
		        var $modalIdAdd = $("#aff-link-merchant-idv2-add").val();
		        var $affNameAdd = $("#aff-link-namev2-add").val();
		        var $affAksv2Add =  $("#aff-link-aksv2-add").val();
		        var $affCddv2Add =  $("#aff-link-cddv2-add").val();
		        var $affBrexitgbpv2Add =  $("#aff-link-brexitgbpv2-add").val();

		        $.ajax ({  
		            url: "<?=PROOT?>utilities/affiliateLinkCheck",  
		            method:"POST",  
		            data:{
		                action: 'addNewAffRequest',
		                ajaxRequestIdAdd : $modalIdAdd,
		                ajaxRequestNameAdd : $affNameAdd,
		                ajaxRequestAksAdd : $affAksv2Add,
		                ajaxRequestCddAdd : $affCddv2Add,
		                ajaxRequestBrexitgbpAdd : $affBrexitgbpv2Add,
		            },   
		            success:function(data){  
		            	if(data == 'SUCCESS'){
		            		alert(data);
		            		window.location.reload();
		            	}else{
		            		alert(data);
		            	}
		            	
		                
		            } 
		        }); 
	   		}else 
	   			alert("DISABLED FOR NOW");
	    });	

	});

	function affiliateLinkCheck(data){
		var href = '<?=PROOT?>utilities/affiliateCheck'; //for goto
		$('.div-errors-alc').show();
		$('.div-search-alc').show();
		$('.result-no-affiliate').empty();
		$('.result-with-affiliate').empty();
		
		if(data != 'INVALID INFORMATION'){
			var NOALink = data.success.noAffiliateLink;
	        var WALink = data.success.withAffiliaLink;
	        var RSite = data.success.site;
			for(var i in NOALink){
		        var app1 = "<div class='store alert-v2 alert-warning-v2 no-aff-link-v2' data-show='show'>";
		        	app1 += 	'<input type="button" data-target="#affiliate-link-add-modal" data-toggle="modal" data-noAff-merName='+NOALink[i].name+' data-noAff-merId='+NOALink[i].id+' class="btn btn-add-afflinkv2" value="ADD" disabledd>';
		        	app1 += 	"<span class='names "+NOALink[i].classText+"'>&nbsp;&nbsp;"+NOALink[i].name.substr(0,1).toUpperCase() + NOALink[i].name.substr(1)+" Dont have affiliate check</span>";
		        	app1 += "</div>";
		        $('.result-no-affiliate').append(app1);
			}
			for(var j in WALink){
		    	var app2 = "<div class='store "+WALink[j].classType+"' data-show='show'>";
		    		app2 += 	"<div><h5><b class='names hidden-xs hidden-sm'>"+WALink[j].name.substr(0,1).toUpperCase()+WALink[j].name.substr(1)+" "+WALink[j].mer_id+" - "+WALink[j].count+" found</b></h5></div>";
		    		app2 += '<input type="button" data-target="#affiliate-link-edit-modal" data-toggle="modal" data-withAff-merName='+WALink[j].name+' data-withAff-merId='+WALink[j].mer_id+' class="btn" id="edit-aff-link-modal" value="Edit" disabledd>';
		    		app2 += '<b class="">&nbsp;&nbsp;Tracking code is:&nbsp;  '+WALink[j].aff_link+'</b>';
		    			if(WALink[j].data != null){
		    				app2 += "<div class='err-link-display-aflc'>";
		        				for(var k in WALink[j].data){
		        					var normalised_name = WALink[j].data[k].normalised_name;
		        					var buy_url = ($url_check === 'buy_url_raw') ? WALink[j].data[k].buy_url_raw : WALink[j].data[k].buy_url ;
		       						app2 += "<li class='wb-break-all'>"+gotoAffiliateCheckGameId(RSite,normalised_name,buy_url,href,$url_check)+"</li>";
		       						if(WALink[j].data != null && $url_check == 'buy_url_raw'){
		       							app2 += "<div class='bur-sm-btn'>";
		       							app2 +=		"<input type='button' id='bur-sm-btn' class='btn' value='see more' data-name="+WALink[j].name+" data-id="+WALink[j].mer_id+" data-aff="+WALink[j].aff_link+" data-site="+RSite+">";
		       							app2 += "</div>";
		       						}
		        				}	
		        			app2 += "</div>";
		    			}
		    		app2 += "</div>";
		    	$('.result-with-affiliate').append(app2);	
		    }
			$('.change-site').text(site.toUpperCase());
			$('.total-error-aff').html('<b class="">&nbsp;TOTAL '+data.success.totalError+'</b>');
		}else{
			alert(data);
		}
	}

	//href buy_url for REAL DOUBLE LINKS
    function gotoAffiliateCheckGameId(websiteToggle,normalised_name,url,path,$url_check){
    	var newPath = path.replace(/akss\/utilities\/affiliateCheck/,'');
    	var newUrl = html_decode(url);
        if(websiteToggle === 'aks'){
            var  newGoto = newPath+'index.php?game_id='+normalised_name;
            if($url_check == 'buy_url_raw')
            	return "<a href='"+ newUrl +"' target='_blank'>"+newUrl+"</a>";
            else
            	return "<a href='"+ newGoto +"' target='_blank'>"+newUrl+"</a>";
        }else{
            var newGoto = newPath+'index.php?game_id='+normalised_name+'&website='+websiteToggle;
            if($url_check == 'buy_url_raw')
            	return "<a href='"+ newUrl +"' target='_blank'>"+newUrl+"</a>";
            else
            	return "<a href='"+ newGoto +"' target='_blank'>"+newUrl+"</a>";
        }
    }

   	function target_link($url_check,$goto,urlNi){
		if($url_check == "buy_url_raw")
			return html_decode(urlNi);
	}

</script>
<style>
	.div-topheader{
		display:flex;
	}
	.div-topheader-1{
		width:100%;
	}
	.div-topheader-2{
		width:10%;
	}
	.TU-btns input[type=button]{ 
		font-size: 12px !important;
		padding: 1px 5px 1px 5px;
		background-color: #fff;
		color: #3f51b5; 
		margin-right: 8px;
		letter-spacing: 2px;
		font-weight: bold;
		border-color: #2e6da4;
		border-radius: 10px;
	}
	.bur-sm-btn input[type=button],
	.store input[type=button]{ 
		padding: 2px 6px 2px 6px;
		background-color: #5bc0de;
		color: #fff; 
		margin-right: 8px;
		letter-spacing: 1.5px;
		font-weight: bold;
		border-color: #50b7c8;
	}
	.TU-btns input[type=button]:hover{
		background-color:#0e2082e8;
		color: #fff !important; 
	}
	.act-tu-btn{
		color: #fff !important;
		background-color: #3f51b5 !important; 
	}
	.p-text{
		letter-spacing: 2px;
	}

	/* Affiliate design area here -----------------------------------------------------------------------------------*/
	.alert-v2{
		padding: 15px;
		margin-bottom: 20px;
		border: 1px solid transparent;
		border-radius: 4px;
	}
	.alert-success-v2 {
		color: #3c763d;
		background-color: #dff0d8;
		border-color: #d6e9c6;
	}
	.alert-warning-v2 {
		color: #8a6d3b;
		background-color: #fcf8e3;
		border-color: #faebcc;
	}
	.err-link-display-aflc{
		padding: 5px 15px 0 15px;
	}
	.err-link-display-aflc li{
		padding: 2px 0 2px 0;
	}
	.has-search {
		right: initial;
		left: 0;
		color: #ccc;
	}
	.total-error-aff { font-size: 20px; }
	.txt-danger{ color: #a94442; }
	#div-no-affiliate-link-body{ font-size: 14px; }
</style>
<?php $this->end()?> 


<?php $this->start('body')?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 mtop-35px">
				<div class="card card-style">
					<div class="card-body rdl-card-main-wrap no-padding">
						<!-- HEADER STARTS -->
						<div class="card-div-overflow-style row-4-card-div-overflow-style row-4-card-div-overflow-style-2" style ="padding-bottom:20px;">
							<div class="div-topheader" style="padding-top: 20px; padding-left: 10px; color: white;">
								<div class="div-topheader-1 TU-btns">
									<h5 style="display: inline-block; margin-right: 10px;">Affiliate Links</h5>
									<i class="fa fa-hand-o-right" aria-hidden="true"></i>
									<p style="font-size:12px;font-weight: 500;display: inline-block; padding:0;margin:0">
										<input id="btn-bu" class="btn <?= ($url_check == 'buy_url') ? 'act-tu-btn':'';?>" type="button" name="buy_url" value="BUY URL">
									</p>
									<!-- <p style="font-size:12px;font-weight: 500;display: inline-block; padding:0;margin:0">
										<input id="btn-bu" class="btn <?= ($url_check == 'buy_url_raw') ? 'act-tu-btn':'';?>" type="button" name="buy_url_raw" value="BUY URL RAW">
									</p> -->
									<p style="font-size:12px;font-weight: 500;">Checks the affiliate of the <b class="p-text"><?= $text ?></b> on every merchant</p>
								</div>
							</div>
						</div >
						<!-- CONTENT STARTS -->
						<div>
							<div class="dropdown-box dbox-hide" style="padding-bottom: 5px;">
 								<div class="dropdown-div" style="width: 150px;">
									<!-- in custom.js  OptionSite(inputs,className,classParent,bgColor) -->
								</div>
								<div class="pull-right div-errors-alc" style="display:none;">
									<input style="color:#fff;" type="button" name="" data-old-val="Reset" class="m-d col-xs-3 btn btn-delete" id="filterd-btn" value="Show Errors">
									<span class="total-error-aff"></span>
								</div>
							</div>
							<div class="mt-4 div-search-alc" style="display:none; margin-bottom: 10px;">
								<div class="form-group has-feedback has-search">
									<span class="glyphicon glyphicon-search form-control-feedback"></span>
									<input type="text" class="form-control input-site " placeholder="Search Store" value="">
								</div>

							</div>
							<div class="col-xs-12 div-body-table mt-4" id="div-no-affiliate-link-body">
								<div class="col-sm-12 no-padding result-no-affiliate search">
									
								</div>
								<div class="col-sm-12 no-padding result-with-affiliate search">
									
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $this->end()?> 