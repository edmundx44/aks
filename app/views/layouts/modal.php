<link rel="stylesheet" href="<?=PROOT?>vendors/css/modal.css" media="screen" title="no title" charset="utf-8">

<!-- search product modal -->
<div class="modal fade no-padding" id="search-product-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg spm-dialog spm-dialog-height" role="document">
		<div class="modal-content spm-content">
			<div class="spm-content-wrapper">
				<div class="spm-content-header">
					<div class="dropdown spm-header-dd">
						<button class="btn btn-primary dropdown-toggle search-product-modal-dd-btn col-12" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >Select Site</button>
						<div class="dropdown-menu col-12" aria-labelledby="dropdownMenuButton">
							<span class="dropdown-item search-product-modal-ddi">AKS</span>
							<span class="dropdown-item search-product-modal-ddi">CDD</span>
							<span class="dropdown-item search-product-modal-ddi">BREX</span>
						</div>
					</div>
					<div class="input-text-div spm-header-search-box">
						<input type="text" name="" class="input-text-class search-product-modal-txt" required>
						<i class="input-text-i fas fa-search search-product-modal-i"></i>
						<span class="input-text-span search-product-modal-span">Search Product</span>
						<span class="input-text-border"></span>
					</div>
				</div>
				<div class="text-center spmc-loader-wrapper">
					<span class="span-txt">Processing</span>
					<div class="boxes box-loader">
						<div class="box">
							<div></div>
							<div></div>
							<div></div>
							<div></div>
						</div>
						<div class="box">
							<div></div>
							<div></div>
							<div></div>
							<div></div>
						</div>
						<div class="box">
							<div></div>
							<div></div>
							<div></div>
							<div></div>
						</div>
						<div class="box">
							<div></div>
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
				</div>
				<div class="spm-content-body">
					<div class="spm-sub-header">
						<div class="spm-sub-header-tittle">
							<span>
								&nbsp; &nbsp; 
								<i class="far fa-eye"></i>
								<span class="spmc-display-header-span-what">Product found in</span>
								<span class="spmc-span-site">AKS</span>
							</span>
						</div>
						<div class="spm-sub-header-btn">
							<div class="spmc-btn spmc-btn-merchant-create">

								<div class="dropdown spmc-content-dd">
									<button class="btn btn-info dropdown-toggle col-12" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-plus-square"></i> &nbsp; &nbsp; Select Merchant&nbsp; &nbsp; &nbsp; &nbsp;</button>
									<div class="dropdown-menu spmc-dm col-12" aria-labelledby="dropdownMenuButton">
										<!-- display from database -->
									</div>
								</div>
							</div>
							
							<button class="btn btn-info spmc-btn spmc-request-id-btn"><i class="fas fa-plus-square"></i> &nbsp; Request</button>
						</div>
					</div>
					<div class="spm-content-display">
						
					
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>

<!-- display-product-by-normalised-input -->
<div class="modal fade bd-example-modal-lg displayProductByNormalisedName no-padding" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg modal-xl-override dpbn-modal-dialog" role="document">
		<div class="modal-content dpbn-modal-content">
			<div class="modal-content-wrapper dpbn-mcw">
				<div class="modal-content-header dpbn-mch">
					<button type="button" class="close float-right dpbn-btn-dismis" data-dismiss="modal">
						<i class="fas fa-times"></i>
					</button>
					<div class="modal-content-header-content dpbn-mchc">
						<div class="dropdown col-4 no-padding">
								<input type="text" name="" class="input-text-class dropdown-inputbox display-product-by-normalised-input" autocomplete='off' required>
								<span class="input-text-border"></span>
								<div class="dropdown-menu-div dmd-dpbn">
									<div class="dropdown-menu-div-sub dmds-dpbn" >AKS</div>
									<div class="dropdown-menu-div-sub dmds-dpbn" >CDD</div>
									<div class="dropdown-menu-div-sub dmds-dpbn" >BREX</div>
								</div>
							</div>
						<p class="dpbnm-product-name"></p>
						<input type="text" class="dpbnm-product-nname" name="" placeholder="Enter normalised name here.">	
					</div>
				</div>
				<div class="modal-content-body dpbn-mcb">
					<table class="col-12">
						<thead class="dpbn-thead">
							<tr class="dpbn-thead-tr">
								<th class="dpbn-thead-th">MERCHANT</th>
								<th class="dpbn-thead-th">REGION</th>
								<th class="dpbn-thead-th">EDITION</th>
								<th class="dpbn-thead-th hide-on-smmd">STOCK</th>
								<th class="dpbn-thead-th hide-on-smmd">PRICE</th>
							</tr> 
						</thead>
						<tbody class="dpbnm-table-body">
							<!-- data from data base -->
						</tbody>
					</table>
					<div class="dpbnm-loader-wrapper text-center">
						<span class="span-txt">Processing</span>
						<div class="boxes box-loader">
							<div class="box">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
							<div class="box">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
							<div class="box">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
							<div class="box">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> 

<!-- add edit modal -->
<div class="modal fade bd-example-modal-lg add-edit-store-game-modal no-padding" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg modal-xl-override ae-modal-dialog" role="document">
		<div class="modal-content ae-modal-content">
			<div class="modal-content-wrapper ae-modal-conten-wrapper">
				<div class="modal-content-header ae-modal-content-header">
					<button type="button" class="close float-right ae-modal-dismiss" data-dismiss="modal">
						<i class="fas fa-times"></i>
					</button>
					<div class="modal-content-header-content ae-modal-content-header-content">
						<p class="ae-product-p-title"></p>
						<p class="ae-product-to-what">Mode : <span class="ae-to-what"></span></p>
						<p class="text-warning text-center ae-ppt-span">*** Do not add region on AKS PC games ***</p>
						<p class="text-warning text-center ae-ppt-span">LATAM, US, RUSSIA , ACCOUNT, APAC and ASIAN regions</p>
						<p class="text-warning text-center ae-ppt-span">About consoles all regions are autorised</p>
					</div>
					<input type="hidden" class="ae-hidden-productid">
				</div>
				<div class="modal-content-body scrollbar-custom ae-modal-content-body">
					<div class="ae-autocreation-available-btn">
						<i class="fas fa-cogs ae-aad-icon"></i>
					</div>
					<div class="ae-autocreation-available-div-content">
						<ul class="ae-aadc-ul">
							<li class="ae-aadc-li" id="ae-addc-i-on-aks">AKS</li>
							<li class="ae-aadc-li" id="ae-addc-i-on-cdd">CDD</li>
							<li class="ae-aadc-li" id="ae-addc-i-on-brex">BREXIT</li>
						</ul>
						<p class="ae-aadc-description">Auto creation include's.</p>
						<div class="ae-aadc-includes ae-addc-i-on-aks">
							<div class="ae-addc-i-on-aks-1">
								<!-- dynamic data  -->
							</div>
							<div class="ae-addc-i-on-aks-0-2">
								<!-- dynamic data  -->
							</div>
						</div>
						<div class="ae-aadc-includes ae-addc-i-on-cdd">
							<div class="ae-addc-i-on-cdd-1">
								<!-- dynamic data  -->
							</div>
							<div class="ae-addc-i-on-cdd-0-2">
								<!-- dynamic data  -->
							</div>
						</div>
						<div class="ae-aadc-includes ae-addc-i-on-brex">
							<div class="ae-addc-i-on-brex-1">
								<!-- dynamic data  -->
							</div>
							<div class="ae-addc-i-on-brex-0-2">
								<!-- dynamic data  -->
							</div>
						</div>
					</div>
					<div class="row ae-mcb-row" id="ae-mcb-row">

						<!-- 1st row -------------------------- -->
						<div class="col-sm-6">
							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fas fa-store-alt"></i>
								<input type="text" name="ae-merchant-input" class="input-text-class ae-merchant-input" required>
								<span class="input-text-span">Merchant</span>
								<span class="input-text-border"></span>
							</div>
							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fas fa-search"></i>
								<input type="text" name="ae-search-name-input" class="input-text-class ae-search-name-input" required>
								<span class="input-text-span">Search name</span>
								<span class="input-text-border"></span>
							</div>
							<form> <!-- add form disable autocomplete -->
								<div class="dropdown ae-col-div-sub">
									<input type="text" name="ae-edition-input" data-editionid="" class="input-text-class ae-edition-input dropdown-inputbox" autocomplete='off' required>
									<i class="input-text-i fal fa-angle-down"></i>
									<span class="input-text-span ae-edition-span-text">Select Edition</span>
									<span class="input-text-border"></span>

									<div class="dropdown-menu-div dmd-edition">
										<!-- data from database -->
									</div>
								</div>
							</form>
						</div>
						<div class="col-sm-6">
							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fas fa-key"></i>
								<input type="text" name="ae-gameid-input" class="input-text-class ae-gameid-input" required> <!-- game id = normalise name -->
								<span class="input-text-span">Game ID</span>
								<span class="input-text-border"></span>
							</div>
							<div class="input-text-div input-text-price ae-col-div-sub">
								<i class="input-text-i fas fa-money-check-alt"></i>
								<input type="text" name="ae-price-input" class="input-text-class ae-price-input" required>
								<span class="input-text-span">Price</span>
								<span class="input-text-border"></span>
							</div>
							<form> <!-- add form disable autocomplete -->
								<div class="dropdown ae-col-div-sub">
									<input type="text" name="ae-region-input" data-regionid="" class="input-text-class ae-region-input dropdown-inputbox" required>
									<i class="input-text-i fal fa-angle-down"></i>
									<span class="input-text-span ae-region-span-text">Select Region</span>
									<span class="input-text-border"></span>
									<div class="dropdown-menu-div dmd-region">
										<!-- display data from database -->
									</div>
								</div>
							</form>
						</div>

						<!-- 2nd row -------------------------- -->
						<div class="col-sm-12">
							<div class="dropdown ae-col-div-sub">
								<input type="text" name="ae-ratings-input" class="input-text-class ae-ratings-input dropdown-inputbox" autocomplete='off' required>
								<i class="input-text-i fal fa-angle-down"></i>
								<span class="input-text-span ae-ratings-span-text">Select RATINGS</span>
								<span class="input-text-border"></span>

								<div class="dropdown-menu-div dmd-ratings">
									<div class="dropdown-menu-div-sub dmds-ratings" >0</div>
									<div class="dropdown-menu-div-sub dmds-ratings" >101</div>
									<div class="dropdown-menu-div-sub dmds-ratings" >102</div>
									<div class="dropdown-menu-div-sub dmds-ratings" >103</div>
									<div class="dropdown-menu-div-sub dmds-ratings" >104</div>
									<div class="dropdown-menu-div-sub dmds-ratings" >404</div>
								</div>
							</div>
							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fas fa-external-link-alt"></i>
								<input type="text" name="ae-url-input" class="input-text-class ae-url-input" required> <!-- url = buy url -->
								<span class="input-text-span">Url</span>
								<span class="input-text-border"></span>
							</div>
							<div class="input-text-div input-text-raw ae-col-div-sub">
								<i class="input-text-i fas fa-external-link-alt"></i>
								<input type="text" name="ae-url-raw-input" class="input-text-class ae-url-raw-input" required> <!-- url = buy url -->
								<span class="input-text-span">Buy url raw</span>
								<span class="input-text-border"></span>
							</div>
						</div>

						<!-- 3rd row -------------------------- -->
						<div class="col-sm-6">
							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fas fa-braille"></i>
								<input type="text" name="ae-keyword-input" class="input-text-class ae-keyword-input" required>
								<span class="input-text-span">Keyword</span>
								<span class="input-text-border"></span>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fas fa-external-link-square-alt"></i>
								<input type="text" name="ae-category-input" class="input-text-class ae-category-input" required>
								<span class="input-text-span">Category</span>
								<span class="input-text-border"></span>
							</div>
						</div>

						<!-- 4th row -------------------------- -->
						<div class="col-sm-12">
							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fas fa-external-link-square-alt"></i>
								<input type="text" name="ae-buy-url-bis-input" class="input-text-class ae-buy-url-bis-input" required>
								<span class="input-text-span">Buy url bis</span>
								<span class="input-text-border"></span>
							</div>
						</div>

						<!-- 5th row -------------------------- -->
						<div class="col-sm-6">
							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fab fa-staylinked"></i>
								<input type="text" name="ae-buy-url-tier-input" class="input-text-class ae-buy-url-tier-input" required>
								<span class="input-text-span">Buy url tier</span>
								<span class="input-text-border"></span>
							</div>

							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i far fa-calendar-alt"></i>
								<input type="text" name="ae-release-date-input" class="input-text-class ae-release-date-input" required>
								<span class="input-text-span">Release date</span>
								<span class="input-text-border"></span>
							</div>

							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fas fa-plus-circle"></i>
								<input type="text" name="ae-metacritic-score-input" class="input-text-class ae-metacritic-score-input" required>
								<span class="input-text-span">Metacritic score</span>
								<span class="input-text-border"></span>
							</div>

							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fas fa-plus-circle"></i>
								<input type="text" name="ae-metacritic-critic-score-input" class="input-text-class ae-metacritic-critic-score-input" required>
								<span class="input-text-span">Metacritic critic score</span>
								<span class="input-text-border"></span>
							</div>

							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fas fa-plus-circle"></i>
								<input type="text" name="ae-metacritic-user-score-input" class="input-text-class ae-metacritic-user-score-input" required>
								<span class="input-text-span">Metacritic user score</span>
								<span class="input-text-border"></span>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fab fa-staylinked"></i>
								<input type="text" name="ae-buy-url-4-input" class="input-text-class ae-buy-url-4-input" required>
								<span class="input-text-span">Buy url 4</span>
								<span class="input-text-border"></span>
							</div>

							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fas fa-calendar"></i>
								<input type="text" name="ae-release-year-input" class="input-text-class ae-release-year-input" required>
								<span class="input-text-span">Release year</span>
								<span class="input-text-border"></span>
							</div>

							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fas fa-adjust"></i>
								<input type="text" name="ae-metacritic-count-input" class="input-text-class ae-metacritic-count-input" required>
								<span class="input-text-span">Metacritic count</span>
								<span class="input-text-border"></span>
							</div>

							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fas fa-adjust"></i>
								<input type="text" name="ae-metacritic-critic-count-input" class="input-text-class ae-metacritic-critic-count-input" required>
								<span class="input-text-span">Metacritic critic count</span>
								<span class="input-text-border"></span>
							</div>

							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fas fa-adjust"></i>
								<input type="text" name="ae-metacritic-user-count-input" class="input-text-class ae-metacritic-user-count-input" required>
								<span class="input-text-span">Metacritic user count</span>
								<span class="input-text-border"></span>
							</div>
						</div>

						<!-- 6th row -------------------------- -->
						<div class="col-sm-12">
							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fab fa-accusoft"></i>
								<input type="text" name="ae-image-url-input" class="input-text-class ae-image-url-input">
								<span class="input-text-span"></span>
								<span class="input-text-border border border-warning"></span>
							</div>

							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fab fa-accusoft"></i>
								<input type="text" name="ae-description-input" class="input-text-class ae-description-input">
								<span class="input-text-span"></span>
								<span class="input-text-border border border-warning"></span>
							</div>

							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fab fa-accusoft"></i>
								<input type="text" name="ae-description-usa-or-eu-input" class="input-text-class ae-description-usa-or-eu-input">
								<span class="input-text-span"></span>
								<span class="input-text-border border border-warning"></span>
							</div>

							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fab fa-accusoft"></i>
								<input type="text" name="ae-description-ru-input" class="input-text-class ae-description-ru-input">
								<span class="input-text-span"></span>
								<span class="input-text-border border border-warning"></span>
							</div>

							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fab fa-accusoft"></i>
								<input type="text" name="ae-description-fr-input" class="input-text-class ae-description-fr-input">
								<span class="input-text-span"></span>
								<span class="input-text-border border border-warning"></span>
							</div>

							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fab fa-accusoft"></i>
								<input type="text" name="ae-description-de-input" class="input-text-class ae-description-de-input">
								<span class="input-text-span"></span>
								<span class="input-text-border border border-warning"></span>
							</div>

							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fab fa-accusoft"></i>
								<input type="text" name="ae-description-es-input" class="input-text-class ae-description-es-input">
								<span class="input-text-span"></span>
								<span class="input-text-border border border-warning"></span>
							</div>

							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fab fa-accusoft"></i>
								<input type="text" name="ae-description-it-input" class="input-text-class ae-description-it-input">
								<span class="input-text-span"></span>
								<span class="input-text-border border border-warning"></span>
							</div>

							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fab fa-accusoft"></i>
								<input type="text" name="ae-description-pt-input" class="input-text-class ae-description-pt-input">
								<span class="input-text-span"></span>
								<span class="input-text-border border border-warning"></span>
							</div>

							<div class="input-text-div ae-col-div-sub">
								<i class="input-text-i fab fa-accusoft"></i>
								<input type="text" name="ae-description-nl-input" class="input-text-class ae-description-nl-input">
								<span class="input-text-span"></span>
								<span class="input-text-border border border-warning"></span>
							</div>
						</div>

					</div> <!-- end row -->
				</div>
				<div class="modal-content-foot ae-modal-footer">
					<!-- append button create of edit dynamic -->
				</div>
			</div>
		</div>
	</div>
</div>

<!-- checksum Modal -->
<div id="checksum-modal" class="modal fade" role="dialog">
	<div class="modal-dialog checksum-dialog">
		<!-- Modal content-->
		<div class="modal-content modal-con-override cm-modal-content">
			<div class="modal-header cm-modal-header">
				<h5 class="modal-title dateChange">CHECKSUM 
 					<?php echo "(PH:". $today = date('M d',strtotime(date('M d'))).")";?>
				</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="col-sm-12 modal-checksum-site" data-modal-checksumsite="aks">
				<div class="dropdown-box dbox-hide">
					<div class="dropdown-div cm-dd-div">
						<div class="select custom-bkgd">
							<span class="selected-data change-site">Website</span>
							<span class="float-right"><i class="fas fa-caret-down"></i></span>
						</div>
						<ul class="dropdown-menu cos-dropdown-menu">
							<li class='opt-site-chk' data-website="aks">AKS</li>
							<li class='opt-site-chk' data-website="cdd">CDD</li>
							<li class='opt-site-chk' data-website="brexitgbp">BREXITGBP</li>
						</ul>
					</div>
					<div class="float-right custom-bkgd chkTable-total">TOTAL</div>
				</div>
			</div>
				<div class="modal-checksum-data col-sm-12">
					<table class="table table-checksum">
						<thead>
							<tr>
								<th>Merchant</th>
								<th>Checksum Data</th>
								<th>Last Update</th>
								<th>Status(Today)</th>
							</tr>
						</thead>
						<tbody class="checksum-body">

						</tbody>
					</table>
					<div class="loader-checksum-mdata col-sm-12"><?php //$this->loader('layouts','loader'); ?></div>
				</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
				<!-- <button type="button" class="btn btn-success addChangeLog">Submit</button> -->
			</div>
		</div>
	</div>
</div>

<!-- report modal -->
<div class="modal fade" id="reportModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-con-override">
            <div class="modal-header rheader-modal">
                <h4 class="modal-title report-modal-header"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="display-more-report row padding-lr-10">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Create reports modal -->
<div class="modal fade" id="createReportModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content crm-modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create reports</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText cr-url-txtbox-class" id="cr-url-txtbox" onkeyup="this.setAttribute('value', this.value);" />
                            <span class="floating-label">URL</span>
                        </div>
                        <div class="url-msg"></div>
                    </div>
                    <br/> 
                    <br/> 
                    <br/>
                    <div class="col-12">
                        <div class="crm-modal-body-content">
                            <span class="crm-mbc-span-title">SELECT SITE</span>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input checkbox-site crm-mbc-checbox" type="checkbox" id="AKS" value="option1" disabled/>
                                <label class="form-check-label crm-mbc-checbox-label" for="AKS">AKS</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input checkbox-site crm-mbc-checbox" type="checkbox" id="CDD" value="option2" disabled/>
                                <label class="form-check-label crm-mbc-checbox-label" for="CDD">CDD</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input checkbox-site crm-mbc-checbox" type="checkbox" id="BREX" value="option2" disabled/>
                                <label class="form-check-label crm-mbc-checbox-label" for="BREX">BREXIT</label>
                            </div>
                        </div>
                        <div class="display-found-url">
                           <!-- data from database -->
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle cr-select-problem-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select Problem</button>
                            <div class="dropdown-menu col-12" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item cr-select-problem-btn-dd" href="#">Wrong price</a>
                                <a class="dropdown-item cr-select-problem-btn-dd" href="#">Wrong stock</a>
                                <a class="dropdown-item cr-select-problem-btn-dd" href="#">Price to zero</a>
                                <a class="dropdown-item cr-select-problem-btn-dd" href="#">Other's</a>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <br/>
                    <br/>
                    <div class="col-12 cr-txtbox-problem-div" style="display: none;">
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText cr-txtbox-problem" id="" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">Enter problem</span>
                        </div>
                    </div>


                </div>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="cr-submit-btn">SUBMIT</button>
            </div>
        </div>
    </div>
</div>

<!-- check and compare reports modal -->
<div class="modal fade" id="crcac" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content cacrm-modal-content">
            <div class="modal-header">
                <p class="modal-title cacrm-modal-title">
                    <span>CHECK AND COMPARE</span>
                    <br>
                    <span class="cacrm-mt-id">ID: <span class="span-what-id"></span></span>
                    <br> 
                    <span class="span-what-problem"></span>
                    <span class="span-what-rating d-none"></span>
                    <span class="span-what-reported d-none"></span>
                    <span class="span-what-tblid d-none"></span>
                    <span class="span-what-mfeed-price d-none"></span>
                    <span class="span-what-mfeed-stock d-none"></span>
                    <span class="span-what-merchant-id d-none"></span>
                    <span class="span-what-normalized-name d-none"></span>
                    <span class="span-what-link d-none"></span>
                    <span class="span-what-site-price d-none"></span>
                    <span class="span-what-site-stock d-none"></span>
                    
                </p>
                <button type="button" class="close cacrm-modal-close" data-dismiss="modal"> <span class="cacrm-mc-span-close">&times;</span></button>
                <span class="float-right">By: <span class="checker-span"></span></span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <span class="cr-cac-tittle cr-cac-site"></span>
                        <p class="basic-loader-padding"></p>
                        <div class="site-data"></div>
                    </div>
                    <div class="col-4">
                        <span class="cr-cac-tittle">MERCHANT FEED</span>
                        <p class="basic-loader-padding"></p>
                        <div class="basic-loader"></div>
                        <div class="mfeed-data"></div>
                    </div>
                    <div class="col-4">
                        <span class="cr-cac-tittle ">MERCHANT SITE</span>
                        <p class="basic-loader-padding"></p>
                        <div class="msite-data"></div>
                    </div>
                </div>
               
            </div>
            <div class="modal-footer justify-content-between">
                <!-- <button type="button" class="btn btn-primary">CHECK SITE</button>
                <button type="button" class="btn btn-primary">REPORT TO MERCHANT</button>
                <button type="button" class="btn btn-primary">PRICE TO ZERO</button>
                <button type="button" class="btn btn-primary">CHANGE RATINGS</button>
                <button type="button" class="btn btn-primary">FIXED</button> -->
                <div class="float-left">
                    <button type="button" class="btn btn-success" id="btn-fixed">Fixed</button>
                    <a class="btn btn-primary cr-msite-btn" target="_blank">Open merchant site</a>
                    <button class="btn btn-primary" id="cr-cac-recheck-btn"><i class="fas fa-recycle cr-cac-recheck-btn-icon"></i></button>  
                    <div class="div-recheck">
                       <ul class="div-recheck-ul">
                           <li class="div-recheck-ul-li" id='r-swp'><i class="fas fa-caret-right"></i> <span class="span-probs"></span></li>
                           <li class="div-recheck-ul-li"><i class="fas fa-caret-right"></i> <span>Not the lowest price</span></li>
                           <li class="div-recheck-ul-li"><i class="fas fa-caret-right"></i> <span>Others</span></li>
                           <li class="div-recheck-ul-li" id="r-ols"><i class="fas fa-caret-right"></i> <span>Open Logs</span></li>
                       </ul>
                    </div>  
                </div>
                <div class="float-right">
                    <div class="cr-modal-cac-list">
                        <ul class="cr-modal-cac-list-ul">
                            <li class="cr-cac-list-btn" id="cr-rtm"><i class="fas fa-caret-right"></i> <span>Report to merchant</span></li>
                            <!-- <li class="cr-cac-list-btn" id="cr-spdf"><i class="fas fa-caret-right"></i> <span>Small price difference, fixed</span></li>
                            <li class="cr-cac-list-btn" id="cr-pbf"><i class="fas fa-caret-right"></i> <span>Proxy problem, fixed</span></li> -->
                            <li class="cr-cac-list-btn" id="cr-cr"><i class="fas fa-caret-right"></i> <span>Set ratings "<b><span class="cac-list-btn-rating"></span></b>"</span></li>
                            <li class="cr-cac-list-btn" id="cr-ptz"><i class="fas fa-caret-right"></i> <span>Price to zero</span></li>
                        </ul>
                    </div>
                    <i class="fas fa-users-cog cr-modal-show-list"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- report recheck log modal -->
<div class="modal fade" id="report-recheck-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="top: 70px;">
            <div class="modal-header">
                <h3>RECHECK LOG</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <table class="" style="width: 100%;background-color: #fff;">
                    <thead>
                        <tr class="" style="background: linear-gradient(60deg, #004ea3, #0062cc);color: #fff;letter-spacing: 2px">
                            <td class="" style="padding: 5px 15px 5px 15px">FEEDBACK</td>
                            <td class="" style="padding: 5px 15px 5px 15px">FEED</td>
                            <td class="" style="padding: 5px 15px 5px 15px">SITE</td>
                            <td class="" style="padding: 5px 15px 5px 15px">CHECKER</td>
                            <td class="" style="padding: 5px 15px 5px 15px">DATE</td>
                        </tr> 
                    </thead>
                    <tbody class="ols-display">
                                
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- confirmation modal modal -->
<div class="modal fade" id="report-modal-confirmation" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="background-clip: initial;top: 70px;">
            <div class="modal-body">
                <div class="modal-content-header row">
                    <div class="col-12">
                        <h6 id="confirmation-header-tittle" class="float-left confirmation-tittle"></h6>
                        <button type="button" class="close float-right" data-dismiss="modal" style="opacity: 1;outline:none;left: 30px;top: -32px;border-radius: 20px; position: relative;background-color: #fff; width: 20px;height: 20px;padding: 0;"><span style="position: relative;top: -3px;">&times;</span></button>
                    </div>
                </div>
                <div class="row">
                    <div id="confirmation-body-div" class="col-12 modal-content-body">
                        
                    </div>
                </div>
                
            </div>
            <div id="confirmation-footer-div" class="modal-footer confirmation-modal-footer">
              
            </div>
        </div>
    </div>
</div>

<!-- Affiliate Link Check Edit Modal -->
<div class="modal fade" id="affiliate-link-edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-con-override">
            <div class="modal-header">
                <h5 class="modal-title">Edit Affiliate Link</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body col-lg-12">
                <div class="col-lg-12" data-merId-modal="" data-name-modal="">
                    <div class="mb-2">
                        <div c>Merchant Id</div>
                        <input class="form-control" type="text" id="aff-link-merchant-idv2" name="" readonly>
                    </div>
                    <div class="mb-2">
                        <div>Merchant Name</div>
                        <input class="form-control" type="text" id="aff-link-namev2" name="" readonly>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-2">
                        <div>AKS AFFILIATE LINK</div>
                        <input class="form-control" type="text" id="aff-link-aksv2" name="">
                    </div>
                    <div class="mb-2">
                        <div>CDD AFFILIATE LINK</div>
                        <input class="form-control" type="text" id="aff-link-cddv2" name="">
                    </div>
                    <div class="">
                        <div>BREXITGBP AFFILIATE LINK</div>
                        <input class="form-control" type="text" id="aff-link-brexitgbpv2" name="">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-affiliate-edit-save">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Affiliate Link Check Edit Modal -->
<div class="modal fade" id="affiliate-link-add-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-con-override">
            <div class="modal-header">
                <h5 class="modal-title">Add Affiliate Link</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body col-lg-12">
                <div class="col-lg-12" data-merId-modal="" data-name-modal="">
                    <div class="mb-2">
                        <div c>Merchant Id</div>
                        <input class="form-control" type="text" id="aff-link-merchant-idv2-add" name="" readonly>
                    </div>
                    <div class="mb-2">
                        <div>Merchant Name</div>
                        <input class="form-control" type="text" id="aff-link-namev2-add" name="" readonly>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-2">
                        <div>AKS AFFILIATE LINK</div>
                        <input class="form-control" type="text" id="aff-link-aksv2-add" name="">
                    </div>
                    <div class="mb-2">
                        <div>CDD AFFILIATE LINK</div>
                        <input class="form-control" type="text" id="aff-link-cddv2-add" name="">
                    </div>
                    <div class="mb-2">
                        <div>BREXITGBP AFFILIATE LINK</div>
                        <input class="form-control" type="text" id="aff-link-brexitgbpv2-add" name="">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-affiliate-add-save">Add</button>
            </div>
        </div>
    </div>
</div>

<!-- report recheck log modal -->
<div class="modal fade" id="open-additional-info" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="top: 70px;background-clip: initial;">
            <div class="modal-body">
                <div class="modal-content-header row">
                    <div class="col-12">
                        <h6 class="float-left confirmation-tittle">Full information</h6>
                        <button type="button" class="close float-right" data-dismiss="modal" style="opacity: 1;outline:none;left: 30px;top: -32px;border-radius: 20px; position: relative;background-color: #fff; width: 20px;height: 20px;padding: 0;"><span style="position: relative;top: -3px;">&times;</span></button>
                    </div>
                </div>
                <div class="row" style="padding: 15px;font-size: 13px;">
                    <div style="padding-bottom:10px;width: 100%;"><b>SITE :</b>             <span class="disp-site">AKS</span></div>
                    <div style="padding-bottom:10px;width: 100%;"><b>ID :</b>               <span class="disp-id">AKS</span></div>
                    <div style="padding-bottom:10px;width: 100%;"><b>MERCHANT :</b>         <span class="disp-merchant">AKS</span></div>
                    <div style="padding-bottom:10px;width: 100%;"><b>NORMALIZE ID :</b>     <span class="disp-nmid">AKS</span></div>
                    <div style="padding-bottom:10px;width: 100%;"><b>LINK :</b>             <span class="disp-link">AKS</span></div>
                    <div style="padding-bottom:10px;width: 100%;"><b>PROBLEM :</b>          <span class="disp-prob">AKS</span></div>
                    <div style="padding-bottom:10px;width: 100%;"><b>ON SITE :</b>          <span class="disp-ons">AKS</span></div>
                    <div style="padding-bottom:10px;width: 100%;"><b>ON MERCHANT FEED :</b> <span class="disp-onmf">AKS</span></div>
                    <div style="padding-bottom:10px;width: 100%;"><b>ON MERCHANT SITE :</b> <span class="disp-onms">AKS</span></div>
                    <div style="padding-bottom:10px;width: 100%;"><b>CHECKER FEEDBACK :</b> <span class="disp-cfeedback">AKS</span></div>
                    <div style="padding-bottom:10px;width: 100%;"><b>CHECKER :</b>          <span class="disp-checker">AKS</span></div>
                    <div style="padding-bottom:10px;width: 100%;"><b>DATE COMPLETED :</b>   <span class="disp-datecompleted">AKS</span></div>
                </div>
                
            </div>
            <div class="modal-footer">
              
            </div>
        </div>
    </div>
</div>

<!-- Large modal AFF LINK SEE MORE MODAL-->
<div id="modal-show-more" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content custm-bg">
            <div class="modal-body display-res">
                <div class="d-flex" style="display: flex;">
                    <div class="h3 mer-id" style="display: flex; justify-content: flex-start; width: 50%;">Merchant</div>
                    <div class="h3 total-c" style="display: flex; justify-content: flex-end; width: 50%;">Total</div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table aff-modal">
                            <thead>
                                <th>Game Id</th>
                                <th class="u-type"></th>
                            </thead>
                            <tbody class="appendData">
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- add shift modal -->
<div class="modal fade" id="pc-add-shift-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-color: #fff;top: 70px;">
            <div class="modal-header">
                <h5 class="modal-title modal-assign-title-txt" id="exampleModalLabel">Add Shift</h5>
                    <button type="button" class="close float-right" data-dismiss="modal" style="opacity: 1;outline:none;left: 13px;top: -15px;border-radius: 20px; position: relative;background-color: #fff; width: 20px;height: 20px;padding: 0;"><span style="position: relative;top: -3px;">&times;</span></button>
            </div>
            <div class="modal-body pc-asb-modal">
                <div class="form-group">
                    <label style="width: 100%;background-color: #4e73df;padding: 8px;padding-left: 15px;color: #fff;">Week Day's Schedule</label>
                    <select class="form-control select-checker" id="sel1">
                        <option selected disabled>Assign Worker</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="row" style="padding: 0 10px 0 10px;">
                        <div class="col-md-3" style="padding-left: 17px;line-height: 2.5;">Start</div>
                        <div class="col-md-3">
                            <select class="form-control s-start-time-h">
                                <option selected disabled>Hour</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control s-start-time-min">
                                <option selected disabled>Min</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="padding-right: 3px;">
                            <select class="form-control s-start-ampm" >
                                <option val="AM">AM</option>
                                <option val="PM">PM</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row" style="padding: 0 10px 0 10px;">
                        <div class="col-md-3" style="padding-left: 17px;line-height: 2.5;">End</div>
                        <div class="col-md-3">
                            <select class="form-control s-end-time-h">
                                <option selected disabled>Hour</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control s-end-time-min">
                                <option selected disabled>Min</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="padding-right: 3px;">
                            <select class="form-control s-end-ampm" >
                                <option val="AM">AM</option>
                                <option val="PM">PM</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <label style="width: 100%;background-color: #4e73df;padding: 8px;padding-left: 15px;color: #fff;">Sunday's Schedule</label>
                <div class="form-group">
                    <div class="row" style="padding: 0 10px 0 10px;">
                        <div class="col-md-3" style="padding-left: 17px;line-height: 2.5;">Start</div>
                        <div class="col-md-3">
                            <select class="form-control s-start-time-h-sunday">
                                <option selected disabled>Hour</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control s-start-time-min-sunday">
                                <option selected disabled>Min</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="padding-right: 3px;">
                            <select class="form-control s-start-ampm-sunday" >
                                <option val="AM">AM</option>
                                <option val="PM">PM</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row" style="padding: 0 10px 0 10px;">
                        <div class="col-md-3" style="padding-left: 17px;line-height: 2.5;">End</div>
                        <div class="col-md-3">
                            <select class="form-control s-end-time-h-sunday">
                                <option selected disabled>Hour</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control s-end-time-min-sunday">
                                <option selected disabled>Min</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="padding-right: 3px;">
                            <select class="form-control s-end-ampm-sunday" >
                                <option val="AM">AM</option>
                                <option val="PM">PM</option>
                            </select>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="" class="edit-id-text">
            </div>
            <div class="modal-footer">
                <button id="" class="btn-set-shift btn btn-success" type="button" >Set Shift</button>
                <!-- data-dismiss="modal" -->
            </div>
        </div>
    </div>
</div>

<!-- add daily listing modal-->
<div class="modal fade" id="price_check_tool_modal_add_game" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="top: 70px;">
            <div class="modal-header">
                <h5 class="modal-title modal-daily-title-txt" id="exampleModalLabel">Add Game To Check</h5>
                <button type="button" class="close float-right" data-dismiss="modal" style="opacity: 1;outline:none;left: 13px;top: -15px;border-radius: 20px; position: relative;background-color: #fff; width: 20px;height: 20px;padding: 0;"><span style="position: relative;top: -3px;">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label style="width: 100%;background-color: #4e73df;padding: 8px;padding-left: 15px;color: #fff;">Game Info</label>
                    <div class="row">
                        <div class="col-md-6"><label>Game ID</label></div>
                        <div class="col-md-6"><span class="err-msg"></span></div>
                    </div>
                    <input type="text" id="price_check_tool_game_id" class="form-control" style="margin-bottom: 10px;">
                    <label>Game Name</label>
                    <input type="text" id="price_check_tool_game_name" class="form-control">
                </div>
                

                <label for="release-date" style="width: 100%;background-color: #4e73df;padding: 8px;padding-left: 15px;color: #fff;">Release Date</label>
                <div class="form-group">
                    <input id="release-date" type="text" class="form-control" placeholder="Date">
                </div>
                <input type="hidden" name="" class="edit-id-text-daily">
                <input type="hidden" name="" class="div-get-avail">
                <input type="hidden" name="" class="div-clone-val">
            </div>
            <div class="modal-footer">
                <button id="" class="price_check_tool_add btn btn-success" type="button" >Submit</button>
                <!-- data-dismiss="modal" -->
            </div>
        </div>
    </div>
</div>

<!-- add wrong affiliate link modal ----------------------- -->
<div class="modal fade" id="add-wrong-aff-link-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="top: 70px;">
            <div class="modal-header">
                <h5 class="modal-title modal-wrong-title-txt" id="exampleModalLabel">Add Wrong Affiliate Links</h5>
                <button type="button" class="close float-right" data-dismiss="modal" style="opacity: 1;outline:none;left: 13px;top: -15px;border-radius: 20px; position: relative;background-color: #fff; width: 20px;height: 20px;padding: 0;"><span style="position: relative;top: -3px;">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Input Number:</label>
                    <input type="number" class="form-control txt-input-wrong-link">
                </div>
                <input type="hidden" name="" class="edit-id-text-wrong">
                <input type="hidden" name="" class="daily-aff">
            </div>   
            <div class="modal-footer">
                <button id="" class="btn-add-wrong-link btn btn-primary" type="button" >Submit</button>
                <!-- data-dismiss="modal" -->
            </div>
        </div>
    </div>
</div>

<!--alert modal -->
<div class="modal fade" id="alert-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content alert-modal-bg" style="background-clip: initial;">
            <div class="modal-body">
                <div class="modal-content-header">
                    <div class="alert-modal-msg text-center text-white">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- add change logs -->
<div class="modal fade" id="show-add-log-modal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="background-clip: initial;top: 70px;">
            <div class="modal-body">
                <div class="modal-content-header row">
                    <div class="col-12">
                        <h6 class="float-left confirmation-tittle">Create Changelog</h6>
                        <button type="button" class="close float-right" data-dismiss="modal" style="opacity: 1;outline:none;left: 30px;top: -32px;border-radius: 20px; position: relative;background-color: #fff; width: 20px;height: 20px;padding: 0;"><span style="position: relative;top: -3px;">&times;</span></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 modal-content-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="user-input-wrp">
                                    <br/>
                                    <input type="text" value='' class="inputText changelog-id-txt" onkeyup="this.setAttribute('value', this.value);"/>
                                    <span class="floating-label">ID</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="user-input-wrp">
                                    <br/>
                                    <input type="text" value='' class="inputText changelog-date-txt" onkeyup="this.setAttribute('value', this.value);" style="border-color: blue;" disabled/>
                                    <span class="floating-label">Date</span>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div>
                            <textarea style="width: 100%;resize: none;height: 300px;" class="changelog-msg-txtarea"></textarea>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer confirmation-modal-footer">
                <button class="btn btn-success" id="createChangelog">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- report modal -->
<div class="modal fade" id="feesModal" role="dialog" style="z-index:1041">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-fees-content">
            <div class="modal-header">
                <h4 id="aks-fees-modal" class="modal-title report-modal-header">Update Data</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body modal-fees-body">
                <div class="add-div-store col-sm-12">
                    <div class="title-fees">Merchant Info</div>
                    <table id="add-merchant-table" class="table">
                        <thead>
                            <th>Merchant</th>
                            <th>Id</th>
                            <th style="width: 33.33% !important;">Site</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input id="merchant-name" class="input-merchant text-left" type="text" name="name" value="" placeholder="Name"></td>
                                <td><input id="merchant-id" class="input-merchant-id text-left" type="number" name="id" value="" placeholder="Id"></td>
                                <td>
                                    <div class="dropdown">
                                        <input id="website-btn" class="btn dropdown-toggle input-site" type="button" data-toggle="dropdown" value="Website">
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width:100%">
                                            <div class="dropdown-item website-items" data-website="aks">AKS</div>
                                            <div class="dropdown-item website-items" data-website="cdd">CDD</div>
                                            <div class="dropdown-item website-items" data-website="brexitgbp">BREXITGBP</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="display-more-fees col-sm-12 mt-3">
                    <div class="display-pp">
                        <div class="title-fees">
                            <div class="title-paypal" style="float:left">Paypal Fees</div>
                            <div class="add-paypal-row" data-row="paypal" style="float:right">+ row</div>
                        </div>
                        <table id="pp-table" class="table">
                            <thead>
                                <th>Range</th>
                                <th>Percent</th>
                                <th>Flat</th>
                                <th></th>
                            </thead>
                            <tbody id="append-pp-fees-body">
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="display-cc" style="margin-top: 20px;">
                        <div class="title-fees">
                            <div class="title-card" style="float:left">Card Fees</div>
                            <div class="add-card-row" data-row="card" style="float:right">+ row</div>
                        </div>
                        <table id="cc-table" class="table">
                            <thead>
                                <th>Range</th>
                                <th>Percent</th>
                                <th>Flat</th>
                                <th></th>
                            </thead>
                            <tbody id="append-cc-fees-body">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer append-footer-btn">
                <button type="button" class="btn btn-primary btn-default btn-fees" id="btn-save-fees">Update</button>
                <button type="button" class="btn btn-primary btn-default btn-fees" id="btn-add-fees">Save</button>
            </div>
        </div>
    </div>
</div>


<!-- // default modal design
<div class="modal fade bd-example-modal-lg add-edit-store-game-modal no-padding" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg modal-xl-override" style="height:  calc(100% - 60px);" role="document">
		<div class="modal-content" style="height:  100%;border-radius: 0;background-clip: initial; background: rgba(0,123,255, .5);border: none;padding: 10px;">
			<div class="modal-content-wrapper" style="width: 100%;height: 100%;background-color: #fff;">
				<div class="modal-content-header" style="height: 100px;background-color: #1e1e2f;">
					<button type="button" class="close float-right" data-dismiss="modal" style="position: relative;right: 15px;top: 10px;color: #fff;font-size: 15px;">
						<i class="fas fa-times"></i>
					</button>
					<div class="modal-content-header-content" style="padding: 10px 0 15px 15px;">
						<p style="margin: 0; padding: 0;color: #fff;letter-spacing: 2px;">AKS</p>
						<p class="text-warning text-center" style="margin: 0; padding: 0;color: #fff;font-size: 12px;">*** Do not add region on AKS PC games ***</p>
						<p class="text-warning text-center" style="margin: 0; padding: 0;color: #fff;font-size: 12px;">LATAM, US, RUSSIA , ACCOUNT, APAC and ASIAN regions</p>
						<p class="text-warning text-center" style="margin: 0; padding: 0;color: #fff;font-size: 12px;">About consoles all regions are autorised</p>
					</div>
				</div>
				<div class="modal-content-body" style="height:  calc(100% - 170px);">
					asdsad
				</div>
				<div class="modal-content-foot" style="height: 70px;border-top: solid 1px rgba(0,123,255, .5); padding: 10px;text-align: right;">
					<button class="btn btn-primary mt-1">Submit</button>
				</div>
			</div>
		</div>
	</div>
</div> -->
