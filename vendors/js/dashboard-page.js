
	var doughnut_PTZ;
	var doughnut_RDB;
	var doughnut_FRT;
	var checksumChart;
	var $checksumSite = 'aks';
	var lineChart = 'checksum-4';

	var D = new Date();
	var dmonth = ((D.getMonth()+1) < 10) ? "0"+(D.getMonth()+1) : D.getMonth()+1;
	var dday = (D.getDate() < 10) ? "0"+D.getDate() : D.getDate();
	var strDate = dmonth + "/" + D.getDate() + "/" + D.getFullYear();
	var timeStampData = D.getFullYear() + '-' + dmonth + '-' + dday;
		
	

	$(function(){
		checkWidthFB(); //it will take effect it its reload
		callChangelogs()

		var display1 = 

		$.when(
			xhr_AjaxCall(url+'dashboard','POST','displayRunAndSuccessAction').done(function(data){ displayRunAndSuccess(data) }),
			xhr_AjaxCall(url+'dashboard','POST','displayPriceToZeroCountsCounts').done(function(data) { displayPriceToZero(data) }),
			xhr_getChecksumDisplay(url+'dashboard',timeStampData,$checksumSite).done(function(data) { checksumDone(data); }),
			initChecksumChart(lineChart), //initialize checksum chart
			_ajaxFeedBots(url+'dashboard',"POST",'getFailedStores').done(function(data){ _doneFeedBots(data,'getFailedStores'); $('.dbox-content').css({'height':'80%'}) }),
			displayReport('menu-snapshot', 'AKS'), 
			displayReport('menu-dbfeed', 'AKS'),
			displayReport('menu-disabled', 'Store'),
			xhr_AjaxCall(url+'dashboard','POST','displayRealDoubleCounts').done(function(data) { displayRealDouble(data); }),
		)

		$(window).on('resize',function() { checkWidthFB(); /*take effect when its resize*/ });

		//FOR DROP DOWN SELECT ANIMATION
		$('.dropdown-div').click(function () { $(this).find('.dropdown-menu').slideToggle(200); });
		$('.dropdown-div').focusout(function () { $(this).find('.dropdown-menu').slideUp(200); });

		$(document).on('click', function(event){    
			if(!$(event.target).is('.card-body-div-i, .menu-disabled *, .menu-snapshot *, .menu-dbfeed *, .menu-others *')) {
				$('.card-body-menu-div').hide();
			}
		});		

		//FOR FEED SUCCESS, Fail, SERVER CHARGE
		$(document).on('click', '.feedbots-opt,.m-feedboot-opt-li', function(){
			switch($(this).attr("data-feedbots")){
				case 'getSuccessStores':
					_ajaxFeedBots(url+'dashboard',"POST",'getSuccessStores').done(function(data){
						_doneFeedBots(data,'getSuccessStores');
					});
				break;
				case 'getFailedStores':
					_ajaxFeedBots(url+'dashboard',"POST",'getFailedStores').done(function(data){
						_doneFeedBots(data,'getFailedStores');
					});
				break;
				case 'getServerChargeStore':
					_ajaxFeedBots(url+'dashboard',"POST",'getServerChargeStore').done(function(data){
						_doneFeedBots(data,'getServerChargeStore');
					});
				break;

				default:
				break;
			}
		});
		//append the button filtered
		$(document).on('click', '.input-btn-freports', function(){
			var $this = $(this);
			sfcReportsBtnFiltered($this,'freports','f-title');
		});

		$(document).on('click', '.input-btn-sreports', function(){
			var $this = $(this);
			sfcReportsBtnFiltered($this,'sreports','s-title');
		});

		$(document).on('click', '.input-btn-screports', function(){
			var $this = $(this);
			sfcReportsBtnFiltered($this,'screports','sc-title');
		});

		//CHECKSUM
		$(document).on('click', '.opt-site-chk', function(){
			//$('.opt-div-chm').hide();
			//alert($(this).attr('data-website'))
			switch($(this).attr('data-website')){
				case 'aks':
					//Modal
					xhr_toggleChecksum(url+'dashboard','aks').done(function(data){
						checksumSelectDone('aks',data);
					}).fail(function (jqXHR, textStatus, error) {
				        console.log("Post error: " + error);
				    });

				    //Chart
					xhr_getChecksumDisplay(url+'dashboard',timeStampData,'aks').done(function(data) {
			  			checksumDone(data);
					}).fail(function (jqXHR, textStatus, error) {
				        console.log("Post error: " + error);
				    });
				break;

				case 'cdd':
					//Modal
					xhr_toggleChecksum(url+'dashboard','cdd').done(function(data){
						checksumSelectDone('cdd',data);
					}).fail(function (jqXHR, textStatus, error) {
				        console.log("Post error: " + error);
				    });

					//Chart
					xhr_getChecksumDisplay(url+'dashboard',timeStampData,'cdd').done(function(data) {
			  			checksumDone(data);
					}).fail(function (jqXHR, textStatus, error) {
				        console.log("Post error: " + error);
				    });
				break;

				case 'brexitgbp':
					//Modal
					xhr_toggleChecksum(url+'dashboard','brexitgbp').done(function(data){
						checksumSelectDone('brexitgbp',data);
					}).fail(function (jqXHR, textStatus, error) {
				        console.log("Post error: " + error);
				    });

					//Chart
					xhr_getChecksumDisplay(url+'dashboard',timeStampData,'brexitgbp').done(function(data) {
			  			checksumDone(data);
					}).fail(function (jqXHR, textStatus, error) {
				        console.log("Post error: " + error);
				    });
				break;

				default:
					alert('Invalid Information');
				break;
			}

		});

		//FOR TABBING CONTENT in feed bot if mobile
		$(document).on('click', '.m-feedboot-opt-li', function(){
			$('.content-hide').hide();
			$('.m-feedboot-opt-li').removeClass('active-tab-1');
			$(this).addClass('active-tab-1');

			$('.clk-options').removeClass('active-tab'); //add active class also if in mobile view
			$('#'+$(this).attr('id').replace('-m','')).addClass('active-tab')

			switch($(this).attr('data-m-tab')){
				case 'm-chksum':
					$('.dbox-content').css({'height':'70%'})
					$('.dbox-hide').show(); //hide the webiste btn
					$('.checksum-chart').show();
				break;
				case 'm-sStore':
					$('.dbox-content').css({'height':'80%'})
					$('.dbox-hide').hide();
					$('.feed-success').show();
				break;
				case 'm-fStore':
					$('.dbox-content').css({'height':'80%'})
					$('.dbox-hide').hide();
					$('.feed-failed').show();
				break;
				case 'm-scStorem':
					$('.dbox-content').css({'height':'80%'})
					$('.dbox-hide').hide();
					$('.feed-servercharge').show();
				break;
			}
		});

		//FOR TABBING CONTENT
		$(document).on('click','.clk-options', function(){
			//alert($(this).attr('id'));
			$('.content-hide').hide();
			$('.'+$(this).attr('id')).show();	
			$('.clk-options').removeClass('active-tab');
			$('#'+$(this).attr('id')).addClass('active-tab');

			$('.m-feedboot-opt-li').removeClass('active-tab-1'); //add active class also if in mobile view
			$('#'+$(this).attr('id')+'-m').addClass('active-tab-1');

			if($(this).attr('id') != 'checksum-chart'){
				$('.dbox-content').css({'height':'80%'})
				$('.dbox-hide').hide(); //hide the webiste btn
			}else{
				$('.dbox-content').css({'height':'70%'})
				$('.dbox-hide').show();
			}
		});

		// menu icon click
		$(document).on('click', '.card-body-div-i,.card-body-div-fb', function(){
			switch($(this).data('what')){
				case 'menu-disabled':
					$('.menu-snapshot, .menu-dbfeed, .menu-others, .menu-feedbots').hide();
					$('.'+$(this).data('what')).toggle();
				break;
				case 'menu-snapshot':
					$('.menu-disabled, .menu-dbfeed, .menu-others, .menu-feedbots').hide();
					$('.'+$(this).data('what')).toggle();
				break;
				case 'menu-dbfeed':
					$('.menu-disabled, .menu-snapshot, .menu-others, .menu-feedbots').hide();
					$('.'+$(this).data('what')).toggle();
				break;
				case 'menu-others':
					$('.menu-disabled, .menu-snapshot, .menu-dbfeed, .menu-feedbots').hide();
					$('.'+$(this).data('what')).toggle();
				break;
				case 'menu-feedbots':
					$('.'+$(this).data('what')).toggle();
				break;

				default: alert('Invalid');
				break;
			}
		});


		// menu icon list
		$(document).on('click', '.card-body-menu-div-li', function(){
			displayReport($(this).data('to'), $(this).data('what'));
		});

		// view more click
		$(document).on('click', '.card-body-div-sub-span, .view-more-icon', function(){
			switch($(this).data('to')){
				case 'menu-disabled':
					displayMoreReport('menu-disabled', $('.menu-disabled-what').text())
					$('#reportModal').modal('show');
					addHeaderClass('.rheader-modal', $('.menu-disabled-what').text().toLowerCase())
				break;
				case 'menu-snapshot':
					displayMoreReport('menu-snapshot', $('.menu-snapshot-what').text())
					$('#reportModal').modal('show');
					addHeaderClass('.rheader-modal', $('.menu-snapshot-what').text().toLowerCase())
				break;
				case 'menu-dbfeed':
					displayMoreReport('menu-dbfeed', $('.menu-dbfeed-what').text())
					$('#reportModal').modal('show');
					addHeaderClass('.rheader-modal', $('.menu-dbfeed-what').text().toLowerCase())
				break;
			}
		});

		//add changelogs
		$(document).on('click', '.btn-show-add-log-modal', function(){
			var dateNow = month + '/' + day + '/' + d.getFullYear() ;
			$('.changelog-date-txt').val(dateNow).trigger('keyup')
		});
		
		$(document).on('click', '#createChangelog', function(){
			var dataRequest =  { 
				action: 'addChangeLogAction',
				inputID: $('.changelog-id-txt').val(),
				inputDate: $('.changelog-date-txt').val(),
				inputMessage: $('.changelog-msg-txtarea').val()
			}
			AjaxCall(url, dataRequest).done(function(){}).always(function(){ 
				callChangelogs();
				$('#show-add-log-modal').modal('hide')
				$('.changelog-date-txt, .changelog-id-txt').val('').trigger('keyup');
				$('.changelog-msg-txtarea').val('')

			});

				// $.ajax({
				// 	url: '<?=PROOT?>dashboard',
				// 	type: "POST",
				// 	data : {
				// 		action: 'addChangeLogAction',
				// 		inputID: $('.alog-id').val(),
				// 		inputDate: $('.alog-date').val(),
				// 		inputMessage: $('.alog-textarea').val()
				// 	},
				// 	success : function(data){
				// 		alert(data);
				// 		window.location.reload();
				// 	}
				// });
		});

		//END 
	});

	// -------------------------- javascript function here ----------------------------
	//USE THIS IF ONLY 1 ACTION
	function xhr_AjaxCall($url,$type,$action){
		switch($action){
			case 'displayRunAndSuccessAction': $action = 'displayRunAndSuccessAction';
			break;
			case 'displayRealDoubleCounts': $action = 'displayRealDoubleCounts';
			break;
			case 'displayPriceToZeroCountsCounts': $action = 'displayPriceToZeroCountsCounts';
			break;
			default:
			break;
		}
		return $.ajax({
			url: $url,
			type: $type,
			data : { action: $action }
		}).always(function() { /* $('.loader-sucfail').remove(); */ });
	}
	// ------------------------------------------Run and Success chart
	function displayRunAndSuccess(data){
		var dataCount = [];
		var $chartTitle = 'Feedbot Runtime';
		//console.log(data);
		for (var i in data){
			dataCount.push(data[i].success,data[i].fail,data[i].serverCharge);
		}
		var resizeDonot = displayReportChart(dataCount,'feedBotRuntime-1',$chartTitle,doughnut_FRT);
		doughnutResize(resizeDonot,'mobile');
	}
	// ------------------------------------------Store Count chart
	function displayPriceToZero(data){
		//console.log(data);
		var priceTozero = [];
		for (var i in data){
			priceTozero.push(data[i].aks,data[i].cdd,data[i].brexitgbp);
		}
		if(data[0].aks == 0 || data[0].cdd == 0 || data[0].brexitgbp == 0){
			var $chartTitle = 'NO DATA FOR NOW';
		}else{
			var $chartTitle = 'Price To Zero Percentage';
		}
		var resizeDonot = displayReportChart(priceTozero,'priceToZeroPercent-1',$chartTitle,doughnut_PTZ);
		doughnutResize(resizeDonot,'mobile');
	}
	// ------------------------------------------Real Double Links chart
	function displayRealDouble(data){
		var realDoubleLinkCount = [];
		for (var i in data){
			realDoubleLinkCount.push(data[i].aks,data[i].cdd);
		}
		var $chartTitle = 'Real Double Links Count';
		displayReportChart(realDoubleLinkCount,'realDoubleCounts-1',$chartTitle,doughnut_RDB)
	}

	// ------------------------------------------checksum chart
	function checksumDone(data){
		//Dapat e replace sa naku ang mga space ' ' into \n ang label
		//console.log(data)
		var checksumLabel = [];
		var checksumLastUpdate = [];

		for(var i in data){
			var mN = data[i].merchant_name;
			var lUp= data[i].lastupdate;
			mN = (/(\s|_)/.test(mN)) ? mN.replace(/(\s|_)/g,'\n') : mN;
			checksumLabel.push(mN);
			checksumLastUpdate.push(lUp);
		}
		checksumChart.data.labels = checksumLabel;
		checksumChart.data.datasets[0].data = checksumLastUpdate;
		checksumChart.update();
	}

	function displayReportChart($data,$domId,$chartTitle,chartVarirable){
		var ctx = document.getElementById(''+$domId+'').getContext('2d');	//select a canvas
		var label_0 = ($domId == 'priceToZeroPercent-1') ? ['AKS', 'CDD', 'BREXIT'] : ['AKS', 'CDD'];
		var label_1 = ['Success','Fail', 'Server Charge'];
		var dataset = [{ 
				label: "Websites",
			    data: $data,
			    backgroundColor: [
			        "#2E8B57",
			        "#F4A460",
			        "#17a2b8"
			    ],
			    borderColor: [
			        "#ededed",
			        "#ededed",
			        "#ededed"
			    ],
			    borderWidth: 2
			}];

		switch($domId){
			case 'priceToZeroPercent-1':
			case 'realDoubleCounts-1':
			case 'feedBotRuntime-1':
			var option = {
				  	cutoutPercentage: 55, //60 if circle thickness
				  	circumference:(2 * Math.PI)/2, //comment this to make it circle
				  	rotation: 1 * Math.PI, //comment this to make it circle
				  	responsive: true,
				  	maintainAspectRatio: false, //to maintain the size of chart
				  	animation: {
		          		animateScale: true,
      					animateRotate: true,
		          		duration: 1500
		        	},
				title: {
				    display: true,
				    position: "top",
				    text: $chartTitle,
				    fontSize: '14',
					fontColor: '#ededed',
				},
				legend: {
				    display: true,
				    position: "left", //360width- bottom pos  , 460width+ left position
				    onHover: function(e) {
						e.target.style.cursor = 'pointer';
					},
				    labels: {
				      	fontColor: "#edf0f5",
				      	fontSize: 14,
				      	usePointStyle:true,
				      	padding: 20
				    }
				  },
				 tooltips: {
						mode: 'label',
						callbacks: {  //optional cutom tooltips
						    label: function(tooltipItem, $data) {
						    	//console.log($data['datasets'][0]['data'][tooltipItem['index']]); console.log($data['labels']);
						    	var chartTooltips = $data['labels'][tooltipItem['index']]+': '+$data['datasets'][0]['data'][tooltipItem['index']];
						    	var textPercent = '%'; 
						    	return ($domId == 'priceToZeroPercent-1') ? chartTooltips+textPercent : chartTooltips;
						  	}
						}
					},
				};
			default:
			break;
		}

		switch($domId){
			case 'priceToZeroPercent-1':
			case 'realDoubleCounts-1':
			 	var datas = { labels: label_0,
							  datasets: dataset
				}
				chartVarirable = new Chart(ctx, {
					type: 'doughnut',
					data: datas,
					options: option,
					plugins: [{
						resize: function (myChart) {
							doughnutResize(myChart);
						}
					}] 
				});

				return chartVarirable;
			break;
			case 'feedBotRuntime-1':
			 	var datas = { labels: label_1,
							  datasets: dataset
				}
				chartVarirable = new Chart(ctx, {
					type: 'doughnut',
					data: datas,
					options: option,
					plugins: [{
						resize: function (myChart) {
							doughnutResize(myChart);
						}
					}] 
				});
				return chartVarirable;
			break;
				
			default:
			break;
		}

	}

	/** START of FEED BOTS functions */
	function _ajaxFeedBots($url,$type,$action,$data = null){
		return $.ajax({
			url:$url,
			type:$type,
			data:{
				action:$action,
				data: $data
			}
		})
	}
	function _doneFeedBots(data,$actionTo){
		switch($actionTo){
			case 'getSuccessStores':
				$('.append-sreports').empty();
				$('.s-buttons').empty();
				var param1 = 'sreports' , param2 = 's-buttons', appendTo= 'append-sreports' ,showBtn = 's-buttons' ,titleTo = 's-title';
				var textFailed = "NO SUCCESS RUNTIME FOR NOW";
			break;
			case 'getFailedStores':
				$('.append-freports').empty();
				$('.f-buttons').empty();
				var param1 = 'freports' , param2 = 'f-buttons', appendTo= 'append-freports' ,showBtn = 'f-buttons' ,titleTo = 'f-title';
				var textFailed = "NO FAILED RUNTIME FOR NOW";
			break;
			case 'getServerChargeStore':
				$('.append-screports').empty();
				$('.sc-buttons').empty();
				var param1 = 'screports' , param2 = 'sc-buttons', appendTo= 'append-screports' ,showBtn = 'sc-buttons' ,titleTo = 'sc-title';
				var textFailed = "NO FAILED SERVER CHARGE FOR NOW";
			break;
			default:
			break;
		}
		if(data.length != 0){
			btnSuccessFailServerChargeFiltered(param1, param2);
			for(var i in data){
				var $bgColor = (data[i].website == 'aks') ?  'aks_color' : (data[i].website == 'cdd') ? 'cdd_color' : (data[i].website == 'brexitgbp') ? 'brexitgbp_color' : "";
				if(data[i].website == 'brexitgbp'){
					data[i].website = 'gbp';
				}
				successFailedstores(data[i].name, data[i].merchant_id, data[i].website, $bgColor, data[i].successRunTime, appendTo);
			}
			$('.'+titleTo).text(data.length+'\t');
			$('.'+showBtn).show();		
		}else{
			var empty = '<h4 class="text-center col-sm-12" style="margin-top:150px;">"'+textFailed+'"</h4>';
			$('.'+appendTo).append(empty);
			$('.'+showBtn).hide();
		}
	}
	function successFailedstores($merchantName,$merchantId,$merchantSite,$classType,$successRunTime,$toWhereAppend){
		var $divSite = ($merchantSite == 'aks') ?  'div-sfc-aks' : ($merchantSite == 'cdd') ? 'div-sfc-cdd' : ($merchantSite == 'gbp') ? 'div-sfc-brexitgbp' : "";
		var $siteName = ($merchantSite == 'gbp') ? 'brexitgbp' : $merchantSite;
		var append =	'<div class="'+$divSite+' div-data-col col-sm-6 sfc-divs-result">';
			append +=    	'<div class="float-left sf-name '+$siteName+'_color">'+$merchantName.toUpperCase()+' ('+$merchantId+')</div>';
			append +=        	'<div class="lt-spacing-1-5 mtop-8 sf-site float-right color '+$classType+'">'+$merchantSite.toUpperCase()+'</div>';
			append +=        	'<br>';
			append +=    	'<div class="sf-date">'+$successRunTime+'</div>';
			append +=	'</div>';
			$('.'+$toWhereAppend).append(append);
	}
	function btnSuccessFailServerChargeFiltered($class,$toWhereAppend){
		var appendData = '<input type="button" data-hide-'+$class+'="aks" class="sfbtn-style btn div-aks-bgcolor-2 sfbuttons-pad col-sm-4 input-btn-'+$class+' i-aks" value="AKS">';
			appendData +='<input type="button" data-hide-'+$class+'="cdd" class="sfbtn-style btn div-cdd-bgcolor-3 sfbuttons-pad col-sm-4 input-btn-'+$class+' i-cdd" value="CDD">';
			appendData +='<input type="button" data-hide-'+$class+'="gbp" class="sfbtn-style btn div-brexitgbp-bgcolor-2 sfbuttons-pad col-sm-4 input-btn-'+$class+' i-brexit" value="GBP">';
			$("."+$toWhereAppend).append(appendData);
	}
	function sfcReportsBtnFiltered($this,$class,$countTitle){
		var old = $this.val().toLowerCase(); //get the value aks
		if($this.attr("data-hide-"+$class) == 'aks'){
				$('.'+$countTitle).text($('.append-'+$class).children("div.div-sfc-aks").length+'\t') //get the length of div aks class
				$(".append-"+$class+" > div ").show(); //then show first all
				$this.removeAttr("data-hide-"+$class); //1st click remove the attr
				$('.i-cdd').attr("data-hide-"+$class+"",'cdd');
				$('.i-brexit').attr("data-hide-"+$class+"",'gbp');

				$('.div-sfc-cdd').hide();	//then hide the children 
				$('.div-sfc-brexitgbp').hide();
			}else if($this.attr("data-hide-"+$class) == 'cdd'){
				$('.'+$countTitle).text($('.append-'+$class).children("div.div-sfc-cdd").length+'\t') //get the length of div aks class
				$(".append-"+$class+" > div ").show(); //then show first all
				$this.removeAttr("data-hide-"+$class); //1st click remove the attr
				$('.i-aks').attr("data-hide-"+$class+"",'aks');
				$('.i-brexit').attr("data-hide-"+$class+"",'gbp');

				$('.div-sfc-aks').hide();	//then hide the children //then hide the children 
				$('.div-sfc-brexitgbp').hide();
			}else if($this.attr("data-hide-"+$class) == 'gbp'){
				$('.'+$countTitle).text($('.append-'+$class).children("div.div-sfc-brexitgbp").length+'\t') //get the length of div aks class
				$(".append-"+$class+" > div ").show(); //then show first all
				$this.removeAttr("data-hide-"+$class); //1st click remove the attr
				$('.i-aks').attr("data-hide-"+$class+"",'aks');
				$('.i-cdd').attr("data-hide-"+$class+"",'cdd');

				$('.div-sfc-aks').hide();	//then hide the children 
				$('.div-sfc-cdd').hide();	
			}else{
				$('.'+$countTitle).text($('.append-'+$class).children().length+'\t')
				$this.attr("data-hide-"+$class+"",old);		//if click again add the attr old
				$(".append-"+$class+" > div ").show(); //then show all again 
			}
	}
	/** ENF OF FEED BOTS functions */


	//para sa checksum beforeUpdate
	function arr_implode(array){
		//check if ang array kai array type sya e join if array if not array check if have \n then replace ' ' to join
		return ((Array.isArray(array))) ? array.join(' ') : (/\n/.test(array)) ? array.replace(/\n/,' ') : array;
	}

	//para sa doughnut put it plugins
	function doughnutResize(myChart,type){
		var initPos = myChart.chart.chart.config.options.legend;
		var width = myChart.chart.chart.width;
		var finalPos = "left";
		initPos.position = (width < 320 ) ? 'bottom' : finalPos;
		(type == 'mobile') ? myChart.update():null;
	}

	//para sa yTicks custom bar chart 
	function strtotime_javascript_time(epoch,$tzString) {
		var dateY = new Date(epoch*1000).toLocaleString("en-US",{timeZone: $tzString});
		var matchDate = dateY.match(/,\s(\d.+):\d.+(AM|PM)/)
		var combine = matchDate[1]+" "+matchDate[2];
		return (epoch != '') ? combine : 'No Data';
	}

	// ------------------------------------------checksum TABLE
	function checksumSelectDone($website,data){
		var result = data.success.data;
		for(var i in result){
			var $BgStatus = result[i].count > 0  ?  'text-success' : 'text-danger';
			var $status = result[i].count > 0  ?  'Updated' : 'Not Updated';

			var append =  "<tr class='getCount'>";
				append += 	'<td class="tbody-td-1" data-tbl-td="Merchant"><b>'+result[i].merchant_name+' ('+result[i].merchant_id+')</b></td>';
				append += 	'<td class="tbody-td-2" data-tbl-td="Checksum">'+result[i].checksum_data+'</td>';
				append += 	'<td class="tbody-td-3" data-tbl-td="Last Update">'+result[i].lastupdate+'</td>';
				append += 	'<td class="tbody-td-1 text-center '+$BgStatus+'" data-tbl-td="Status"><b>'+$status+'</b></td>';
				append += "</tr>";
			$(".table-checksum .checksum-body").append(append);
		}
		$('.change-site').text($website.toUpperCase());
		$('.modal-checksum-site').attr('data-modal-checksumsite',$website);
		$('.chkTable-total').text('TOTAL: '+result.length);
		//checksumChart.data.datasets[0].label = $website.toUpperCase()+ "\t\tStatus (<?= date('M d', strtotime('today')) ?>)"; //update the label of the chart checksum
		checksumChart.data.datasets[0].label = $website.toUpperCase()+ "\t\tStatus "+D.toLocaleString("default",{ month: "long" })+' '+dday; //update the label of the chart checksum
		checksumChart.update();
	}

	// ------------------------------------------checksum TABLE
	function xhr_toggleChecksum($url,$website){
		$(".table-checksum .checksum-body").empty();
		return $.ajax({
			url : $url,
			type: "POST",
				data : {
				action: 'displayChecksumUsingToggleSiteOnly',
				getWebsiteSent: $website
			},
			//beforeSend:function(){//$('.loader-checksum-mdata').show();}
		}).always(function(){
			//$('.loader-checksum-mdata').hide();
			//$('.opt-div-chm').show();
			//$(".opt-div-chm").prop('disabled',false);// or this 
		})
	}

	// ------------------------------------------checksum chart
	function xhr_getChecksumDisplay($url,timeStampData,$checksumSite){
		//var target = 'checksum';
		return $.ajax({
			url: $url,
			type: "POST",
			data : {
				action: 'displayCheckSumAction',
				dateNow: timeStampData,
				checksumSite: $checksumSite
			},
			//beforeSend: function() {showLoading(target)}
		}).always(function() {
			//$('#checksum-chart').removeAttr('disabled');
			//$('.loader-checksum').hide();
		});
	}
	
	// ------------------------------------------checksum chart
	function initChecksumChart(lineChart){
		var ctx4 = document.getElementById(''+lineChart+'').getContext('2d');
		var gradientStroke = ctx4.createLinearGradient(500, 0, 100, 0);
			gradientStroke.addColorStop(0, 	'#3e9df6');
			gradientStroke.addColorStop(0.3,'#4caf50');
			gradientStroke.addColorStop(0.8,'#4caf7a');
			gradientStroke.addColorStop(1, 	'#3f51b5');

		var gradientFill = ctx4.createLinearGradient(500, 0, 100, 0);
			gradientFill.addColorStop(0, 	"rgba(62,157,246, 0.3)");
			gradientFill.addColorStop(0.5, 	"rgba(76,175,80, 0.3)");							
			gradientFill.addColorStop(1, 	"rgba(63,81,181, 0.3)");

		checksumChart = new Chart(ctx4, {
		  type: 'line',
		  data: {
			   	datasets: [{
						label: 'AKS\tStatus '+D.toLocaleString("default",{ month: "long" })+' '+dday,
						backgroundColor: gradientFill,
						borderColor: gradientStroke,
						pointBorderColor: gradientStroke,
						pointBackgroundColor: gradientStroke,
						pointHoverBackgroundColor: gradientStroke,
						pointHoverBorderColor: gradientStroke,
						pointBorderWidth: 8,
						pointHoverRadius: 10,
						pointHoverBorderWidth: 1,
						pointRadius: 5,
						fill: false,
						borderWidth: 3,
					}]
			  	},
		  		options: {
		  		maintainAspectRatio: false, //to maintain the size of chart
		  		responsive: true,
		    	title: {
						display: false,
						text: ['Checksum'],
						position: 'top',
						fontfamily: "'Raleway', sans-serif",
						fontSize: '14',
						fontColor: '#6b6d70',
				},
				legend: {
						display: true,
						labels: {
							fontColor: '#004ea3', //title color
							fontStyle: 500,
							fontSize: 13,
							usePointStyle:true,
						},
						onHover: function(e) {
							e.target.style.cursor = 'pointer';
						}
					},
		    	scales: {
						yAxes: [{
							ticks: {
								// call function outside , parameter value is the data lastupdate store here myChart.data.datasets[0].data
								// 30*60 by 30mins 60*180 by 3hrs //remove the stacked:true in y axis caused it will begin at zero causing lag
								// cause strtotime_data value is in unix timestamp
								callback: function(strtotime_data) { return strtotime_javascript_time(strtotime_data,"Asia/Manila") },
            					stepSize: 60*180,
            					fontColor: '#004ea3',
							},
							gridLines: {
								display: false,
								color: '#0062cc',
								lineWidth: 2
							},
							scaleLabel: {
					            display: true,
					            labelString: 'TIME',
					            fontColor: '#004ea3',
								fontStyle: "bold",
					          }
						}],
						xAxes: [{
            				maxBarThickness: 50, // number (pixels),
							ticks: {
								beginAtZero: true,
								fontStyle: "bold",
								padding: 10,
								fontColor: '#004ea3',
							},
							stacked: true,
							gridLines: {
								display: false,
								color: '#0062cc',
								lineWidth: 2
							},
						}]
					},
					tooltips: {
				        mode: 'label',
				        callbacks: {
				         	//to remove comma (,) from the split in beforeUpdate data when hover to data in chart
				         	title: function(tooltipItem, $data) {
							  	//console.log($data['labels'][tooltipItem[0]['index']])
							  	return arr_implode($data['labels'][tooltipItem[0]['index']]) 
							},
				            label: function(tooltipItem, $data) {
								//console.log(arr_implode($data['labels'][tooltipItem['index']]))
				             	return "Last Update: "+strtotime_javascript_time($data['datasets'][0]['data'][tooltipItem['index']],"Asia/Manila")
				            }
				        }
				    }
				},
				plugins: [{
					//label that have \n will split into array from this ['Royal\nKey\nSoftware'] will became like this ['Royal','Key','Software']
				    beforeUpdate: function (myChart) {
				      	var initW = myChart.chart.chart.width;
				      	if(initW > 550){
				      		myChart.data.labels.forEach(function (e, i, a) {
					        if (/\n/.test(e))
					          	a[i] = e.split(/\n/);//console.log(e)
					    	})
				      	}
				    }
			  	}]	
			});

		}
	
	function displayReport($to, $what){
		var dataRequest =  {
				action: 'displayReport',
				to: $to,
				what: $what
			}
		addPointerEvents($what)
		AjaxCall(url+'dashboard', dataRequest).done(function(data) {
			switch(data.to){
				case 'Store':
					$('.disable-count').html(data.count);
					$('.disabled-what').html('Store');
					removedPointerEvents("Store")
				break;
				case 'Metacritics':
					$('.disable-count').html(data.count);
					$('.disabled-what').html('Metacritics');
					removedPointerEvents("Metacritics")
				break;
				case 'AKS':
					$('.snapshot-count').html(data.count);
					$('.snapshot-what').html('AKS');
					removedPointerEvents("AKS")
				break;
				case 'CDD':
					$('.snapshot-count').html(data.count);
					$('.snapshot-what').html('CDD');
					removedPointerEvents("CDD")	
				break;
				case 'BREXIT':
					// $('.snapshot-count').html(data.count);
					// $('.snapshot-what').html('BREXIT');	
				break;
				case 'AKSDB':
					$('.dbfeed-count').html(data.count);
					$('.dbfeed-what').html('AKS');	
					removedPointerEvents("AKSDB")
				break;
				case 'CDDDB':
					$('.dbfeed-count').html(data.count);
					$('.dbfeed-what').html('CDD');
					removedPointerEvents("CDDDB")
				break;
				case 'BREXITDB':
					$('.dbfeed-count').html(data.count);
					$('.dbfeed-what').html('BREXIT');
					removedPointerEvents("BREXITDB")		
				break;
			}
		});

		$('.card-body-menu-div').hide();
	}

	function displayMoreReport($to, $what){
		var dataRequest =  {
				action: 'displayReport',
				to: $to,
				what: $what
			}
		$('.display-more-report').empty();
		$('.report-modal-header').html('LOADING');

		AjaxCall(url+'dashboard', dataRequest).done(function(data) {
			switch(data.to){
				case 'Store':
					$('.report-modal-header').html('Disabled Store');
					for (var i in data.data){
						disabledDiv(data.data[i].merchant, data.data[i].id);
					}
				break;
				case 'Metacritics':
					$('.report-modal-header').html('Disabled Metacritics');
					for (var i in data.data){
						disabledDiv(data.data[i].merchant, data.data[i].id);
					}
				break;
				case 'AKS':
					$('.report-modal-header').html('AKS Snapshot');

					for (var i in data.data){
						var calcData = (data.data[i].updatedCount / data.data[i].databaseCount ) * 100;
						var resCalcData = (calcData >= .80) ? 'green-dif' : 'yellow-dif';
						
						snapshotDiv(
							(data.data[i].merchantName).toUpperCase(),
							data.data[i].merchantID,
							resCalcData,
							data.data[i].difference,
							data.data[i].updatedCount,
							data.data[i].databaseCount,
							((data.data[i].timeToScan).toUpperCase()).replace('/H/g', 'H '),
							((data.data[i].timeSinceScan).toUpperCase()).replace('/H/g', 'H '),
							'aks'
						);
					}
				break;
				case 'CDD':
					$('.report-modal-header').html('CDD Snapshot');

					for (var i in data.data){
						var calcData = (data.data[i].updatedCount / data.data[i].databaseCount ) * 100;
						var resCalcData = (calcData >= .80) ? 'green-dif' : 'yellow-dif';
					
						snapshotDiv(
							(data.data[i].merchantName).toUpperCase(),
							data.data[i].merchantID,
							resCalcData,
							data.data[i].difference,
							data.data[i].updatedCount,
							data.data[i].databaseCount,
							((data.data[i].timeToScan).toUpperCase()).replace('/H/g', 'H '),
							((data.data[i].timeSinceScan).toUpperCase()).replace('/H/g', 'H '),
							'cdd'
						);
					}
				break;
				case 'BREXIT':
					
				break;
				case 'AKSDB':
					$('.report-modal-header').html('AKS DB/FEED COUNT');

					for(var i in data.data){
						dbFeedCount(data.data[i].website, data.data[i].name, data.data[i].merchant_id, data.data[i].dbCount, data.data[i].feedCount, data.data[i].differences);
					}
				break;
				case 'CDDDB':
					$('.report-modal-header').html('CDD DB/FEED COUNT');

					for(var i in data.data){
						dbFeedCount(data.data[i].website, data.data[i].name, data.data[i].merchant_id, data.data[i].dbCount, data.data[i].feedCount, data.data[i].differences);
					}
				break;
				case 'BREXITDB':
					$('.report-modal-header').html('BREXIT DB/FEED COUNT');

					for(var i in data.data){
						dbFeedCount(data.data[i].website, data.data[i].name, data.data[i].merchant_id, data.data[i].dbCount, data.data[i].feedCount, data.data[i].differences);
					}	
				break;
			}
		});

		$('.card-body-menu-div').hide();
	}


	function checkWidthFB(){		
		if ($('.check-width').width() < 488) {
			$('.pc-fb-opt').hide();
			$('.m-fb-opt').show();
		}else{
			$('.pc-fb-opt').show();
			$('.m-fb-opt').hide();
			$('.menu-feedbots').hide();
		}
	}

	function disabledDiv($merchantName, $merchantID){
		var appendData = "<div class='col-sm-6 disabled-divs' >";
			appendData += "<div class='disabled-divs-1'>";
			appendData += "<p>";
			appendData += "<span style='letter-spacing:1.5px;font-weight:500;'>"+$merchantName+"</span>";
			appendData += "<span> ("+$merchantID+") </span>";
			appendData += "</p>";
			appendData += "</div>";
			appendData += "</div>";
			$('.display-more-report').append(appendData);
	}
		function snapshotDiv($merchantName,$merchantID,$resCalcData,$difference,$updatedCount,$databaseCount,$timeToScan,$timeSinceScan,$site){
			var appendData = "<div class='col-sm-12'>";
			    appendData +=  "<div class='report-snapshot-con-wrap no-padding'>";
				appendData += 	"<div class='report-snapshot-data-title-div'>";
				appendData += 		"<div class='snap-margin float-left report-snapshot-data-title'> "+$merchantName+" ("+$merchantID+")</div>";
				appendData += 		"<div class='count-dif text-white snap-margin div-"+$resCalcData+" float-right'>"+$difference+"</div>";
				appendData += 		"<table class='table snapshot-div'>";
				appendData +=			"<thead>";
				appendData += 				"<tr>";
				appendData += 					"<th>UC</th>";
				appendData += 					"<th># in DB</th>";
				appendData += 					"<th>Time scan</th>";
				appendData += 					"<th>DSS</th>";
				appendData += 				"</tr>";
				appendData +=			"</thead>";
				appendData +=			"<tbody>";
				appendData += 				"<tr>";
				appendData += 					"<td class='vuc'>"+$updatedCount+"</td>";
				appendData += 					"<td class='vdb'>"+$databaseCount+"</td>";
				appendData += 					"<td class='vts'>"+$timeToScan+"</td>";
				appendData += 					"<td class='vds'>"+$timeSinceScan+"</td>";
				appendData += 				"</tr>";
				appendData +=			"</tbody>";
				appendData += 		"</table>";
				appendData += 	"</div>";
				appendData += "</div>";
				appendData += "</div>";

				$('.display-more-report').append(appendData);	
		}
		function dbFeedCount($website, $name, $id, $dbCount, $feedCount, $differences){
		
			var appendData =  "<div class='col-sm-4 div-"+$website+"-site dbfc-results'>";
				appendData += "<div class='"+$website+"_color white_bg_color'>";
				appendData += 	"<div class='report-dbfc-data-title-div'>";
				appendData += 		"<div class='report-dbfc-data-title'>"+($name).toUpperCase()+" ("+$id+")</div>";
				appendData += 	"</div>";
				appendData += 		"<div class='report-dbfc-data'>";
				appendData +=			"<div>";
				appendData +=				"<span class='dbfc-text'>Website</span>";
				appendData +=				"<span class='dbfc-res div-"+$website.toLowerCase()+"-bgcolor-2'>"+$website.toUpperCase()+"</span>";
				appendData +=			"</div>";
				appendData +=			"<div>";
				appendData +=				"<span class='dbfc-text'>Database Count</span>";
				appendData +=				"<span class='dbfc-res div-"+$website.toLowerCase()+"-bgcolor-2'>"+$dbCount+"</span>";
				appendData +=			"</div>";
				appendData +=			"<div>";
				appendData +=				"<span class='dbfc-text'>Feed Count</span>";
				appendData +=				"<span class='dbfc-res div-"+$website.toLowerCase()+"-bgcolor-2'>"+$feedCount+"</span>";
				appendData +=			"</div>";
				appendData +=			"<div>";
				appendData +=				"<span class='dbfc-text'>% DB/FC</span>";
				appendData +=				"<span class='dbfc-res div-"+$website.toLowerCase()+"-bgcolor-2'>"+Math.round($differences)+"% </span>";
				appendData +=			"</div>";
				appendData += 		"</div>";
				appendData += "</div>";
				appendData += "</div>";
				$(".display-more-report").append(appendData);
		}

		function addHeaderClass($classTarget,$site){
			$($classTarget).removeClass('aks_bg_color');
			$($classTarget).removeClass('cdd_bg_color');
			$($classTarget).removeClass('brexitgbp_bg_color');
			$($classTarget).removeClass('default_bg_color');
			$($classTarget).removeClass('danger_bg_color');

			switch($site){
				case 'aks':
					$($classTarget).addClass('aks_bg_color');
				break;
					
				case 'cdd':
					$($classTarget).addClass('cdd_bg_color');
				break;

				case 'brexitgbp':
				case 'brexit':
					$($classTarget).addClass('brexitgbp_bg_color');
				break;
				case 'store':
				case 'metacritics':
					$($classTarget).addClass('danger_bg_color');
				break;
				default:
					$($classTarget).addClass('default_bg_color');
				break;
			}
			

		}

		function addPointerEvents($to ,$classTarget = ""){
			$('.card-body-div-sub').removeClass('div-disabled');
			$('.view-more-icon').removeClass('pointer-events-none');
			$('.card-body-div-sub-span').removeClass('pointer-events-none');

			switch($to){
				case 'Store':
				case 'Metacritics':
				case 'AKS':
				case 'CDD':
				case 'BREXIT':
				case 'AKSDB':
				case 'CDDDB':
				case 'BREXITDB':
					$('.card-body-div-sub').addClass('div-disabled');
					$('.view-more-icon').addClass('pointer-events-none');
					$('.card-body-div-sub-span').addClass('pointer-events-none');
				break;
			}

		}

		function removedPointerEvents($to ,$classTarget = ""){
			switch($to){
				case 'Store':
				case 'Metacritics':
				case 'AKS':
				case 'CDD':
				case 'BREXIT':
				case 'AKSDB':
				case 'CDDDB':
				case 'BREXITDB':
					$('.card-body-div-sub').removeClass('div-disabled');
					$('.view-more-icon').removeClass('pointer-events-none');
					$('.card-body-div-sub-span').removeClass('pointer-events-none');
				break;
			}
		}

function callChangelogs(){
	$('.ccd-con-wrapper').empty();

	var dataRequest =  { 
		action: 'displayAddChangeLogAction',
	}
	AjaxCall(url, dataRequest).done(function(data){
		for (var i in data){
			var matches = data[i].inputMessage.match(/\n/g);

			if(matches){
				var txt = data[i].inputMessage.split("\n");

				var appendDate = '<div class="changelog-content-div">';
					appendDate += '<p class="ccd-header"><i class="fas fa-user-tie ccd-icon"></i> <span class="ccd-name">'+ data[i].inputAuthor.charAt(0).toUpperCase() + data[i].inputAuthor.slice(1) +'</span></p>';
					appendDate += '<p class="ccd-date" style="padding-bottom: 20px;">'+ data[i].inputDate +'</p>';
					$.each(txt, function(t){
						if(txt[t] != ''){
							appendDate += '<p style="margin: 0 0 0 20px;" class="cdd-txt"><i class="fas fa-circle" style="font-size: 5px;top: -2px;position: relative;"></i> '+ txt[t] +'</p>'; 
						}
					});	
					$(".ccd-con-wrapper").append(appendDate);
			}else{
				var appendDate = '<div class="changelog-content-div">';
					appendDate += '<p class="ccd-header"><i class="fas fa-user-tie ccd-icon"></i> <span class="ccd-name">'+ data[i].inputAuthor.charAt(0).toUpperCase() + data[i].inputAuthor.slice(1) +'</span></p>';
					appendDate += '<p class="ccd-date" style="padding-bottom: 20px;">'+ data[i].inputDate +'</p>';
					appendDate += '<p style="margin: 0 0 0 20px;" class="cdd-txt"><i class="fas fa-circle" style="font-size: 5px;top: -2px;position: relative;"></i> '+ data[i].inputMessage  +'</p>'; 
					
					$(".ccd-con-wrapper").append(appendDate);
			}
		}				
	}).always(function(){});
}