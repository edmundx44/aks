var $dataReq = {
		action: 'merchant_edition_price_tool',
		website: 'aks',
		merchant: '0',
		edition: '0',
	};
	var conEdition = [];
	var conMerchant = [];

	$(function() {

		var init = safelyParseJSON(getStorage('sessionStorage','website')) 
		if( init && returnSite(init) != null){
			$dataReq.website = init;
		}else 
			removedKeyNormal('sessionStorage','website') 
		
		$.when( getMerchant(), getEdition() ).then( () => {
			AjaxCall(url, $dataReq).done( ajaxSuccess )
		})

		//search filder merchant
		$(document).on('click input', '.me-merchant-selinp',function(){
			$('.dropdown-menu-div').hide();
			$('.me-dmd-merchant').show().empty();
			var matcher = new RegExp( regExpEscape(this.value) , "i");
			var getOuput = conMerchant.filter(function (items) {
				return matcher.test(items.search)
			});
			for(var i in getOuput){
				$('.me-dmd-merchant').append(getOuput[i].toAppend) 
			}
		});

		//search filder edition
		$(document).on('click input', '.me-edition-selinp',function(){
			$('.dropdown-menu-div').hide();
			$('.me-dmd-edition').show().empty();
			var matcher = new RegExp( regExpEscape(this.value) , "i");
			var getOuput = conEdition.filter(function (items) {
				return matcher.test(items.search)
			});
			var displayTop = ['1','16','7','5','4','33'];
			for(var i in getOuput){
				if($.inArray(getOuput[i].id, displayTop) != -1) 
					$('.me-dmd-edition').prepend(getOuput[i].toAppend) 
				else
					$('.me-dmd-edition').append(getOuput[i].toAppend) 
			}
		});

		$(document).on('click', '.me-dd-select-site',function(){
			$('.dropdown-menu-div').hide();
			$('.dmd-select-site').show();
		});

		//Select Website
		$(document).on('click', '.dmds-select-site',function(){
			$('.dropdown-menu-div').hide();
			$('.dd-btn-text').html($(this).html())
			$('#me-check-display').empty();
            $('.me-select-input').val('');
            $dataReq.merchant = '0', $dataReq.edition = '0';
            var indexInput = $(this).parent().prevObject.index();
            if($(this).parent()[0].children.length == 3 ){
                $dataReq.website = (indexInput == 0 ) ? inputsSite[0].site : (indexInput == 1 ) ? inputsSite[1].site : (indexInput == 2 ) ? inputsSite[2].site : '';
                setStorage('sessionStorage','website',JSON.stringify($dataReq.website))
                AjaxCall(url, $dataReq).done( ajaxSuccess );
            }else 
				window.location.reload();
		});
		
		//Select Merchant/Edition
		$(document).on('click', '.dmds-merchant, .dmds-edition', function(){
			switch ($(this).parent().attr('data-dropdown')) {
				case 'Merchant':
					var $value = $(this).attr('data-me-merchant-ni')+' '+$(this).attr('data-merchant-id-ni');
					$dataReq.merchant = $(this).attr('data-merchant-id-ni');
					$('.me-merchant-selinp').val($value);
				break;
				case 'Edition':
					var $value = $(this).attr('data-me-edition-ni')+' '+$(this).attr('data-edition-id-ni');
					$dataReq.edition = $(this).attr('data-edition-id-ni');
					$('.me-edition-selinp').val($value);
				break;
				default:
					$dataReq.merchant = '0';
					$dataReq.edition  = '0';
					$('.me-select-input').val('');
				break;
			}
		});
		
		$(document).on('click', '#fire', function(data){
			if($dataReq.merchant == '0' && $dataReq.edition != '0' || $dataReq.merchant != '0' && $dataReq.edition == '0' )
				alertMsg("One of input is empty", "bg-danger")
			else if ($('.me-select-input').val() == ''){
				$dataReq.merchant = '0';
				$dataReq.edition  = '0';
				$('#me-check-display').empty();
            	AjaxCall(url, $dataReq).done( ajaxSuccess );
			}
			else{
				$('#me-check-display').empty();
				AjaxCall(url, $dataReq).done( ajaxSuccess );
			}
		});

	//end of Jquery Dom	
	});

	function getEdition(){
		conEdition = []
		var dataRequest =  {
			action: 'get-edition',
		}
		AjaxCall(url, dataRequest).done(function(data) {
			for(var i in data){
				var name = data[i].name.substr(0,1).toUpperCase()+data[i].name.substr(1).toLowerCase();
				conEdition.push({
					'id' : data[i].id,
					'name' : name,
					'search': name +' '+ data[i].id,
					'toAppend': '<div class="dropdown-menu-div-sub dmds-edition" data-me-edition-ni="'+ name +'" data-edition-id-ni='+data[i].id+'><span class="dmds-data-name">'+ name +'</span> = <span class="dmds-data-id"> '+data[i].id+' </span></div>'
				});
			}
		}).always(function() {});
	}

	function getMerchant(){
		conMerchant = []
		var dataRequest =  {
			action: 'get-merchant',
		}
		AjaxCall(url, dataRequest).done(function(data) {
			for(var i in data){
				var name = data[i].vols_nom.substr(0,1).toUpperCase()+data[i].vols_nom.substr(1).toLowerCase();
				conMerchant.push({
					'id' : data[i].vols_id,
					'name' : name,
					'search': name +' '+ data[i].vols_id,
					'toAppend': '<div class="dropdown-menu-div-sub dmds-merchant" data-me-merchant-ni="'+ name +'" data-merchant-id-ni='+data[i].vols_id+'><span class="dmds-data-name">'+ name +'</span>  <span class="dmds-data-id"> '+data[i].vols_id+' </span></div>'
				});
			}
		}).always(function() {});
	}

	function ajaxSuccess(data) {
		var result = data.success.data;
		for(var i in result){
			var app =  '<div class="result-merchant card-style mb-3">';
				app +=  '<p class="text-note">Create by '+result[i].created_by+' on '+result[i].created_time+'</p>';
				app +=  '<div> <span class="me-text">Merchant</span><span class="me-res">'+result[i].merchant+'</span> </div>';
				app +=  '<div class="div-inline"><span class="me-text">Price</span><span class="me-res">'+result[i].price+'</span></div>';
				app +=  '<div class="div-inline"><span class="me-text">Edition</span><span class="me-res">'+result[i].edition+'</span></div>';
				app +=  '<div class="div-inline"><span class="me-text">Region</span><span class="me-res">'+result[i].region+'</span></div>';
				app +=  '<div><span class="me-res">'+result[i].search_name+'</span></div>';
				app +=  '<div><span class="me-res"><a class="url-redirect" href='+result[i].buy_url+' target="_blank">'+result[i].buy_url+'</a></span></div>';
				app += '</div>';
			$('#me-check-display').append(app);
		}
		$('.dd-btn-text').html(data.success.returnWebsite.toUpperCase())
	}