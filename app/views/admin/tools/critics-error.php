<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>vendors/css/utilities-page.css" media="screen" title="no title" charset="utf-8">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" >
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
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
</script>
<?php $this->end(); ?>

<?php $this->start('body')?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 mtop-35px">
            <div class="card card-style">
                <div class="card-body no-padding">
                    <!-- HEADER STARTS row-4-card-div-overflow-style-->
						<div class="card-div-overflow-style row-4-card-div-overflow-style-2" style="position:relative; padding-top:20px;">
							<div class="row" style="color:#fff;margin: 0;">
                                <div class="header-div col-lg-10">
									<h5 class="header-title-page">Metacritics Error Check</h5>
									<p class="header-text-paragraph">Error will appears here if the critics or user rating score is above <b class="cdd_color" style="font-size:18px">10</b></p>
								</div>
							</div>
                        </div>
                    <!-- CONTENT STARTS row-4-card-div-overflow-style-->
                        <div>
                            <div class="col-lg-12" style="font-size: 14px;">
                                <table id="table-metacritics-error-rating" class="display" width="100%">

                                </table>
				            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end()?> 