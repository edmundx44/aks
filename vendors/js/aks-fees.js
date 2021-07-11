    const $url = url+'tools/aksFees';
    var $id_to_update;
    const df_value = {
        "10": [{ percent: 0, flat: 0 }],
        "20": [{ percent: 0, flat: 0 }],
        "30": [{ percent: 0, flat: 0 }],
        "infinity": [{ percent: 0, flat: 0 }],
    }
    var $modalContent = {
		header: '<div id="confimation-header-style">Are you sure?</div>',
		body  : '',
		footer: '<input id="modal-confirmation" class="col-6 button-on" style="margin:0 auto; border-radius:5px;" type="button" value="YES">'
	}
    $(function(){
        AjaxStores();

        //Display fees 
        $(document).on('click', '.merchant-list', function(){
            $id_to_update = null;
            $('.merchant-list').attr('disabled','disabled');
            $('.merchant-list').css({ "pointer-events": "none" })
            $('#append-pp-fees-body').empty();
            $('#append-cc-fees-body').empty();
            $('#remove-store-btn').remove(); //every click remove the append remove
            $('.btn-fees').hide();
            $('#btn-save-fees').show();
            $('.add-div-store').hide();
            var $merchant = $(this).attr('data-id');  //merchantFeesToEdit
            AjaxCall($url,{ action : 'merchantFeesToEdit' , row: $merchant }).done(function(data){
                if(data != null){
                    var pp_fees = JSON.parse(data[0].pp_fees);
                    var cc_fees = JSON.parse(data[0].cc_fees);  
                    Object.keys(pp_fees).forEach(function(range){
                        var append = addTableRow(range, pp_fees[range][0].percent, pp_fees[range][0].flat)
                        $('#append-pp-fees-body').append(append);                        
                    });
                    Object.keys(cc_fees).forEach(function(range){
                        var append = addTableRow(range, cc_fees[range][0].percent, cc_fees[range][0].flat)
                        $('#append-cc-fees-body').append(append);                    
                    });
                    $('#feesModal').modal('show'); 
                }
                //console.log(data);
                $('#aks-fees-modal').text(data[0].merchant_name.toUpperCase() +' '+data[0].merchant_id);
                $('#aks-fees-modal').attr('data-merchant',data[0].merchant_id);
                $('#aks-fees-modal').attr('data-idd',data[0].id);
                $('.merchant-list').removeAttr('disabled');
                $('.merchant-list').css({ "pointer-events": "" })
                $('.append-footer-btn').prepend('<button type="button" class="mr-auto btn btn-danger btn-default btn-fees" id="remove-store-btn">Remove store</button>')
                $id_to_update = data[0].id; //put the value in the global variable
            })
        })

        //Update fees js
        $(document).on('click','#btn-save-fees',function(){  
            $('#feesModal').css({"z-index:":"1040"})
            var $final = {};
            var pp_fees = getFeesData('#append-pp-fees-body');
            var cc_fees = getFeesData('#append-cc-fees-body');
            if (pp_fees == false || cc_fees == false){
                alert("This is not a number or empty field")
            } else {
                $final = [{'pp_fees':JSON.stringify(pp_fees),'cc_fees':JSON.stringify(cc_fees)}]; //Contert Text then Send to Ajax
                if($id_to_update != null){
                    $modalContent.body = '<div id="confimation-body-style">Do you really want to UPDATE this merchant?</div>';
                    confirmDialog($modalContent,function(e){
                        var $_query = { action: 'merchantFeesToUpdate' ,row : $id_to_update ,dataFee: $final }
                        AjaxCall($url , $_query).done(function(data){
                            console.log(data)
                            if(data) {
                                alertMsg("Success", "bg-success");
                                $('#feesModal').modal('hide');
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            }
                        });
                    })
                }
            }
        });

        //display modal for adding stores
        $(document).on('click','#add-store-btn',function(){
            $('.btn-fees').hide();
            $('#btn-add-fees').show();
            $('.add-div-store').show();
            $('#aks-fees-modal').text("Add Merchant");
            $('#append-pp-fees-body').empty();
            $('#append-cc-fees-body').empty();
            $('#aks-fees-modal').removeAttr('data-merchant');
            $('#aks-fees-modal').removeAttr('data-idd');
            Object.keys(df_value).forEach(function(range){
                var append = addTableRow(range, df_value[range][0].percent, df_value[range][0].flat);
                $('#append-pp-fees-body').append(append);
            });
            Object.keys(df_value).forEach(function(range){
                var append = addTableRow(range, df_value[range][0].percent, df_value[range][0].flat);
                $('#append-cc-fees-body').append(append);
            });
            $('#feesModal').modal('show');
        });

        //add store fees
        $(document).on('click','#btn-add-fees',function(){
            $('#feesModal').css({"z-index:":"1040"})
            var $final = {};
            $id_to_update = null;
            var pp_fees = getFeesData('#append-pp-fees-body');
            var cc_fees = getFeesData('#append-cc-fees-body');
            console.log(isNaN($('#merchant-id').val()));
            if (pp_fees == false || cc_fees == false || isNaN($('#merchant-id').val()) || ($('#merchant-name').val() && $('#merchant-id').val() ) == '' || !(['AKS','CDD','BREXITGBP'].includes($('#website-btn').val())) ){
                alertMsg("This is not a number or empty field", "bg-danger")
            } else {
                $final = [{'pp_fees':JSON.stringify(pp_fees),'cc_fees':JSON.stringify(cc_fees)}]; //Contert Text then Send to Ajax
                if($id_to_update == null){
                    $modalContent.body = '<div id="confimation-body-style">Do you really want to ADD this merchant?</div>';
                    confirmDialog($modalContent,function(e){
                    var $_query = {
                        action: 'merchantFeesAddNew',
                        merchantName: $('#merchant-name').val(),
                        merchantId: $('#merchant-id').val(),
                        website: $('#website-btn').val(),
                        dataFees: $final
                    }
                        AjaxCall($url, $_query).done(function(data){
                            console.log(data);
                            if(data){
                                alertMsg("Success", "bg-success");
                                $('#feesModal').modal('hide');
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            }
                            else{
                                alertMsg("Data didnt save check input ID... ", "bg-danger");
                            }
                        })
                    })
                }
            }
        });

        //remove store 
        $(document).on('click', '#remove-store-btn', function(){
            $modalContent.body = '<div id="confimation-body-style">Do you really want to REMOVE this merchant?</div>';
            if($id_to_update != null){
                confirmDialog($modalContent,function(e){
                    $_query = { action: 'removedStore', id: $id_to_update }
                    AjaxCall($url, $_query).done(function(data){
                        if(data){
                            alertMsg("Success", "bg-success");
                            $('#feesModal').modal('hide');
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        }
                        else{
                            alertMsg("Data didnt save check input ID... ", "bg-danger");
                        }
                    })
                })
            }else{
                alertMsg("Didnt delete the merchant", "bg-danger");
            }
        });


        //ADD ROW IN FEES
        $(document).on('click', '.add-paypal-row,.add-card-row', function(){
            var type = $(this).attr('data-row');
            if(type != '' || type != null) {
                switch(type){
                    case 'paypal':
                        var row = addTableRow(0, 0, 0);
                        $('#append-pp-fees-body').prepend(row);
                    break;
                    case 'card':
                        var row = addTableRow(0, 0, 0);
                        $('#append-cc-fees-body').prepend(row);
                    break;
                    default: break;
                }
            }
        });

        //SORT AFTER INPUT CHANGE
        $(document).on('change', '.input-range', function() {
            var target = $(this).closest('tbody').attr('id');
                if(target == 'append-pp-fees-body')
                    sortTable('#append-pp-fees-body', 'asc')
                else if(target == 'append-cc-fees-body')
                    sortTable('#append-cc-fees-body', 'asc')
        });

        //REMOVE ROW IN FEES
        $(document).on('click', '#remove-row', function(){
            $(this).closest('tr').remove();
        });

        $(document).on('click', '.website-items', function(){
            $('#website-btn').val($(this).attr('data-website').toUpperCase());
        });
    });
    //query stores
    function AjaxStores($_query = false){
    $id_to_update = null;
		if(!$_query)		
			var $_query = { action : "aks-fees-merchant" , site : 'aks'}
		AjaxCall($url, $_query).done(storeList)
	}
    //display store query
    function storeList(res){
        $('#append-merchants').empty(); 
		for (var i in res){
            var n = res[i].merchant_name.toLowerCase();
            var storeName = n.substr(0,1).toUpperCase()+n.substr(1);
            var app = 	'<div class="col-xl-3 col-lg-6 col-sm-12 store-list-div">';
				app += 		'<div class="merchant-list store-list-card" data-id='+res[i].id+'>';
				app += 			'<div class="card-body store-list"><p>'+storeName+' '+res[i].merchant_id+'</p></div>';
				app += 		'</div>';
				app +=	'</div>';
        	$('#append-merchants').append(app); 
		}
	}
    //get input values of the table
    function getFeesData($tableId){
        var values = {}, counter = 0, key, percent, flat;
        $($tableId).find('input[type=number],input[type=text]').each(function() {
            value = $(this).val();
            if(isNaN(value) && value != 'infinity' || value == '' || value < 0){
                values = false
                return values;
            }
            if(counter % 3 == 0){
                //key = '"'+ value +'"';
                key = ''+ value +'';
                values[key]={};
            }
            else if(counter % 3 == 1){
                percent = value;
            } else {
                values[key] = [{'percent':percent,'flat':value}];
            }
            counter++;
        });
        return values;
    }    

    //populate table row when click the merchant
    function addTableRow($range="", $percent="", $flat="") {
        var app = '<tr>';
            app += '<td><input type="text" class="input-range text-center" value='+$range+'></td>';
            app += '<td><input type="number" class="input-percent text-center" value='+$percent+'></td>';
            app += '<td><input type="number" class="input-flat text-center" value='+$flat+'></td>';
            app += '<td><button id="remove-row" class="btn btn-danger">X</button></td>'
            app += '</tr>';
        return app;
    }
    //sort table row according the value of range from ASC to DESC
    function sortTable($table, $order) {
        // //function(a, b){return a-b} 
        //https://www.javascripttutorial.net/javascript-array-sort/  
        var $rows = $($table+' > tr');
        $rows.sort(function (a, b) {
            var keyA = $('td', a)[0].firstChild.value;
            var keyB = $('td', b)[0].firstChild.value;
            if ($order=='asc') {
                if(!isNaN(keyA) && !isNaN(keyB))
                    return keyA - keyB; //If compare(a,b) is less than zero, the sort() method sorts a to a lower index than b. In other words, a will come first.
                if((keyA || keyB) == 'infinity')
                    return 1;
            }
            if ($order =='desc') {
                if(!isNaN(keyA) && !isNaN(keyB))
                    return keyB - keyA; //If compare(a,b) is greater than zero, the sort() method sort b to a lower index than a, i.e., b will come first.
                if((keyA || keyB) == 'infinity')
                    return 1;
            }
        });
        $.each($rows, function (index, row) {  $($table).append(row); });
    }

    function confirmDialog($con, onConfirm){
    	var fClose = function(){
    		  modal.modal("hide");
    	};
    	var modal = $("#report-modal-confirmation");
		modal.modal('show');
		$('.confirmation-tittle').empty().html($con.header);
		$('.modal-content-body').empty().append($con.body);
		$('.confirmation-modal-footer').empty().append($con.footer);	
    	$("#modal-confirmation").unbind().one('click', onConfirm).one('click', fClose);
    }