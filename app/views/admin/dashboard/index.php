
<?php $this->start('head'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript">

	let donot1;
	let donot2;
	let donot3;
	let checksumChart;

	$(function (){
			$.when(displayReport('menu-disabled', 'Store'), displayReport('menu-snapshot', 'AKS'), displayReport('menu-dbfeed', 'AKS'));

			var ctx1 = document.getElementById('priceToZeroPercent-1').getContext('2d');//select a canvas
			var ctx2 = document.getElementById('priceToZeroPercent-2').getContext('2d');//select a canvas
			var ctx3 = document.getElementById('priceToZeroPercent-3').getContext('2d');//select a canvas

			var options = {
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
				    text: "Price to Zero",
				    fontSize: '14',
					fontColor: '#ededed',
				},
				layout: {
			        padding: {
			            left: 0,
			            right: 0,
			            top: 0,
			            bottom: 0
			        }
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
						//optional cutom tooltips
						//callbacks: {
						//     label: function(tooltipItem, $data) {
						//     	console.log($data['datasets'][0]['data'][tooltipItem['index']])
						//     	console.log($data['labels'])
						//     	return $data['labels'][tooltipItem['index']]+': '+$data['datasets'][0]['data'][tooltipItem['index']] + '%';
						//   }
						//}
					},
				};

			  //doughnut chart data
			  var data1 = {
			    labels: ["AKS", "CDD", "BREX"],
			    datasets: [
			      {
			        label: "Websites",
			        data: [30, 50 , 25],
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
			      }
			    ]
			  };

			 donot1 = new Chart(ctx1, {
			    type: "doughnut",
			    data: data1,
			    options: options,
			    plugins: [{
				    resize: function (myChart) {
				    	doughnutResize(myChart);
				    }
				}] 
			  });
			 donot2 = new Chart(ctx2, {
			    type: "doughnut",
			    data: data1,
			    options: options,
			    plugins: [{
				    resize: function (myChart) {
				    	doughnutResize(myChart);
				    }
				}] 
			  });
			 donot3 = new Chart(ctx3, {
			    type: "doughnut",
			    data: data1,
			    options: options,
			    plugins: [{
				    resize: function (myChart) {
				    	doughnutResize(myChart);
				    }
				}] 
			  });


		var ctx4 = document.getElementById('checksum-4').getContext('2d');
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
						label: 'AKS\tStatus (<?= date('M d', strtotime('today')) ?>)',
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
							fontStyle: "bold",
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

		checksumDone(checksumChart);
		
		doughnutResize(donot1,'mobile');
		doughnutResize(donot2,'mobile');
		doughnutResize(donot3,'mobile');
		
		//FOR TABBING CONTENT
		$(document).on('click','.clk-options', function(){
			//alert($(this).attr('id'));
			$('.content-hide').hide();
			$('.'+$(this).attr('id')).show();	
			$('.clk-options').removeClass('active-tab');
			$('#'+$(this).attr('id')).addClass('active-tab');

			if($(this).attr('id') != 'checksum-chart'){
				$('.dbox-content').css({'height':'80%'})
				$('.dbox-hide').hide();
			}else{
				$('.dbox-content').css({'height':'70%'})
				$('.dbox-hide').show();
			}
		});

		//FOR DROP DOWN SELECT ANIMATION
		$('.dropdown-div').click(function () {
			$(this).find('.dropdown-menu').slideToggle(200);
		});
		$('.dropdown-div').focusout(function () {
			$(this).find('.dropdown-menu').slideUp(200);
		});


		// menu icon click
		$(document).on('click', '.card-body-div-i', function(){
			switch($(this).data('what')){
				case 'menu-disabled':
					$('.menu-snapshot, .menu-dbfeed, .menu-others').hide();
					$('.'+$(this).data('what')).toggle();
				break;
				case 'menu-snapshot':
					$('.menu-disabled, .menu-dbfeed, .menu-others').hide();
					$('.'+$(this).data('what')).toggle();
				break;
				case 'menu-dbfeed':
					$('.menu-disabled, .menu-snapshot, .menu-others').hide();
					$('.'+$(this).data('what')).toggle();
				break;
				case 'menu-others':
					$('.menu-disabled, .menu-snapshot, .menu-dbfeed').hide();
					$('.'+$(this).data('what')).toggle();
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
				
				break;
				case 'menu-snapshot':
					displayMoreReport('menu-snapshot', $('.menu-snapshot-what').text())
					$('#reportModal').modal('show');
				break;
				case 'menu-dbfeed':
					displayMoreReport('menu-dbfeed', $('.menu-dbfeed-what').text())
					$('#reportModal').modal('show');
				break;
			}
		});

		$(document).on('click', function(event){    
			if(!$(event.target).is('.card-body-div-i, .menu-disabled *, .menu-snapshot *, .menu-dbfeed *, .menu-others *')) {
				$('.card-body-menu-div').hide();
			}
	});		

		

	});

	function displayReport($to, $what){
		var dataRequest =  {
				action: 'displayReport',
				to: $to,
				what: $what
			}

		AjaxCall(url+'dashboard', dataRequest).done(function(data) {
			switch(data.to){
				case 'Store':
					$('.disable-count').html(data.count);
					$('.disabled-what').html('Store');
				break;
				case 'Metacritics':
					$('.disable-count').html(data.count);
					$('.disabled-what').html('Metacritics');
				break;
				case 'AKS':
					$('.snapshot-count').html(data.count);
					$('.snapshot-what').html('AKS');
				break;
				case 'CDD':
					$('.snapshot-count').html(data.count);
					$('.snapshot-what').html('CDD');	
				break;
				case 'BREXIT':
					// $('.snapshot-count').html(data.count);
					// $('.snapshot-what').html('BREXIT');	
				break;
				case 'AKSDB':
					$('.dbfeed-count').html(data.count);
					$('.dbfeed-what').html('AKS');	
				break;
				case 'CDDDB':
					$('.dbfeed-count').html(data.count);
					$('.dbfeed-what').html('CDD');	
				break;
				case 'BREXITDB':
					$('.dbfeed-count').html(data.count);
					$('.dbfeed-what').html('BREXIT');		
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

		AjaxCall(url+'dashboard', dataRequest).done(function(data) {
			switch(data.to){
				case 'Store':
					$('.display-more-report').empty();
					$('.report-modal-header').html('Disabled Store');
					for (var i in data.data){

						disabledDiv(data.data[i].store, data.data[i].id);
					}
				break;
				case 'Metacritics':
					$('.display-more-report').empty();
					$('.report-modal-header').html('Disabled Metacritics');
				break;
				case 'AKS':
					$('.display-more-report').empty();
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
							((data.data[i].timeSinceScan).toUpperCase()).replace('/H/g', 'H ')
						);
					}
				break;
				case 'CDD':
					$('.display-more-report').empty();
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
							((data.data[i].timeSinceScan).toUpperCase()).replace('/H/g', 'H ')
						);
					}
				break;
				case 'BREXIT':
					$('.display-more-report').empty();
				break;
				case 'AKSDB':
					$('.display-more-report').empty();
					$('.report-modal-header').html('AKS DB/FEED COUNT');

					for(var i in data.data){
						dbFeedCount(data.data[i].website, data.data[i].name, data.data[i].merchant_id, data.data[i].dbCount, data.data[i].feedCount, data.data[i].differences);
					}
				break;
				case 'CDDDB':
					$('.display-more-report').empty();
					$('.report-modal-header').html('CDD DB/FEED COUNT');

					for(var i in data.data){
						dbFeedCount(data.data[i].website, data.data[i].name, data.data[i].merchant_id, data.data[i].dbCount, data.data[i].feedCount, data.data[i].differences);
					}
				break;
				case 'BREXITDB':
					$('.display-more-report').empty();
					$('.report-modal-header').html('BREXIT DB/FEED COUNT');

					for(var i in data.data){
						dbFeedCount(data.data[i].website, data.data[i].name, data.data[i].merchant_id, data.data[i].dbCount, data.data[i].feedCount, data.data[i].differences);
					}	
				break;
			}
		});

		$('.card-body-menu-div').hide();
	}


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

	function checksumDone(myChart){
		//Dapat e replace sa naku ang mga space ' ' into \n ang label
		var dataCount = [];
		var chklabels = ['2game','Voidu','Greenman gaming','Livecards_es','Kinguin','Eneba','Royal Key Software','Electronic First'];
		var checksumLastUpdate = [1614671906,1614669606,1614667906,1614667906,1614666906,1614666906,1614665606,1614665606];
		for(var i in chklabels){
			chklabels[i] = (/(\s|_)/.test(chklabels[i])) ? chklabels[i].replace(/(\s|_)/g,'\n') : chklabels[i];
			dataCount.push(chklabels[i]);
		}
		var checksumLabel = dataCount;
		myChart.data.labels = checksumLabel;
		myChart.data.datasets[0].data = checksumLastUpdate;
		myChart.update();
	}

		//IF USED THID change first the type of the chart from bar to derivedBar
		// //for type derivedDoughnut
		// Chart.defaults.derivedDoughnut = Chart.defaults.doughnut;
		// var customDoughnut = Chart.controllers.doughnut.extend({
		//   //optional custom
		//    draw: function(ease) {
		//    Chart.controllers.doughnut.prototype.draw.apply(this, [ease]);
		// 	    //var width = this.chart.chart.width,
		// 	    //   height = this.chart.chart.height,
		// 	    //   titleHeight = this.chart.titleBlock.height,
		// 	    //   legendHeight = this.chart.legend.height;
		// 	    // //var total = this.getMeta().total;
		// 	    // var fontSize = (height / 114).toFixed(2);
		// 	    // var ctx = this.chart.chart.ctx;
		// 	    // ctx.font = fontSize + "em Verdana";
		// 	    // ctx.textBaseline = "middle";
		// 	    // ctx.textAlign = 'left';
		// 	    // var text = 'HELLO',
		// 	    //   textX= Math.round(this.chart.chart.width/2);
		// 	    //   textY= this.chart.chart.height/1.15;
		// 	    // ctx.fillText(text, textX, textY);
		//   	}
		// });
		// Chart.controllers.derivedDoughnut = customDoughnut;

		// Chart.defaults.derivedBar = Chart.defaults.bar; 
		// var customBar = Chart.controllers.bar.extend({
		//    draw: function(ease) {
		//    	Chart.controllers.bar.prototype.draw.apply(this, [ease]);
		//    		//console.log(this.chart.config.data.labels)
		// 	}
		// });
		// Chart.controllers.derivedBar = customBar;
		function disabledDiv($merchantName, $merchantID){
			var appendData = "<div class=''>";
				appendData += "<p>";
				appendData += "<span>"+$merchantName+"</span>";
				appendData += "<span> ("+$merchantID+") </span>";
				appendData += "</p>";
				appendData += "</div>";
				$('.display-more-report').append(appendData);
		}
		function snapshotDiv($merchantName,$merchantID,$resCalcData,$difference,$updatedCount,$databaseCount,$timeToScan,$timeSinceScan){

			var appendData =  "<div class='report-snapshot-con-wrap'>";
				appendData += 	"<div class='report-snapshot-data-title-div'>";
				appendData += 		"<div class='snap-margin pull-left report-snapshot-data-title'> "+$merchantName+" ("+$merchantID+")</div>";
				appendData += 		"<div class='snap-margin div-"+$resCalcData+" pull-right'>"+$difference+"</div>";
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
				$('.display-more-report').append(appendData);	
		}
		function dbFeedCount($website, $name, $id, $dbCount, $feedCount, $differences){
			var appendData =  "<div class='div-"+$website+"-site' style='color:#fff;'>";
				appendData += "<div class='report-dbfc-data-title-div'>";
				appendData += "<div class='report-dbfc-data-title'>"+($name).toUpperCase()+" ("+$id+")</div>";
				appendData += "</div>";
				appendData += "<div class='report-dbfc-data'>";
				appendData += "<div>Website : "+($website).toUpperCase()+"";
				appendData += "<div>Database Count : "+$dbCount+"";
				appendData += "<div>Feed Count : "+$feedCount+"";
				appendData += "<div>% DB/FC : "+Math.round($differences)+"% </div>"
				appendData += "</div>";
				appendData += "</div>";
				$(".display-more-report").append(appendData);
		}

</script>
<style type="text/css">
.div-green-dif {
	background-color: #4caf50;
}
.div-yellow-dif {
	background-color: #f6c23e;
}

/*----------------------- SNAPSHOT AKS , CDD DIV  and DBFC --------------------------*/
.vuc{ width: 20%; }
.vdb{ width: 20%; }
.vts,.vds { 
	width: 30%; 
	word-break: break-word;
}
.snapshot-div tbody td,
.snapshot-div thead th {
	padding: 2px 5px 2px 5px !important;
	text-align: center;
	border: solid 1px #d2d2d2 !important;
}
.snap-margin {
	margin-bottom: 5px;
	margin-top: 5px;
}
.snapshot-div{ margin-bottom: 0 !important; }
.report-snapshot-con-wrap,
.report-dbfc-con-wrap {
	padding-left: 20px;
	padding-right: 20px;
	font-size: 12px;
}

.report-snapshot-con-wrap { margin-bottom: 10px; }
.report-snapshot-data-title-div{ 
	padding: 2px 4px 2px 4px; 
	background-color: #edf0f5;
}

.custom-width-th{ width: 45px !important; }

.div-green-dif {
	background-color: #4caf50;
}
.div-yellow-dif {
	background-color: #f6c23e;
}
.div-green-dif,
.div-yellow-dif {
    width: 20%;
    text-align: center;
}
.div-brexitgbp-site,
.div-aks-site,
.div-cdd-site {
	margin-bottom: 10px;
	/*border-radius: 5px;*/
}
.div-aks-site {
	background-color: #4caf50;
}
.div-cdd-site {
	background-color: #f6c23e;
}
.div-brexitgbp-site{
	/*background-color: #00d6f2;*/ /*bot admin gbp color*/
	background-color: rgb(51, 122, 183);
}
.report-dbfc-data-title-div {
	padding: 10px;
	padding-bottom: 0;
}
.report-dbfc-data-title {
	font-size: 13px;
}
.report-dbfc-data {
	padding: 10px;
	padding-top: 0;
}
.btn-dbfc-sites {
	padding-right: 20px; 
	padding-left: 20px;
	position: sticky;
	top: 0;
	border-bottom: 1px solid white;
}
.btn-dbfc-sites {
	display: none;
}
.report-dbfc-con-wrap {
	margin-top: 45px !important; /* First child selector*/
}
.add-margin-top {
	margin-top: 45px;
}

/*card codes start ---------------------------------*/
.card-bulletin {
	position: relative;
	top: 20px; 
	padding-left:20px; 
	padding-right:20px;
	color: #fff;
	letter-spacing: 1px;
}
.card-bulletin-desc{
	position: relative;
	top: 3px; 
	padding-left:20px; 
	padding-right:20px;
	color: #fff;
	font-size: 13px;
}
.card-title-p {
	position: absolute; 
	top:15px;
	right: 15px;
}
.card-val-p {
	position: absolute; 
	top:38px;
	right: 15px;
	font-size: 18px;
	letter-spacing: 1px;
	font-weight: 500;
}
.card-val-p-sub {
	position: absolute; 
	top:65px;
	right: 15px;
	font-size: 15px;
	letter-spacing: 1px;
	font-weight: 500;
}
.card-body-style {
	padding-bottom: 15px !important;
}
.card-body-div {
	width: 100%;
	height:30px;
}
.card-body-div-sub {
	position: relative;	
	top:10px;
	color: #999;
	cursor: pointer;
}
.card-body-div-sub-span {
	font-size: 14px;
	position: relative;	
	top:-1px;
}
.card-body-div-i {
	position: relative;	
	top:11px;
	color: #999;
	font-size: 20px;
	cursor: pointer;
}
.card-body-div-i:hover{
	margin-left: -2px;
	margin-top: -2px;
	font-size: 25px;
	transition: all .1s ease-in-out;
	color: #6b6d70 !important;
}

.card-body-menu-div {
	top: 9px;
	left: 45px;
	width: 150px;
	height: 125px;
	border-radius: 5px;
	background-color: #fff;
	box-shadow: 0 2px 10px 0 rgb(0 0 0 / 26%);
	position: absolute;
	z-index: 1;
	display: none;
}
.card-body-menu-div:after {
	position: absolute;
    content: "";
    width: 0;
    height: 0;
    bottom: 10px;
    left: 1px;
    box-sizing: border-box;
    border: 5px solid black;
    border-color: transparent transparent #fff #fff;
    transform-origin: 0 0;
    transform: rotate(45deg);
    box-shadow: -1px 1px 3px 0 rgb(0 0 0 / 20%);
}
.card-body-menu-div-ul {
	list-style-type: none;
	padding: 0;
	font-size: 14px;
	position: absolute;
	bottom: -10px;
	width: 100%;

}
.card-body-menu-div-li {
	padding: 5px 5px 5px 15px;
	letter-spacing: 1px;
	font-weight: 700;
	cursor: pointer;
}
.card-body-menu-div-li:hover > .cbm-span {
	text-decoration: underline;
}

.cbm-span {
	margin-left: 5px;
}
/*.cbm-span:hover {
	
}*/

/*card codes end -----------------------------------*/
.ul-tab-option {
	list-style-type: none; 
	margin: 0;
	padding: 0;
}
.ul-tab-option li {
	border-radius: 5px;
    display: inline-block;
    padding: 10px;
}
.active-tab {
    background-color: #fff;
    color: #004ea3;
}
.li-tab-option{
	border: none;
	font-weight: 700;
	cursor: pointer;
}
.li-tab-option:hover{
	background-color: #fff;
	color: #004ea3;
}


.dropdown-menu{
	min-width: 150px;
}

.dropdown-div {
  width: 100%;
  display: inline-block;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 0 2px rgb(204, 204, 204);
  transition: all .5s ease;
  position: relative;
  font-size: 14px;
  color: #474747;
  height: 100%;
  text-align: left;
  z-index: 999;
}
.dropdown-div .select {
    cursor: pointer;
    display: block;
    padding: 10px;
    background-color: #3f51b5;
    color: #fff;
}
.dropdown-div .select > i {
    font-size: 13px;
    color: #fff;
    cursor: pointer;
    transition: all .3s ease-in-out;
    float: right;
    line-height: 20px
}
.dropdown-div:hover {
    box-shadow: 0 0 4px rgb(204, 204, 204)
}
.dropdown-div:active {
    background-color: #f8f8f8
}
.dropdown-div .dropdown-menu {
    position: absolute;
    background-color: #fff;
    width: 100%;
    left: 0;
    margin-top: 1px;
    box-shadow: 0 1px 2px rgb(204, 204, 204);
    border-radius: 0 1px 2px 2px;
    overflow: hidden;
    display: none;
    overflow-y: auto;
    z-index: 9
}
.dropdown-div .dropdown-menu li {
    padding: 10px;
    transition: all .2s ease-in-out;
    cursor: pointer
} 
.dropdown-div .dropdown-menu {
    padding: 0;
    list-style: none
}
.dropdown-div .dropdown-menu li:hover {
    background-color: #f2f2f2
}
.dropdown-div .dropdown-menu li:active {
    background-color: #e2e2e2
}
.custom-bkgd{
	border-radius: 5px;
	background: linear-gradient(60deg, #004ea3, #0062cc);
	font-weight: bold;
}
.cos-dropdown-menu li:hover{
	background: linear-gradient(60deg, #004ea3, #0062cc);
	color: white;
	transition: all .09s ease-in-out;
	font-weight: bold;
}


</style>
<?php $this->end(); ?>

<?php $this->start('body')?>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-body no-padding row-1-card-body"> 
					<div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-1">
						<p class="card-bulletin">Bulletin</p>
						<p class="card-bulletin-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
					</div>
				</div>
			</div>

		</div>
		<!-- <div class="col-lg-6 col-md-12 mtop-35px">
			<div class="card card-style">
				<div class="card-body no-padding row-1-card-body"> 
					<div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-2"> </div>
				</div>
			</div>
		</div> -->
	</div>

	<div class="row">
		<div class="col-xxl-6 col-xl-3 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-2-card-header" style=""> 
					<div class="text-center card-div-overflow-style row-2-card-div-overflow-style row-2-card-div-overflow-style-1">
						<i class="fa fa-ban row-2-icon" aria-hidden="true"></i>
					</div>
					<p class="card-title-p card-title-p-normal disable-count"></p>
					<p class="card-val-p card-val-p-normal">Disabled</p>
					<p class="card-val-p-sub card-val-p-sub-normal"><span class="disabled-what menu-disabled-what"></span> - SELECTED</p>
				</div>
				<div class="card-body no-padding card-body-style">
					<div class="card-body-div"> 
						<div class="pull-right card-body-div-sub">
							<i class="fa fa-eye view-more-icon" aria-hidden="true" data-to="menu-disabled"> </i> 
							<span class="card-body-div-sub-span" data-to="menu-disabled">view more</span>
						</div>
						
						<i class="fa fa-sliders float-left card-body-div-i" data-what="menu-disabled" aria-hidden="true"></i>
						<div class="card-body-menu-div menu-disabled">
							<ul class="card-body-menu-div-ul">
								<li class="card-body-menu-div-li" data-to="menu-disabled"  data-what="Store"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Store</span></li>
								<li class="card-body-menu-div-li" data-to="menu-disabled"  data-what="Metacritics"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Metacritics</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xxl-6 col-xl-3 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-2-card-header"> 
					<div class="text-center card-div-overflow-style row-2-card-div-overflow-style row-2-card-div-overflow-style-2">
						<i class="fa fa-snapchat row-2-icon" aria-hidden="true"></i>
					</div>
					<p class="card-title-p card-title-p-normal snapshot-count"></p>
					<p class="card-val-p card-val-p-normal"> Snapshot</p>
					<p class="card-val-p-sub card-val-p-sub-normal"><span class="snapshot-what menu-snapshot-what"></span> - SELECTED</p>

				</div>
				<div class="card-body no-padding card-body-style">
					<div class="card-body-div"> 
						<div class="pull-right card-body-div-sub">
							<i class="fa fa-eye view-more-icon" aria-hidden="true" data-to="menu-snapshot"> </i> 
							<span class="card-body-div-sub-span" data-to="menu-snapshot">view more</span>
						</div>
						
						<i class="fa fa-sliders float-left card-body-div-i" data-what="menu-snapshot" aria-hidden="true"></i>
						<div class="card-body-menu-div menu-snapshot">
							<ul class="card-body-menu-div-ul">
								<li class="card-body-menu-div-li" data-to="menu-snapshot" data-what="AKS"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">AKS</span></li>
								<li class="card-body-menu-div-li" data-to="menu-snapshot" data-what="CDD"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">CDD</span></li>
								<li class="card-body-menu-div-li" data-to="menu-snapshot" data-what="BREXIT"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">BREXIT</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xxl-6 col-xl-3 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-2-card-header"> 
					<div class="text-center card-div-overflow-style row-2-card-div-overflow-style row-2-card-div-overflow-style-3">
						<i class="fa fa-database row-2-icon" aria-hidden="true"></i>
					</div>
					
					<p class="card-title-p card-title-p-normal dbfeed-count"></p>
					<p class="card-val-p card-val-p-normal"> DB Feed</p>
					<p class="card-val-p-sub card-val-p-sub-normal"><span class="dbfeed-what menu-dbfeed-what"></span> - SELECTED</p>
				</div>
				<div class="card-body no-padding card-body-style">
					<div class="card-body-div"> 
						<div class="pull-right card-body-div-sub">
							<i class="fa fa-eye view-more-icon" aria-hidden="true" data-to="menu-dbfeed"> </i> 
							<span class="card-body-div-sub-span" data-to="menu-dbfeed">view more</span>
						</div>
						
						<i class="fa fa-sliders float-left card-body-div-i" data-what="menu-dbfeed" aria-hidden="true" ></i>
						<div class="card-body-menu-div menu-dbfeed">
							<ul class="card-body-menu-div-ul">
								<li class="card-body-menu-div-li" data-to="menu-dbfeed" data-what="AKS"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">AKS</span></li>
								<li class="card-body-menu-div-li" data-to="menu-dbfeed" data-what="CDD"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">CDD</span></li>
								<li class="card-body-menu-div-li" data-to="menu-dbfeed" data-what="BREXIT"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">BREXIT</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xxl-6 col-xl-3 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-2-card-header"> 
					<div class="text-center card-div-overflow-style row-2-card-div-overflow-style row-2-card-div-overflow-style-4">
						<i class="fa fa-random row-2-icon" aria-hidden="true"></i>
					</div>
					<p class="card-title-p card-title-p-normal">0</p>
					<p class="card-val-p card-val-p-normal">Others</p>
				</div>
				<div class="card-body no-padding card-body-style">
					<div class="card-body-div"> 
						<div class="pull-right card-body-div-sub">
							<i class="fa fa-eye view-more-icon" aria-hidden="true"> </i> 
							<span class="card-body-div-sub-span">view more</span>
						</div>
						
						<i class="fa fa-sliders float-left card-body-div-i" data-what="menu-others" aria-hidden="true"></i>
						<div class="card-body-menu-div menu-others">
							<ul class="card-body-menu-div-ul">
								<li class="card-body-menu-div-li"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Others</span></li>
								<li class="card-body-menu-div-li"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Others</span></li>
								<li class="card-body-menu-div-li"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Others</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-3-card-header"> 
					<div class="card-div-overflow-style row-3-card-div-overflow-style row-3-card-div-overflow-style-1" style="padding: 10px;height: 210px;"> 
						<canvas id="priceToZeroPercent-1" class="priceToZeroPercent-canvas" height="120"></canvas>
					</div>
				</div>
				<div class="card-body">
					
				</div>
			</div>
		</div>
		<div class="col-md-4 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-3-card-header"> 
					<div class="card-div-overflow-style row-3-card-div-overflow-style row-3-card-div-overflow-style-2" style="padding: 10px;height: 210px;">
						<canvas id="priceToZeroPercent-2" class="priceToZeroPercent-canvas" height="120"></canvas>
					</div>
				</div>
				<div class="card-body">
					
				</div>
			</div>
		</div>
		<div class="col-md-4 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-3-card-header"> 
					<div class="card-div-overflow-style row-3-card-div-overflow-style row-3-card-div-overflow-style-3" style="padding: 10px;height: 210px;">
						<canvas id="priceToZeroPercent-3" class="priceToZeroPercent-canvas" height="120"></canvas>
					</div>
				</div>
				<div class="card-body">
					
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-body no-padding row-4-card-body"> 
					<div class="card-div-overflow-style row-4-card-div-overflow-style row-4-card-div-overflow-style-1"> </div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-body no-padding row-4-card-body"> 

					<div class="card-div-overflow-style row-4-card-div-overflow-style row-4-card-div-overflow-style-2" style="color: white;"> 
						<div style="padding-top: 20px; padding-left: 10px;">
							<ul class="ul-tab-option">
								<li>FEED BOTS: </li>
								<li class="clk-options li-tab-option active-tab" id="checksum-chart">
									<i class="fa a1 sidebar-menu-icon fa-bar-chart" aria-hidden="true" id="nav-icon"></i>
									<span>Checksum</span>
								</li>
								<li class="clk-options li-tab-option" id="test-box-2">
									<i class="fa a1 sidebar-menu-icon fa-check-square" aria-hidden="true" id="nav-icon"></i>
									<span>Success</span>
								</li>
								<li class="clk-options li-tab-option" id="test-box-3"><span>Fail</span></li>
								<li class="clk-options li-tab-option" id="test-box-4"><span>Server Charge</span></li>
							</ul>
						</div>
					</div>
						<div class="dropdown-box dbox-hide" style="padding-bottom: 5px;">
							<div class="dropdown-div" style="width: 150px;">
								<div class="select custom-bkgd">
					                <span class="selected-data change-site">Website</span>
					                <span class="pull-right"><i class="fa fa-caret-down" aria-hidden="true"></i></span>
					            </div>
								<ul class="dropdown-menu cos-dropdown-menu">
				                    <li class='opt-site-chk' data-website="aks">AKS</li>
				                    <li class='opt-site-chk' data-website="cdd">CDD</li>
				                    <li class='opt-site-chk' data-website="brexitgbp">BREXITGBP</li>
			                    </ul>
							</div>
							<div class="pull-right">
								<input style="color:#fff;" type="button" name="" class="m-d col-xs-3 btn custom-bkgd" id="btn-getchksumreports" value="TABLE" data-toggle="modal" data-target="#checksum-modal">
							</div>
						</div>
					<div class="card-style dbox-content" style="height: 70%; padding: 5px;">
						<div class="checksum-chart content-hide" style="height: 100%;">
							<canvas id="checksum-4" class="checksum-canvas"></canvas>
						</div>
						<div class="test-box-1 content-hide" style="height: 100%; display: none;">
							<h1>TEST BOX 1</h1>
						</div>
						<div class="test-box-2 content-hide" style="height: 100%; display: none;">
							<h1>TEST BOX 2</h1>
						</div>
						<div class="test-box-3 content-hide" style="height: 100%; display: none;">
							<h1>TEST BOX 3</h1>
						</div>
						<div class="test-box-4 content-hide" style="height: 100%; display: none;">
							<h1>TEST BOX 4</h1>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<style type="text/css">
.ul-tab-option {
	font-size: 13px;
	list-style-type: none; 
	margin: 0;
	padding: 0;
}
.ul-tab-option li {
	border-radius: 5px;
    display: inline-block;
    padding: 10px;
    /*padding: 5px 10px 5px 10px;*/
}
.active-tab {
    background-color: rgba(255, 255, 255, .2);
    color: #fff;
    /*color: #004ea3;*/
}
.li-tab-option{
	border: none;
	font-weight: 600;
	cursor: pointer;
}
.li-tab-option:hover{
	background-color: rgba(255, 255, 255, .2);
	color: #fff;

	-webkit-transition: .4s ease-in-out;
    -moz-transition: .4s ease-in-out;
    -o-transition: .4s ease-in-out;
    transition: .4s background-color ease-in-out ;
}


.dropdown-menu{
	min-width: 150px;
}

.dropdown-div {
  width: 100%;
  display: inline-block;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 0 2px rgb(204, 204, 204);
  transition: all .5s ease;
  position: relative;
  font-size: 14px;
  color: #474747;
  height: 100%;
  text-align: left;
  z-index: 999;
}
.dropdown-div .select {
    cursor: pointer;
    display: block;
    padding: 10px;
    background-color: #3f51b5;
    color: #fff;
}
.dropdown-div .select > i {
    font-size: 13px;
    color: #fff;
    cursor: pointer;
    transition: all .3s ease-in-out;
    float: right;
    line-height: 20px
}
.dropdown-div:hover {
    box-shadow: 0 0 4px rgb(204, 204, 204)
}
.dropdown-div:active {
    background-color: #f8f8f8
}
.dropdown-div .dropdown-menu {
    position: absolute;
    background-color: #fff;
    width: 100%;
    left: 0;
    margin-top: 1px;
    box-shadow: 0 1px 2px rgb(204, 204, 204);
    border-radius: 0 1px 2px 2px;
    overflow: hidden;
    display: none;
    overflow-y: auto;
    z-index: 9
}
.dropdown-div .dropdown-menu li {
    padding: 10px;
    transition: all .2s ease-in-out;
    cursor: pointer
} 
.dropdown-div .dropdown-menu {
    padding: 0;
    list-style: none
}
.dropdown-div .dropdown-menu li:hover {
    background-color: #f2f2f2
}
.dropdown-div .dropdown-menu li:active {
    background-color: #e2e2e2
}
.custom-bkgd{
	border-radius: 5px;
	background: linear-gradient(60deg, #004ea3, #0062cc);
	font-weight: bold;
}
.cos-dropdown-menu li:hover{
	background: linear-gradient(60deg, #004ea3, #0062cc);
	color: white;
	font-weight: bold;

	-webkit-transition: .4s ease-in-out;
    -moz-transition: .4s ease-in-out;
    -o-transition: .4s ease-in-out;
    transition: .4s background-color ease-in-out ;
}


/*-----     Modal TABLE */
.modal-con-override {
    background-color: #edf0f5;
}
.modal-checksum-data table thead tr {
    border: solid 1px #fff;
}
.modal-checksum-data table thead tr th{
    background-color: #fff;
}
.modal-checksum-data th:nth-child(1) {
    width: 25%; /*set width of 1st child*/
}
.table thead th,
.table td{
	border: none; /*remove border default of modal*/
	padding: 8px;
}
.table thead th{
	color: #0062cc;
}
.modal-checksum-data tbody .tbody-td-1,
.modal-checksum-data tbody .tbody-td-2,
.modal-checksum-data tbody .tbody-td-3 {
	border:solid 1px #fff;
}
.modal-checksum-data tbody .tbody-td-2 {
	word-break: break-all;
	width: 150px;
}
.modal-checksum-data tbody .tbody-td-3 {
	width: 100px;
}

</style>


<?php $this->end()?>
