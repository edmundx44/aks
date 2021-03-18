
<?php $this->start('head'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript">

	let donot1;
	let donot2;
	let donot3;
	let checksumChart;

	$(function (){	
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

	});

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
</script>

<?php $this->end(); ?>

<?php $this->start('body')?>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 mtop-35px">
			<div class="card card-style">
				<div class="card-body no-padding row-1-card-body"> 
					<div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-1">
						<p style="position: relative;top: 20px; padding-left:20px; padding-right:20px;color: #fff;letter-spacing: 1px;">Header</p>
						<p style="position: relative;top: 3px; padding-left:20px; padding-right:20px;color: #fff;font-size: 13px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
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
			<div class="card card-style">
				<div class="card-header no-padding row-2-card-header" style=""> 
					<div class="text-center card-div-overflow-style row-2-card-div-overflow-style row-2-card-div-overflow-style-1">
						<i class="fa fa-ban row-2-icon" aria-hidden="true"></i>
					</div>
					<p class="card-title-p" style="position: absolute; top:15px;right: 15px;color: #000;"> 21 - 130</p>
					<p class="card-val-p" style="position: absolute; top:38px;right: 15px;color: #000;font-size: 18px;letter-spacing: 1px;font-weight: 500;">Disabled</p>
					<p class="card-val-p" style="position: absolute; top:65px;right: 15px;color: #000;font-size: 15px;letter-spacing: 1px;font-weight: 500;">Default - STORE</p>
				</div>
				<div class="card-body no-padding" style="padding-bottom: 15px !important;">
					<div style="width: 100%;height:30px;"> 
						<div class="pull-right" style="position: relative;	top:10px;color: #999;cursor: pointer;"><i class="fa fa-eye" aria-hidden="true"> </i> <span class="" style="font-size: 14px;position: relative;	top:-1px;">view more</span></div>
						
						<i class="fa fa-sliders float-left" aria-hidden="true" style="position: relative;	top:11px;color: #999;font-size: 20px;cursor: pointer;"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xxl-6 col-xl-3 col-md-12 mtop-35px">
			<div class="card card-style">
				<div class="card-header no-padding row-2-card-header"> 
					<div class="text-center card-div-overflow-style row-2-card-div-overflow-style row-2-card-div-overflow-style-2">
						<i class="fa fa-snapchat row-2-icon" aria-hidden="true"></i>
					</div>
					<p class="card-title-p" style="position: absolute; top:15px;right: 15px;color: #000;">140</p>
					<p class="card-val-p" style="position: absolute; top:35px;right: 15px;color: #000;font-size: 18px;letter-spacing: 1px;font-weight: 500;"> Snapshot</p>
					<p class="card-val-p" style="position: absolute; top:65px;right: 15px;color: #000;font-size: 15px;letter-spacing: 1px;font-weight: 500;">Default - AKS</p>

				</div>
				<div class="card-body no-padding" style="padding-bottom: 15px !important;">
					<div style="width: 100%;height:30px;"> 
						<div class="pull-right" style="position: relative;	top:10px;color: #999;cursor: pointer;"><i class="fa fa-eye" aria-hidden="true"> </i> <span class="" style="font-size: 14px;position: relative;	top:-1px;">view more</span></div>
						
						<i class="fa fa-sliders float-left" aria-hidden="true" style="position: relative;	top:11px;color: #999;font-size: 20px;cursor: pointer;"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xxl-6 col-xl-3 col-md-12 mtop-35px">
			<div class="card card-style">
				<div class="card-header no-padding row-2-card-header"> 
					<div class="text-center card-div-overflow-style row-2-card-div-overflow-style row-2-card-div-overflow-style-3">
						<i class="fa fa-database row-2-icon" aria-hidden="true"></i>
					</div>
					<p class="card-title-p" style="position: absolute; top:15px;right: 15px;color: #000;">65</p>
					<p class="card-val-p" style="position: absolute; top:35px;right: 15px;color: #000;font-size: 18px;letter-spacing: 1px;font-weight: 500;"> DB Feed</p>
				</div>
				<div class="card-body no-padding" style="padding-bottom: 15px !important;">
					<div style="width: 100%;height:30px;"> 
						<div class="pull-right" style="position: relative;	top:10px;color: #999;cursor: pointer;"><i class="fa fa-eye" aria-hidden="true"> </i> <span class="" style="font-size: 14px;position: relative;	top:-1px;">view more</span></div>
						
						<i class="fa fa-sliders float-left" aria-hidden="true" style="position: relative;	top:11px;color: #999;font-size: 20px;cursor: pointer;"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xxl-6 col-xl-3 col-md-12 mtop-35px">
			<div class="card card-style">
				<div class="card-header no-padding row-2-card-header"> 
					<div class="text-center card-div-overflow-style row-2-card-div-overflow-style row-2-card-div-overflow-style-4">
						<i class="fa fa-random row-2-icon" aria-hidden="true"></i>
					</div>
					<p class="card-title-p" style="position: absolute; top:15px;right: 15px;color: #000;">0</p>
					<p class="card-val-p" style="position: absolute; top:35px;right: 15px;color: #000;font-size: 18px;letter-spacing: 1px;font-weight: 500;">Random</p>
				</div>
				<div class="card-body no-padding" style="padding-bottom: 15px !important;">
					<div style="width: 100%;height:30px;"> 
						<div class="pull-right" style="position: relative;	top:10px;color: #999;cursor: pointer;"><i class="fa fa-eye" aria-hidden="true"> </i> <span class="" style="font-size: 14px;position: relative;	top:-1px;">view more</span></div>
						
						<i class="fa fa-sliders float-left" aria-hidden="true" style="position: relative;	top:11px;color: #999;font-size: 20px;cursor: pointer;"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4 mtop-35px">
			<div class="card card-style">
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
			<div class="card card-style">
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
			<div class="card card-style">
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
			<div class="card card-style">
				<div class="card-body no-padding row-4-card-body"> 
					<div class="card-div-overflow-style row-4-card-div-overflow-style row-4-card-div-overflow-style-1"> </div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-12 mtop-35px">
			<div class="card card-style">
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
