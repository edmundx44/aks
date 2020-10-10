$(document).ready(function(){
	var D = new Date();
	var dmonth = ((D.getMonth()+1) < 10) ? "0"+(D.getMonth()+1) : D.getMonth()+1;
	var dday = (D.getDate() < 10) ? "0"+D.getDate() : D.getDate();
	var strDate = dmonth + "/" + D.getDate() + "/" + D.getFullYear();
	var timeStampData = D.getFullYear() + '-' + dmonth + '-' + dday;

	$('.alog-date').val(strDate);

	var getUserName = $('.dp-user').text();
		if(getUserName != ''){
			displayChangeLog();
			displayChecksumData(timeStampData);
			displayRunAndSuccess();
			displayIcon();
		}

	$(document).on('click', '.dropdown-li', function(){
		$('.sub-ul-nav').slideToggle();
	});

	$(document).on('click', '.list-bar', function(){
		$('.side-nav').toggleClass('side-nav-view');
	});
	
	$(document).on('click', '.div-arrow', function(){
		$('.content-wrap').toggleClass('n-height');
	
		if ($(".i-arrow").hasClass("fa-angle-double-down")){
   			$('.i-arrow').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
		} else {
   			$('.i-arrow').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
		}
	});

	$(document).on('click', '.addChangeLog', function(){
		$.ajax({
			url : '/aks/dashboard/index',
			type: "POST",
			data : {
				action: 'addChangeLogAction',
				inputID: $('.alog-id').val(),
				inputDate: $('.alog-date').val(),
				inputMessage: $('.alog-textarea').val()
			},
			success : function(data){
				window.location.reload();
			}
		});
	});


	// all custom function here -------------------------------------------------
	function displayChangeLog(){
		$.ajax({
			url : '/aks/dashboard/index',
			type: "POST",
			data : {
				action: 'displayAddChangeLogAction',
			},
			success : function(data){
				for (var i in data){

					var matches = data[i].inputMessage.match(/\n/g);
					if(matches){
						var txt = data[i].inputMessage.split("\n") 

						var appendDate =  "<div class='addChanglog-header'>";
							appendDate += "<div class='col-md-6 no-padding'>" + data[i].inputDate + "</div>";
							appendDate += "<div class='col-md-6 no-padding'> By : " + data[i].inputAuthor.charAt(0).toUpperCase() + data[i].inputAuthor.slice(1) + "</div>";
							appendDate += "</div>";
							$(".change-log-div").append(appendDate);

						$.each(txt, function(t){
							if(txt[t] != ''){
								var append = "<li>" + txt[t] + "</li>";
								$(".change-log-div").append(append);
							}
						});

						var appendHr =  "<div class='addChanglog-line-bottom'></div>";
						$(".change-log-div").append(appendHr);
					}else{
						var append =  "<div class='addChanglog-header'>";
							append += "<div class='col-md-6 no-padding'>" + data[i].inputDate + "</div>";
							append += "<div class='col-md-6 no-padding'> By : " + data[i].inputAuthor.charAt(0).toUpperCase() + data[i].inputAuthor.slice(1) + "</div>";
							append += "</div>";
							append += "<li>" + data[i].inputMessage + "</li>";
							append += "<div class='addChanglog-line-bottom'></div>";
							$(".change-log-div").append(append);  
					}
				}
			},
			complete:function(){
				$('.change-log-div .addChanglog-line-bottom:nth-last-child(1)').remove();
			}
		});
	}

	function displayChecksumData($dateNow){
		var label = [];
		var dataID = []
		$.ajax({
			url : '/aks/dashboard/index',
			type: "POST",
			data : {
				action: 'displayCheckSumAction',
				dateNow: $dateNow
			},
			success : function(data){
				for (var i in data){
					// if(data[i].dataID != 1){
						label.push(data[i].merchant_name)
						dataID.push(data[i].dataID)
					// }
				}
			},
			complete : function(){
				displayChart(label, dataID)
			}
		});
	}

	function displayRunAndSuccess() {
		var dataCount = [];
		$.ajax({
			url : '/aks/dashboard/index',
			type: "POST",
			data : {
				action: 'displayRunAndSuccessAction'
			},
			success : function(data){
				for (var i in data){
					dataCount.push(data[i].fail,data[i].success);
				}
			},
			complete: function(){
				displayReportChart(dataCount)
			}	
		});
	}

	function displayChart($merchant, $checksumUpdate){
		var label = $merchant;
		var dataset = [{
			label: 'Most updates',
			data: $checksumUpdate, // value gikan database
			fill: true,
			backgroundColor: [
				'rgba(12,238,108, .5)',
				
			],
			borderColor: [
				'rgba(255, 255, 255, 1)',
				'rgba(255, 255, 255, 1)',
				'rgba(255, 255, 255, 1)',
				'rgba(255, 255, 255, 1)',
				'rgba(255, 255, 255, 1)',
				'rgba(255, 255, 255, 1)',
			],
			borderWidth: 1
		}];
		var datas = {
			labels: label,
			datasets: dataset
		}
		var option = {
			responsive: true,
			legend: {
				labels: {
					fontColor: '#ffff'
				},
				onHover: function(e) {
					e.target.style.cursor = 'pointer';
				}
			},
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true,
						fontColor: '#fff'
					},
					stacked: true,
					gridLines: {
						display: true,
						color: "rgba(0,0,255, .2)"
					}
				}],
				xAxes: [{
					ticks: {
						beginAtZero: true,
						fontColor: '#fff'
					},
					stacked: true,
					gridLines: {
						display: true,
						color: "rgba(255,64,64, .2)"
					}
				}]
			}
		};

		// output
		var ctx = document.getElementById('myChart').getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'line',
			data: datas,
			options: option
		});
	}

	function displayReportChart($data){
		var label = ['Fail', 'Success'];
		var dataset = [{
			label: '# of Votes',
			data: $data, // value gikan database
			backgroundColor: [
				'rgba(255, 99, 132, 0.7)',
				'rgba(0,250,154, 0.7)',
				'rgba(255, 206, 86, 0.7)',
				'rgba(75, 192, 192, 0.7)',
				'rgba(153, 102, 255, 0.7)',
				'rgba(255, 159, 64, 0.7)'
			],
			borderColor: [
				'rgba(255, 99, 132, 1)',
				'rgba(0,250,154, 1)',
				'rgba(255, 206, 86, 1)',
				'rgba(75, 192, 192, 1)',
				'rgba(153, 102, 255, 1)',
				'rgba(255, 159, 64, 1)'
			],
			borderWidth: 1
		}];
		var datas = {
			labels: label,
			datasets: dataset
		}
		var ctx = document.getElementById('reportChart').getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'polarArea',
			data: datas,
			options: {
				responsive: true,
				legend: {
					labels: {
						fontColor: '#ffff'
					},
					position: 'right',
						onHover: function(e) {
							e.target.style.cursor = 'pointer';
						}
					},
					title: {
						display: true,
						fontColor: '#fff',	
						text: 'Charts report everyday',
					},
					scale: {
						ticks: {
							beginAtZero: true,
						},
						reverse: false,
						gridLines:{
							display : true,
							color : '#fff',
						},

					}
				}
		});
	}

	function displayIcon(){
		var iconList = [
			"fa-bar-chart",
			"fa-briefcase",
			"fa-exchange",
			"fa-commenting",
			"fa-cog"
		];
	
		$('i#nav-icon').each(function(i){
			$(this).addClass(iconList[i])
		});
	}

}); // end docuemtn ready







	