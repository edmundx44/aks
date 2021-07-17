var $dataReq = {action: 'metacriticsErrorRating'};

	$(function (){
		AjaxCall(url,$dataReq).done( ajaxSuccess );
	});
	function ajaxSuccess(data){
		var ajaxMetacriticResponse = [];
		for (var i in data){    
			var toPush = [
				gotoMetaUrl(data[i].url),
				data[i].userid,
				data[i].game_id,
				data[i].normalised_name,
				data[i].rating_type,
				ratingScoreBg(data[i].critics_score),
				ratingScoreBg(data[i].users_rating_score),
			]
			ajaxMetacriticResponse.push(toPush);
		}
		if(ajaxMetacriticResponse != null){
			$('#table-metacritics-error-rating').DataTable( {
				destroy: true,
				responsive: true,
				pageLength: 25,
				lengthMenu: [[25, 50, 100, -1],[25, 50, 100, "All"]], // Sets up the amount of records to display
				scrollX: 420,
				data: ajaxMetacriticResponse,
				columns: [
					{ title : "URL" },
					{ title : "USER ID" },
					{ title : "GAME ID" },
					{ title : "NORMALISED NAME" },
					{ title : "RATING TYPE" },
					{ title : "CRITIC SCORE" },
					{ title : "USER RATING SCORE" },
				]
			});
		}	
	}

	function gotoMetaUrl(url){
		return "<a href='"+ url +"' target='_blank'>"+url+"</a>"
	}
	function ratingScoreBg($ratingScore){
		if($ratingScore < 10){
			return $ratingScore = '<span class="text-success"><b>'+$ratingScore+'</b></span>';
		}else{
			return $ratingScore = '<span class="text-danger"><b>'+$ratingScore+'</b></span>';
		}
	}