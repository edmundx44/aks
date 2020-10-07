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
		}

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
				dateNow: '2020-09-10'
			},
			success : function(data){
				for (var i in data){
					label.push(data[i].merchant_name)
					dataID.push(data[i].dataID)
				}
			},
			complete : function(){
				displayChart(label, dataID)
			}
		});
	}

	function displayChart($merchant, $checksumUpdate){
		//label
		var label = $merchant;

		//dataset
		var dataset = [{
			label: '# of Updates',
			data: $checksumUpdate, // value gikan database
			fill: true,
			backgroundColor: [
				'rgba(255, 99, 132, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(255, 206, 86, 0.2)',
				'rgba(75, 192, 192, 0.2)',
				'rgba(153, 102, 255, 0.2)',
				'rgba(255, 159, 64, 0.2)'
			],
			borderColor: [
				'rgba(255, 99, 132, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 206, 86, 1)',
				'rgba(75, 192, 192, 1)',
				'rgba(153, 102, 255, 1)',
				'rgba(255, 159, 64, 1)'
			],
			borderWidth: 1
		}];

		//data
		var datas = {
			labels: label,
			datasets: dataset
		}

		// option
		var option = {
			responsive: true,
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true
					},
					stacked: true,
					gridLines: {
						display: true,
						color: "rgba(255,215,0,0.2)"
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

}); // end docuemtn ready







	