$('.content-loader-div').hide()

var today = new Date();
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
	var yyyy = today.getFullYear();
		today = yyyy + '-' + mm + '-' + dd;
	var first_day_of_month =  yyyy + '-' + mm + '-' + '01';

	$(function(){
		$("#date-start, #date-end").datepicker({ dateFormat: 'yy-mm-dd' });
		$('#date-start').val(first_day_of_month);
		$('#date-end').val(today);
		var $_firstquery = { action: "user-activities", dateStart: $('#date-start').val(), dateEnd: $('#date-end').val() };
		if( ($('#date-start').val() && $('#date-end').val() ) != '' )
			if(dateValidLen($('#date-start').val()) && dateValidLen($('#date-end').val())) startAjax($_firstquery)

		$(document).on('click', '.ac-add-filter', function(){ $('.filter-functions').slideToggle('fast'); });
		$(document).on('click' , '#date-submit-filter', function(){
			let dateStart = $('#date-start').val();
			let dateEnd   = $('#date-end').val();
			var $_query = { action: "user-activities", dateStart: dateStart, dateEnd: dateEnd };
			if( (dateStart || dateEnd) == '' ){
				alertMsg("Please input a correct date", "bg-danger")
			}else{
				if(dateValidLen(dateStart) && dateValidLen(dateEnd)) startAjax($_query)
				else alertMsg("Please input a correct date", "bg-danger")
			}
		});
	//END 
	});

	function startAjax($_query) {
		AjaxCall(url,$_query).done(AjaxSuccess);
	}

	function AjaxSuccess(data){
		//console.log(data)
		var items = [];
		for (var i in data){    
			var employee = (data[i].worker != null ) ? data[i].worker : 0 ;
			var created = (data[i].created != null ) ? data[i].created : 0 ;
			var modified = (data[i].modified != null ) ? data[i].modified : 0 ;
			var changedPrice = (data[i].changed_price != null ) ? data[i].changed_price : 0 ;
			var opens = (data[i].opens != null ) ? data[i].opens : 0 ;
			var total = Number(created) + Number(modified) + Number(changedPrice) + Number(opens); 
			var toPush = [ employee, created, modified , changedPrice , opens, total]
			items.push(toPush);
		}
		$('#user-counts-table').show();
		if(items != null){
			$('#user-counts-table').DataTable({
				destroy: true,
				responsive: true,
				pageLength: 25,
				lengthMenu: [[25, 50, 100, -1],[25, 50, 100, "All"]], // Sets up the amount of records to display
				scrollX: 420,
				data: items,
				search: { "addClass": 'search-bar' },
				language: { "search": "_INPUT_",            // Removes the 'Search' field label
				},
				columns: [
					{ title : "Employee", class: 'employee'},
					{ title : "Created", class: 'tr-created'},
					{ title : "Modified", class: 'tr-modified'},
					{ title : "Change Price", class: 'tr-changedprice'},
					{ title : "Opens", class: 'tr-opens'},
					{ title : "Total", class: 'tr-total'},
				]
			}) 
		}
		$('.dataTables_filter input[type="search"]').
			attr('placeholder','Search ...').
			css({'width':'350px','display':'inline-block'});
			//console.log(items);
	}

	function dateValidLen($date){
		let $check = $date.split("-");
		if($check.length != 3) return false;
		else{
			let $c_yy = $check[0], $c_mm = $check[1], $c_dd = $check[2];
			return ( $c_yy.length == 4 && $c_mm.length == 2 && $c_dd.length == 2 ) ? true : false;
		}
	}