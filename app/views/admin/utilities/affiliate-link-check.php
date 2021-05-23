<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>vendors/css/utilities-page.css" media="screen" title="no title" charset="utf-8">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>
<script type="text/javascript">
	var $url_check = '<?= $this->getPost ?>';
	var $url = url+'utilities/affiliateCheck';
	var globalSite = null;
	console.log($url_check)
	var $dataReq = {
		action: 'ajaxAffiliateLinkCheck',
		site: 'aks',
		urlCheck: $url_check,
	};

	var $dataReqEdit = {
		action: 'ajaxAffiliateLinkIdRequest',
		ajaxRequestId: '',
		urlCheck: $url_check,
	}

	$(function(){
		//rendered on first load
		//$('.dropdown-div').html(OptionSite(inputsSite,'opt-site-alc','slc-options','custom-bkgd')); //OptionSite na a sa custom.js

		if(sessionStorageCheck()){
			$('.change-site').text('LOADING...');
			var object = JSON.parse(getStorage('sessionStorage','OptionSite'));
			if(object != null){
				site = returnSite(object.site);
				if(site != 'invalid'){
					$dataReq.site = site;
					AjaxCall($url, $dataReq).done(function(data){ affiliateLinkCheck(data) });
				}else{ if(removedKeyNormal('sessionStorage','OptionSite')) console.log("Item has been removed") } //remove key if invalid site
			}else{
				console.log('NO VALUE DEFAULT IS AKS');
				AjaxCall($url, $dataReq).done(function(data){affiliateLinkCheck(data) });
			}
		}

		$(document).on('click', '.website-items', function(){
			$('.website-btn').val('Loading');
			var indexInput = $(this).parent().prevObject.index(); //get the index of li
			if($(this).parent()[0].children.length == 3 ){
				site = (indexInput == 0 ) ? inputsSite[0].site : (indexInput == 1 ) ? inputsSite[1].site : (indexInput == 2 ) ? inputsSite[2].site : '';
				var $data = { 'site': site, 'path': $url }
				if(sessionStorageCheck()){ setStorage('sessionStorage','OptionSite',JSON.stringify($data)) } //store
					$dataReq.site = site;
					AjaxCall($url, $dataReq).done(function(data){
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
			var typo = regExpEscape($(this).val());  //or var value = $(this).val().toLowerCase(); // in if $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			//for earch the div that having names class
			$('.search .store .names').each(function(){ 
	         	var $this = $(this);//console.log($this.text());
	         	//console.log($(this).text().search(new RegExp(typo, "i")) < 0) //"i" to perform case-insensitive //returns true if find or false if not
	         	if($(this).text().search(new RegExp(typo, "i")) < 0){
	         		$this.closest('div.store').fadeOut(500);
				 }else 
	        		$this.closest('div.store').fadeIn(500);
	    	});
        });

		//Display EDIT affiliate
		$(document).on('click', '#edit-aff-link-modal', function(){
			let $modalId = $(this).attr('data-withAff-merId');
			$dataReqEdit.ajaxRequestId = $modalId;
			AjaxCall($url, $dataReqEdit).done(function(data){
				$("#aff-link-merchant-idv2").val(data[0].merchant_id);
	            $("#aff-link-namev2").val(data[0].name);
	            $("#aff-link-aksv2").val(data[0].aks_affiliate_link);
	            $("#aff-link-cddv2").val(data[0].cdd_affiliate_link);
	            $("#aff-link-brexitgbpv2").val(data[0].brexit_affiliate_link);
			});
			$('#affiliate-link-edit-modal').modal('hide'); //hide for now
		});


		//Confirmation save affiliate
		$(document).on('click', '#btn-affiliate-edit-save', function(){
			var $dataReqSave = {
				action: 'ajaxAffiliateEditRequest',
	            ajaxRequestId :   $('#aff-link-merchant-idv2').val(),
	            ajaxRequestName : $("#aff-link-namev2").val(),
	            ajaxRequestAks :  $("#aff-link-aksv2").val(),
	            ajaxRequestCdd :  $("#aff-link-cddv2").val(),
	            ajaxRequestBrexitgbp : $("#aff-link-brexitgbpv2").val(),
	            ajaxRequestsite : globalSite,
			}
			AjaxCall($url, $dataReqSave).done(function(data){
					console.log(data);
	            	var resultData = data.success.data;
	            	var resultsite = data.success.site;
	            	if(resultData.match(/^Successfully/))
	                {
	                	alert(resultData)
	                	//$('#alert-modal-popup').modal('show');
	                	//$('.eMessage').text(resultData);

	                	$('#affiliate-link-edit-modal').modal('hide');
						$dataReq.site = resultsite;
	                    //AjaxCall($url, $dataReq).done(function(data){ affiliateLinkCheck(data) });
	                }else{
						alert(resultData)
	                	//$('#alert-modal-popup').modal('show');
	                	//$('.eMessage').text(resultData);

	            		$('#affiliate-link-edit-modal').modal('hide');
						$dataReq.site = resultsite;
						//AjaxCall($url, $dataReq).done(function(data){ affiliateLinkCheck(data) });
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
			var btn = document. getElementById("edit-aff-link-modal").disabled = true;
			var $dataReqAddNewAff = {
				action: 'addNewAffRequest',
		        ajaxRequestIdAdd : $("#aff-link-merchant-idv2-add").val(),
		        ajaxRequestNameAdd : $("#aff-link-namev2-add").val(),
		        ajaxRequestAksAdd : $("#aff-link-aksv2-add").val(),
		        ajaxRequestCddAdd : $("#aff-link-cddv2-add").val(),
		        ajaxRequestBrexitgbpAdd : $("#aff-link-brexitgbpv2-add").val(),
			}
       		if(!btn){
				AjaxCall($url, $dataReq).done(function(data){ 
					if(data == 'SUCCESS'){
		            		alert(data);
		            		window.location.reload();
		            	}else{
		            		alert(data);
		            	}
				});

		        // $.ajax ({  
		        //     url: "<?php //PROOT?>utilities/affiliateLinkCheck",  
		        //     method:"POST",  
		        //     data:{
		        //         action: 'addNewAffRequest',
		        //         ajaxRequestIdAdd : $modalIdAdd,
		        //         ajaxRequestNameAdd : $affNameAdd,
		        //         ajaxRequestAksAdd : $affAksv2Add,
		        //         ajaxRequestCddAdd : $affCddv2Add,
		        //         ajaxRequestBrexitgbpAdd : $affBrexitgbpv2Add,
		        //     },   
		        //     success:function(data){  
		        //     	if(data == 'SUCCESS'){
		        //     		alert(data);
		        //     		window.location.reload();
		        //     	}else{
		        //     		alert(data);
		        //     	}
		        //     } 
		        // }); 

	   		}else 
	   			alert("DISABLED FOR NOW");
	    });	

		//toggle url check
		$(document).on("click", "#btn-bu",function(){
			//$url_check = $(this).attr("name");
			var press_to_chk = $(this).attr("name");
			var $press_to_chk = (press_to_chk == 'buy_url_raw' ) ? 'buy_url_raw' : 'buy_url';

			window.location.href = "?url_check="+$press_to_chk;
		});

		//See more button in buy_url_raw
		$(document).on("click" ,"#bur-sm-btn" ,function(event){
			$(".appendData").empty();
			let thisbtn = $(this);
			thisbtn.attr('disabled','disabled');
			$.ajax({
				url:"<?=PROOT?>utilities/affiliateCheck",  
				method:"POST",
				dataType:'JSON',
				data:{
					action:'affMoreInfo',
					merchant_id: $(this).attr('data-id'),
					website: $(this).attr('data-site'),
					afflink: $(this).attr('data-aff'),
					mer_name: $(this).attr('data-name'),
					toUrl: $url_check
				} 
			}).done(function(data){
				//console.log(data.data)
				$data = data.data;
				$('#modal-show-more').modal('show');
				$('.display-res .mer-id').text(data.name+" "+data.merchant);
				$('.display-res .total-c').text("Total: "+$data.length);
				$('.display-res .u-type').text(data.type);
				for(var i in $data){
					var urlNi = ($url_check == "buy_url")? $data[i].buy_url:$data[i].buy_url_raw;
					var colorText = ($url_check == "buy_url")? '': 'cus-text' ;
					if(urlNi != null || urlNi != ''){
						var append =  '<tr>';
							append += '<td class="gId">'+$data[i].normalised_name+'</td>';
							append += '<td class="wb-break-all getUrl '+colorText+'">'+target_link($url_check,$data[i].normalised_name,urlNi,)+'</td>';
							append += '</tr>';

						$(".appendData").append(append);
					}
				}
			}).always(function(){
				thisbtn.removeAttr("disabled");
			});
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
			$('.website-btn').val(RSite.toUpperCase());
			$('.total-error-aff').html('<b class="">&nbsp;TOTAL '+data.success.totalError+'</b>');
			globalSite = RSite;
		}else{
			//alert(data);
			$('.div-error').empty();
			$('.div-error').append('<h1>Opps no result found !!!</h1>');
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
	/* .div-topheader{ display:flex; }
	.div-topheader-1{ width:100%; }
	.div-topheader-2{ width:10%; } */
	
	.act-tu-btn{
		color: #fff !important;
		background-color: #0062cc !important; 
	}
	.p-text{
		letter-spacing: 2px;
		margin-left:2px;
		margin-right:2px;
		text-decoration:underline;
	}
	.div-pages{ text-align:center; }
	/* Affiliate design area here -----------------------------------------------------------------------------------*/
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

	/* modal of see more btn */
	.gId{ width: 15%;}
	.cus-text{ color: #4e73df; }
	.getUrl { width: 85%; word-break: break-all; }
	.wb-break-all{ word-break: break-all; }
	.custm-bg{ background-color: #edf0f5 !important; }
	.aff-modal thead th{ background-color: #fff; }
	.aff-modal tbody td,
	.aff-modal thead th {
		border: none;
		color: #3f51b5;
		padding: 4px 10px 4px 10px;
	}
	.aff-modal > thead > tr > th{
    	border-bottom: 2px solid #fff !important;
	}
	.mer-id,.total-c{
		letter-spacing: 1.5px;
		font-weight: bold;
		color: #3f51b5; 
	}
</style>
<?php $this->end()?> 


<?php $this->start('body')?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 mtop-35px">
				<div class="card card-style">
					<div class="card-body no-padding">
						<!-- HEADER STARTS -->
						<div class="card-div-overflow-style row-4-card-div-overflow-style-2" style="position:relative; padding-top:20px;">
							<div class="row" style="color:#fff;margin: 0;">
								<div class="header-div col-lg-9">
									<h5 class="header-title-page">Affiliate Links</h5>
									<p class="header-text-paragraph">Checks the affiliate of the <b class="p-text"><?= $this->text; ?></b> on every merchant</p>
								</div>
                                <div class="div-dropdown-website col-lg-3" style="padding-bottom:20px;">
                                    <div class="dropdown-website">
                                        <div class="selected-website">
                                            <span class="selected-data"><input id="website-btn" class="website-btn" type="button" value="AKS"></span>
                                            <span class="position-icon-1"><i class="fas fa-caret-down"></i></span>
                                        </div>
                                        <ul class="website-menu" style="display:none;">
                                            <li class='website-items' data-website="aks">AKS</li>
                                            <li class='website-items' data-website="cdd">CDD</li>
                                            <li class='website-items' data-website="brexitgbp">BREXITGBP</li>
                                        </ul>
                                    </div>
                                </div>
							</div>
                        </div>
						<!-- CONTENT STARTS -->
						<div class="row">
							<div class="col-lg-10 mb-4">
								<div class="TU-btns">
									<input id="btn-bu" class="btn <?= ($this->getPost == 'buy_url') ? 'act-tu-btn':'';?>" type="button" name="buy_url" value="BUY URL">
									<input id="btn-bu" class="btn <?= ($this->getPost == 'buy_url_raw') ? 'act-tu-btn':'';?>" type="button" name="buy_url_raw" value="BUY URL RAW">
								</div>
							</div>
							<div class="col-lg-2 mb-4">
								<div class="div-errors-alc" style="display:block;">
									<input type="button" name="" data-old-val="Reset" class="btn btn-delete alc-error-style" id="filterd-btn" value="Show Errors">
									<span class="total-error-aff text-white"></span>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="div-search-alc col-12 no-padding mb-2" style="display:none; margin-bottom: 10px;">
									<div class="form-group has-feedback has-search">
										<span class="glyphicon glyphicon-search form-control-feedback"></span>
										<input type="text" class="form-control input-site " placeholder="Search Store" value="">
									</div>
								</div>
							</div>
							
							<div class="col-lg-12 div-body-table mb-2" id="div-no-affiliate-link-body">

								<div class="col-lg-12 no-padding result-no-affiliate search">
									
								</div>
								<div class="col-lg-12 no-padding result-with-affiliate search">
									
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<style>
		.div-errors-alc{
			background-color: #b94749;
			border-radius:5px;
		}
		.alc-error-style{
			color:#fff; 
			background:transparent;
			padding:0 8px 0 8px;
			margin-left:4px;
		}
	</style>
<?php $this->end()?> 