<?php $this->start('head'); ?>
	<link rel="stylesheet" href="<?=PROOT?>vendors/css/store-page.css" media="screen" title="no title" charset="utf-8">
	<script type="text/javascript" src="<?=PROOT?>vendors/js/store-page.js"></script>
	<script>
		function searchKeyUp($searchVal) {
			currentDisplay = 0;
			currentID = '';
			total = '';
			toSearch = '';

			if($searchVal != ''){
				$('.store-data-div').hide();
				$('.store-games-data-div').show();
				$('.store-games-data-table-tbody').empty();
				$('.breadcrumbs-ul').empty();
				toSearch = $searchVal;
				breadCrumbs('Search');
				displayStoreGames('', 0, 0, $searchVal, $('.dropdown-menu-btn').text());
			}else{
				$('.store-games-data-table-tbody').empty();
				$('.store-data-div').show();
				$('.store-games-data-div, .store-games-data-table-tfoot').hide();
				$('.games-bcrumbs').remove();
				currentDisplay = 0;
				currentID = '';
				total = '';
				toSearch = '';
			}
		}

		function storeUpdateProduct($id, $toWhat, $dataTo, $site){
			$.ajax({
				url: '<?= PROOT ?>store',
				type: 'POST',
				data: {
					action: 'storeUpdateProduct',
					id: $id,
					toWhat: $toWhat,
					dataTo: $dataTo,
					site: $site

				},
				beforeSend:function(){},
				success:function(data){
					console.log(data)
				},
				complete:function(){}
			});
		}

		function displayStoreGamesByNormalizedName($nnameID, $site) {
			$.ajax({
				url : '<?= PROOT ?>store',
				type: "POST",
				data : {
					action: 'displayStoreGamesByNormalizedName',
					nnameID: $nnameID,
					site: $site
				},
				beforeSend:function(){},
				success:function(data){
					$('.productName').text(data[0].searchName);
					$('.productNormalizedName').text(data[0].nname);
					$('#displayStoreGamesByNormalizedName').modal('show');
					$('.nname-modal-tbody').empty();
					for(var i in data){
						var append = 	'<div class="nname-modal-tbody-div '+data[i].id+'">';
							append +=	'<div class="modal-child-tbody-1">'+data[i].merchant+'</div>';
							append +=	'<div class="modal-child-tbody-2">'+data[i].region+'</div>';
							append +=	'<div class="modal-child-tbody-3">'+data[i].edition+'</div>';
							append +=	'<div class="modal-child-tbody-sub modal-child-tbody-4"><input class="modal-val-btn" type="button" 	data-prodId="'+data[i].id+'" 	value="'+data[i].status+'"></div>';
							append +=	'<div class="modal-child-tbody-sub modal-child-tbody-5"><input class="modal-val-txt" type="text" 	data-prodId="'+data[i].id+'"	value="'+data[i].price+'"></div>';
							append +=	'<div class="modal-child-tbody-sub modal-child-tbody-6">';
							append += 	'<div class="show-menu" id="'+data[i].id+'">';
							append += 	'<ul class="modal-setting-ul">';
							append += 	'<li class="modal-setting-ul-li"><i class="fa fa-pencil" aria-hidden="true"></i><span class="msulspan add-edit-from-display" data-toeditid="'+data[i].id+'">Edit</span></li>';
							append += 	'<li class="modal-setting-ul-li"><i class="fa fa-times" aria-hidden="true"></i><span class="msulspan">Delete</span></li>';
							append += 	'<li class="modal-setting-ul-li"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="msulspan">Others</span></li>';
							append += 	'</ul>';
							append +=	'</div>';
							append += 	'<button class="btn action-btn '+data[i].site+'-btn" id="'+data[i].id+'"> <i class="fa fa-cogs btn-icon-acb" aria-hidden="true"></i></button>';
							append +=   '</div>';
							append +=	'<div><p class="nname-modal-tfoot"><a href="'+data[i].buy_url+'" target="_blank">'+data[i].buy_url+'</a></p></div>';
							append +=	'</div>';

						$(".nname-modal-tbody").append(append);
					}
				},
				complete:function(){

				}
			});
		}

		function displayStoreGames($merchantID, $offset, $limit, $toSearch, $site){
			$.ajax({
				url: '<?= PROOT ?>store',
				type: 'POST',
				data: {
					action: 'displayStoreGames',
					merchantID: $merchantID,
					offset: $offset,
					limit: $limit,
					toSearch: $toSearch,
					site: $site
				},
				beforeSend:function(){},
				success:function(data){
					var showHide = (data[0].total >= 50 || (data[0].total != '' && data[0].total >= 50))? $('.store-games-data-table-tfoot').show() : $('.store-games-data-table-tfoot').hide();
					for(var i in data){
						for(var j in data[0].data){
							var getStatus = (data[0].data[j].dispo == 1)? 'In Stock' : 'Out Of Stock';
							var append = '<tr class="store-games-data-table-tbody-data" data-nname='+data[0].data[j].normalised_name+'>';
								append += '<td class="child-1">'+data[0].data[j].buy_url+'</td>'
								append += '<td class="child-2">'+data[0].data[j].price+'</td>'
								append += '<td class="child-3">'+getStatus+'</td>'
								append += '</tr>'

							$('.store-games-data-table-tbody').append(append);
						}
					}
					currentDisplay += data[0].currentDisplay;
					currentID = $merchantID;
					total = data[0].total;
				},
				complete:function(){
					var hideIfMax = (currentDisplay == total)? $('.store-games-data-table-tfoot').hide() : '';
				}
			});
		}
		function displayStore(){
			$.ajax({
				url : '<?= PROOT ?>store',
				type: "POST",
				data : {
					action: 'displayStore'
				},
				beforeSend:function(){},
				success:function(data){
					for(var i in data){
						var append =  '<div class="col-md-12 col-lg-6 col-xl-3  store-list-div">';
							append += '<div class="card store-list-card" id="'+data[i].vols_id+'" data-nname="'+data[i].vols_nom+'">';
							append += '<img class="card-img-top store-list-card-img-style" src="<?=PROOT?>vendors/image/store/.jpg" onerror="noImage(this);">';
							append += '<div class="card-body store-list-card-body">';
							append += '<p class="card-title store-list-store-name">'+data[i].vols_nom+' - '+data[i].vols_id+'</p>';
							append += '</div>';
							append += '</div>';
							append += '</div>';
						$(".store-data-div").append(append);
					}
				},
				complete:function(){}
			});
		}
		function noImage(image) {
		    image.onerror = "";
		    image.src = "<?=PROOT?>vendors/image/no-image.jpg";
		    return true;
		}
		function breadCrumbs($name){
			var append =  '<li class="site-bcrumbs"><span class="site-bcrumbs-span">'+$('.dropdown-menu-btn').text()+'</span></li>';	
				append += '<li class="store-bcrumbs">&nbsp;<i class="fa fa-arrow-right breadcrumbs-arrow" aria-hidden="true"></i> Store</li>';	
				append += '<li class="games-bcrumbs"><i class="fa fa-arrow-right breadcrumbs-arrow" aria-hidden="true"></i> '+ $name +'</li>';
				append += '<li class="">'
				append += '<button type="button" class="btn dropdown-toggle sticky-dropdown" data-toggle="dropdown"></button>'
				append += '<div class="dropdown-menu col-12 dropdown-menu-div sticky-dropdown-menu-div">'
				append += '<a class="dropdown-item dropdown-items-store-page-search" >AKS</a>'
				append += '<a class="dropdown-item dropdown-items-store-page-search" >CDD</a>'
				append += '<a class="dropdown-item dropdown-items-store-page-search" >BREX</a>'
				append += '</div>'
				append += '</li>'
			$(".breadcrumbs-ul").append(append);
		}
	</script>
	
<?php $this->end(); ?>

<?php $this->start('body')?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 mtop-35px">
			<div class="card card-style">
				<div class="card-body no-padding store-card-main-wrap"> 
					<div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-1 store-card-div-page-title">
						<p class="store-list-title">Store list</p>
						<p class="store-list-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
					</div>

					<!-- breadcrumbs and search -->
					<div class="card-header breadcrumbs-div">
						<div class="row">
							<div class="col-sm-12 no-padding">
								<ul class="breadcrumbs-ul">
									<li class="site-bcrumbs"><span class="site-bcrumbs-span">AKS</span></li>
									<li class="store-bcrumbs"><i class="fa fa-arrow-right breadcrumbs-arrow" aria-hidden="true"></i> Store</li>
									<li class="show-dropdown-li">
										<button type="button" class="btn dropdown-toggle sticky-dropdown"></button>
										<div class="dropdown-menu col-12 dropdown-menu-div sticky-dropdown-menu-div">
											<a class="dropdown-item dropdown-items-store-page-search" >AKS</a>
											<a class="dropdown-item dropdown-items-store-page-search" >CDD</a>
											<a class="dropdown-item dropdown-items-store-page-search" >BREX</a>
										</div>
									</li>
								</ul>
								
							</div>

							<div class="col-lg-9 no-padding">
								<div class="input-group">
									<input type="text" class="form-control store-page-search" placeholder="Dig more in Store page!">
									<div class="input-group-append">
										<button class="btn bg-transparent store-search-btn" type="button" >
											<i class="fa fa-search"></i>
										</button>
									</div>
								</div>
							</div>

							<div class="col-lg-3 store-select-site-div">
								<div class="dropdown">
									<button type="button" class="btn dropdown-toggle col-12 dropdown-menu-btn" data-toggle="dropdown">AKS</button>
									<div class="dropdown-menu col-12 dropdown-menu-div">
										<a class="dropdown-item dropdown-items-store-page-search" >AKS</a>
										<a class="dropdown-item dropdown-items-store-page-search" >CDD</a>
										<a class="dropdown-item dropdown-items-store-page-search" >BREX</a>
									</div>
								</div>
								<!-- <input type="button" class="btn btn-primary col-12" value="SITE"> -->
							</div>
							
						</div>
					</div>

					<div class="card-body no-padding">
						<div class="row store-data-div"></div>
						<div class="row store-games-data-div" style="display: none;padding-left: 15px;padding-right: 15px;">
							<div class="col-sm-12 no-padding store-games-data-div-sub">
								<table class="store-games-data-div-table">
									<thead>
										<tr class="store-games-data-table-thead-data">
											<td class="child-1">Link</td>
											<td class="child-2">Price</td>
											<td class="child-3">Status</td>
										</tr>
									</thead>
									<tbody class="store-games-data-table-tbody">
										
									</tbody>
									<tfoot class="store-games-data-table-tfoot">
										<tr>
											<td colspan="3" style="padding-top: 20px;">
												<p style="text-align: center;">
													<span class="data-display-function lmore-fucntion"> 
														<i class="fa fa-spinner" aria-hidden="true"></i> Load More 
													</span> 
													<span class="data-display-function dall-function"> 
														<i class="fa fa-globe" aria-hidden="true"></i> Display All
													</span>
												</p>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->end()?>
