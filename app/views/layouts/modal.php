<link rel="stylesheet" href="<?=PROOT?>vendors/css/modal.css" media="screen" title="no title" charset="utf-8">

<div class="modal" id="displayStoreGamesByNormalizedName">
    <div class="modal-dialog displayStoreGamesByNormalizedNameDialog">
        <div class="modal-content displayStoreGamesByNormalizedNameContent" style="top: 70px;">
      
            <!-- Modal Header -->
            <div class="modal-header">
                <!-- search name and normalized name -->
                <div class="modal-title">
                    <div class="sideborder"></div>
                    <span class="productName"></span> 
                    <span class="productNormalizedName"></span> 
                </div>
                <button type="button" class="close" data-dismiss="modal">×</button>
                <br>
                <br>
                <br>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body displayStoreGamesByNormalizedNameBody">
                <div class="nname-modal-thead">
                    <div class="nname-modal-thead-div">
                        <div class="modal-child modal-child-1">Merchant</div>
                        <div class="modal-child modal-child-2">Region</div>
                        <div class="modal-child modal-child-3">Edition</div>
                        <div class="modal-child modal-child-4">Stock</div>
                        <div class="modal-child modal-child-5">Price</div>
                        <div class="modal-child modal-child-6"> &nbsp; </div>
                    </div>
                </div>
                <div class="nname-modal-tbody">
                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn modal-close-btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- Large modal -->
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
				<div class="modal-content-body scrollbar-custom" style="height:  calc(100% - 170px);overflow-y: auto;">
					<!-- <div class="input-text-div">
						<i class="input-text-i fab fa-accusoft"></i>
						<input type="text" name="" class="input-text-class">
						<span class="input-text-span">Sample text</span>
						<span class="input-text-border"></span>
					</div> -->
					
				</div>
				<div class="modal-content-foot" style="height: 70px;border-top: solid 1px rgba(0,123,255, .5); padding: 10px;text-align: right;">
					<button class="btn btn-primary mt-1">Submit</button>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- checksum Modal -->
<div id="checksum-modal" class="modal fade" role="dialog">
  <div class="modal-dialog checksum-dialog">

    <!-- Modal content-->
        <div class="modal-content modal-con-override" style="top: 70px; border-radius: .5rem">
            <div class="modal-header" style="background: linear-gradient(60deg, #004ea3, #0062cc);color: #fff;letter-spacing: 1px;">
                <h5 class="modal-title dateChange">CHECKSUM 
                    <?php 
                        echo "(PH:". $today = date('M d',strtotime(date('M d'))).")";
                    ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="col-sm-12 modal-checksum-site" data-modal-checksumsite="aks" style="margin-bottom: 5px;margin-top: 5px;">
                <div class="dropdown-box dbox-hide">
                    <div class="dropdown-div" style="width: 150px;">
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
                    <div class="float-right custom-bkgd chkTable-total" style="padding: 8px;width: 120px;color: #fff;text-align: center;">TOTAL</div>
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
                    <div class="loader-checksum-mdata col-sm-12" style="display: none; height: 500px;"><?php //$this->loader('layouts','loader'); ?></div>
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

<!-- Create reports reports modal -->
<div class="modal fade" id="createReportModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="top: 70px;">
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
                        <div style="padding: 10px;margin-left: 15px;font-size: 12px;letter-spacing: 1px;" class="url-msg"></div>
                    </div>
                    <br/> 
                    <br/> 
                    <br/>
                    <div class="col-12">
                        <div style="border:solid 2px #777;padding: 15px;">
                            <span style="position: absolute;top: -10px;right: 30px;background-color: #777;color: #fff;font-size: 13px;padding: 0 15px 0 15px;">SELECT SITE</span>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input checkbox-site" type="checkbox" id="AKS" value="option1" style="margin-top: -1px;cursor: pointer;" disabled/>
                                <label class="form-check-label" for="AKS" style="cursor: pointer;font-size: 15px;">AKS</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input checkbox-site" type="checkbox" id="CDD" value="option2" style="margin-top: -1px;cursor: pointer;" disabled/>
                                <label class="form-check-label" for="CDD" style="cursor: pointer;font-size: 15px;">CDD</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input checkbox-site" type="checkbox" id="BREX" value="option2" style="margin-top: -1px;cursor: pointer;" disabled/>
                                <label class="form-check-label" for="BREX" style="cursor: pointer;font-size: 15px;">BREXIT</label>
                            </div>
                        </div>
                        <div class="display-found-url" style="padding: 15px;">
                           
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle cr-select-problem-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;text-align: left;">Select Problem</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%;">
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


<!-- Create check and compare reports modal -->
<div class="modal fade" id="crcac" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="top: 70px;">
            <div class="modal-header">
                <p class="modal-title" style="font-weight: 500;">
                    <span>CHECK AND COMPARE</span>
                    <br>
                    <span class="" style="font-size: 13px;position: relative;">ID: <span class="span-what-id"></span></span>
                    <br> 
                    <span class="span-what-problem" style="font-size: 13px;position: relative;"></span>
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
                <button type="button" class="close" data-dismiss="modal" style="opacity: 1;outline: 0;position: absolute; right: 0; top: 0;background-color: #fff;padding: 10px;border-radius: 50px;width: 20px;height: 20px;"> <span style="position: relative;top: -13px;left: -5.5px;">&times;</span></button>
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
                    <i class="fas fa-users-cog cr-modal-show-list" style="font-size: 30px;color: #0062cc;margin-top: 8px; cursor: pointer;"></i>
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

<!-- report recheck log modal -->
<div class="modal fade" id="report-modal-confirmation" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="background-clip: initial;top: 70px;">
            <div class="modal-body">
                <div class="modal-content-header row">
                    <div class="col-12">
                        <h6 class="float-left confirmation-tittle"></h6>
                        <button type="button" class="close float-right" data-dismiss="modal" style="opacity: 1;outline:none;left: 30px;top: -32px;border-radius: 20px; position: relative;background-color: #fff; width: 20px;height: 20px;padding: 0;"><span style="position: relative;top: -3px;">&times;</span></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 modal-content-body">
                        
                    </div>
                </div>
                
            </div>
            <div class="modal-footer confirmation-modal-footer">
              
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
        <div class="modal-content bg-danger" style="background-clip: initial;">
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
