$(document).ready(function(){

	var D = new Date();
	var dmonth = ((D.getMonth()+1) < 10) ? "0"+(D.getMonth()+1) : D.getMonth()+1;
	var dday = (D.getDate() < 10) ? "0"+D.getDate() : D.getDate();
	var strDate = dmonth + "/" + D.getDate() + "/" + D.getFullYear();
	var timeStampData = D.getFullYear() + '-' + dmonth + '-' + dday;
	var url = window.location.href;
	
	$('.alog-date').val(strDate);
	var getUserName = $('.sbp-user').text();
		if(getUserName != ''){
			displayIcon();
			if( url.match(/checker/) || url.match(/utilities/)){
				// alert('cheker this')
			}else{
				displayChangeLog();
				displayOffers(timeStampData);
				displayChecksumData(timeStampData);
				displayRunAndSuccess();
			}
		}

		
	$(document).on('click', '.show-extra-div', function(){
		$('.extra-div').fadeToggle();
	});
	
	$(document).on('click', '#show-log-div', function(){
		$('.welcome-div-sub-sub-new').toggleClass('add-height-1');
	});

	$(document).on('click', '.show-side-bar', function(){
		$('.side-bar').toggleClass('side-nav-view');
		$('.content-div').toggleClass('push-div');
		$('.dh-title').toggleClass('display-none-div')
		$('.dh-ul').toggleClass('position-left-element')
		
	});

	$(window).resize(function() {
		if ($(window).width() > 768) {
			$('.side-bar').removeClass('side-nav-view');
			$('.content-div').removeClass('push-div');
			$('.dh-title').removeClass('display-none-div')
			$('.dh-ul').removeClass('position-left-element')
		}
	});

	$(document).on('click', '.dropdown-li', function(){
		$('.sub-ul-nav').slideToggle('fast');
	});

	$(document).on('click', '.view-more-div', function(){
		var oldText = $(this).text();
		var newText = $(this).data('text');
		$(this).text(newText).data('text',oldText);
		$("."+$(this).attr('id')).toggleClass('add-height');
	});

	$(document).on('click', '.addChangeLog', function(){
		$.ajax({
			url : '/akss/dashboard/index',
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
	
	$(document).on('click', '#run', function(){
		
		var sel_merchant = $('.merchant-select').val();
		//alert(sel_merchant)
		$.ajax({
			url : '/akss/dashboard/index',
			type: "POST",
			data : {
				action: 'checksumStoreRun',
				store_receive: sel_merchant
			},
			success:function(data){
				alert(data);
			}
		});

	});

	$(document).on('keypress', '.chk-inputDate' ,function(e){
		let $dateInput = $('.chk-inputDate').val();
		var yearToday = $('.chk-inputDate').data('year');
		if(e.which == 13) {
			if($dateInput.length === 10){
				var inputMatch = $dateInput.match(/(^\d+)-(\d+)-(\d+)/);
				if(inputMatch == null){
					inputMatch = '';
				}else{
					var yyyy = inputMatch[1];
					var mm = inputMatch[2];
					var dd = inputMatch[3];
				}
				if($dateInput[4] === '-' && $dateInput[7] === '-' && $dateInput[4] != null && $dateInput[7] != null){
					if(yyyy >= 2020 && yyyy <= yearToday && mm != 0 && mm <= 12 && dd != 0 && dd <= 31){
							var $combine = yyyy+'-'+mm+'-'+dd;
							displayChecksumModal($combine);
					}else
						alert('CHECK YOUR DATE INPUT');
				}else
					alert('Dont remove the Hyphen');	
			}
			else
				alert('Lenth of the date in not equal to max set length');
		}
	});
	
}); // end docuemtn ready

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

function displayOffers($timeStampData) {
	var offers = [];

	var minusOneday = 1;
	var minusTwoday = 2;
	var minusThreeday = 3;
	    
	var onedayAgo = getDateMinus($timeStampData,minusOneday);
	var twodayAgo = getDateMinus($timeStampData,minusTwoday);
	var threedayAgo =getDateMinus($timeStampData,minusThreeday);

	$.ajax({
		url : '/akss/dashboard/index',
		type: "POST",
		data : {
			action: 'displayOffersAction'
		},
		success : function(data){
		//console.log(data)
            for (var i in data){                  
                var toPush = [
                    data[i].store_Id,
                    data[i].name+" "+data[i].realID,
                    data[i].total_offers,
                    data[i].date[threedayAgo],
                    data[i].date[twodayAgo],
                    data[i].date[onedayAgo],
                    data[i].date[$timeStampData],
                    ]
                offers.push(toPush);
            }
		},
		complete: function(){
		$(".div-loader").hide();
            //console.log(offers)
            $('#example').DataTable( {
                responsive: true,
                data: offers,
                columns: [
                    { title: "ID" },
                    { title: "MERCHANT" },
                    { title: "TOTAL OFFERS" },
                    { title: threedayAgo },
                    { title: twodayAgo },
                    { title: onedayAgo },
                    { title: $timeStampData },
                ]
            });
        }
	});
}

function displayChecksumData($dateNow){
	var label = [];
	var dataID = []
	$.ajax({
		url : '/akss/dashboard/index',
		type: "POST",
		data : {
			action: 'displayCheckSumAction',
			dateNow: $dateNow
		},
		success : function(data){
			for (var i in data){
				// if(data[i].dataID != 1){
					label.push(data[i].merchant_id)
					dataID.push(data[i].dataID)
				//}
			}
		},
		complete : function(){
			displayChart(label, dataID)
		}
	});
}

function displayChart($merchant, $checksumUpdate){
	var ctx = document.getElementById('myChart').getContext('2d');
	var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
		gradientStroke.addColorStop(0, 	'#f6c23e');
		gradientStroke.addColorStop(0.2,'#4caf50');
		gradientStroke.addColorStop(1, 	'#3f51b5');

	var gradientFill = ctx.createLinearGradient(500, 0, 100, 0);
		gradientFill.addColorStop(0, 	"rgba(246,194,62, 0.3)");
		gradientFill.addColorStop(0.2, 	"rgba(76,175,80, 0.3)");
		gradientFill.addColorStop(1, 	"rgba(63,81,181, 0.3)");

	var label = $merchant;
	var dataset = [{
		label: 'MOST UPDATES',
		data: $checksumUpdate, // value gikan database
		backgroundColor: gradientFill,
		borderColor: gradientStroke,
		pointBorderColor: gradientStroke,
		pointBackgroundColor: gradientStroke,
		pointHoverBackgroundColor: gradientStroke,
		pointHoverBorderColor: gradientStroke,
		pointBorderWidth: 10,
		pointHoverRadius: 10,
		pointHoverBorderWidth: 1,
		pointRadius: 2,
		fill: false,
		borderWidth: 1,
	}];

	var datas = {
		labels: label,
		datasets: dataset
	}
	var option = {
		hover: {
			onHover: function(e) {
				var point = this.getElementAtEvent(e);
				if (point.length) e.target.style.cursor = 'pointer';
				else e.target.style.cursor = 'default';
			}
		},
		responsive: true,
		legend: {
			display: true,
			labels: {
				fontColor: '#3f51b5',
				fontStyle: "bold",
			},
			onHover: function(e) {
				e.target.style.cursor = 'pointer';
			}
		},
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true,
					padding: 20
				},
				stacked: true,
				gridLines: {
					display: false,
					// color: "rgba(0,0,255, .2)"
				}
			}],
			xAxes: [{
				ticks: {
					beginAtZero: true,
					fontStyle: "bold",
					padding: 20
				},
				stacked: true,
				gridLines: {
					drawTicks: false,
					zeroLineColor: "transparent",
					display: true,
					color: "rgba(255,64,64, .2)"
				}
			}]
		}
	};

	// output
	var myChart = new Chart(ctx, {
		type: 'bar',
		data: datas,
		options: option
	});
}

function displayRunAndSuccess() {
	var dataCount = [];
	$.ajax({
		url : '/akss/dashboard/index',
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

function displayReportChart($data){
	var ctx = document.getElementById('reportChart').getContext('2d');
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
			// 'rgba(255, 99, 132, 1)',
			// 'rgba(0,250,154, 1)',
			// 'rgba(255, 206, 86, 1)',
			// 'rgba(75, 192, 192, 1)',
			// 'rgba(153, 102, 255, 1)',
			// 'rgba(255, 159, 64, 1)'
		],
		borderWidth: 1
	}];
	var datas = {
		labels: label,
		datasets: dataset
	}
	var myChart = new Chart(ctx, {
		type: 'polarArea',
		data: datas,
		options: {
			responsive: true,
			legend: {
				display: false,
				labels: {
					// fontColor: '#ffff'
			},
			position: 'left',
				onHover: function(e) {
					e.target.style.cursor = 'pointer';
				}
			},
			title: {
				display: true,
				fontColor: '#6b6d70',
				text: ['Charts report everyday', 'R e d - F a i l', 'G r e e n - S u c c e s s'],
				position: 'right'
			},
			scale: {
				ticks: {
					beginAtZero: true,
				},
				reverse: false,
				gridLines:{
					display : true,
						// color : '#fff',
				},
			}
		}
	});

}

function displayChangeLog(){
		$.ajax({
			url : '/akss/dashboard/index',
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
							appendDate += "<div class='addlog-header-name'>" + data[i].inputAuthor.charAt(0).toUpperCase() + data[i].inputAuthor.slice(1) + "</div>";
							appendDate += "<div class='addlog-header-date'>" + data[i].inputDate + "</div>";
							appendDate += "</div>";
							$(".change-log-div").append(appendDate);

						$.each(txt, function(t){
							if(txt[t] != ''){
								var append = "<li style='margin-top:5px;'>" + txt[t] + "." + "</li>";
								$(".change-log-div").append(append);
							}
						});

						var appendHr =  "<div class='addChanglog-line-bottom'></div>";
						$(".change-log-div").append(appendHr);
					}else{
						var append =  "<div class='addChanglog-header'>";
							append += "<div class='addlog-header-name'>" + data[i].inputAuthor.charAt(0).toUpperCase() + data[i].inputAuthor.slice(1) + "</div>";
							append += "<div class='addlog-header-date'>" + data[i].inputDate + "</div>";
							append += "</div>";
							append += "<li style='margin-top:5px;'>" + data[i].inputMessage + "." + "</li>";
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

function displayChecksumModal($dateInput){
	$(".table-checksum .checksum-body").empty();
	var container = $dateInput.match(/^\d+-(\d+)-(\d+)/);
	var monthR = container[1];
	var dayR = container[2];
	$.ajax({
		url : '/akss/dashboard/index',
		type: "POST",
			data : {
			action: 'displayChecksumUsingDateSend',
			getDateInput: $dateInput
		},
		success:function(data){
			//console.log(data);
			var result = data.success.data;
			for(var i in result){
				if(result[i].count != 0){
					var append =  "<tr class='getCount'>";
						append += 	'<td class="tbody-td-1">'+result[i].merchant_name+'('+result[i].merchant_id+')</td>';
						append += 	'<td class="tbody-td-2">'+result[i].checksum_data+'</td>';
						append += 	'<td class="tbody-td-3">'+result[i].lastupdate+'</td>';
						append += 	'<td class="tbody-td-1 text-center">'+result[i].count+'</td>';
						append += "</tr>";
					$(".table-checksum .checksum-body").append(append);
				}
			}
			
		},
	});
}

	/*** Minus Date ***/
	function getDateMinus($timeStampData,daysMinus){
		var dateString = $timeStampData;
		var date1 = new Date(dateString);
		date1.setDate(date1.getDate() - daysMinus);
			
		var dateResult = date1.toISOString();
		var matchDate = dateResult.match(/(^\d+\S\d+\S\d+)T/);
		return matchDate[1];
	}
	/*** Add Date ***/
	function getDateAdd($timeStampData,daysAdd){
		var dateString = $timeStampData;
		var date1 = new Date(dateString);
		date1.setDate(date1.getDate() + daysAdd);
			
		var dateResult = date1.toISOString();
		var matchDate = dateResult.match(/(^\d+\S\d+\S\d+)T/);
		return matchDate[1];
	}
	/*** Return Numbers only ***/
    function isNumber(evt) {
        evt = (evt) ? evt : window.event; //same result
        var charCode = (evt.which) ? evt.which : evt.keyCode; //same result
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }