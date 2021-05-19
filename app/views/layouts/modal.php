<link rel="stylesheet" href="<?=PROOT?>vendors/css/modal.css" media="screen" title="no title" charset="utf-8">

<div class="modal" id="displayStoreGamesByNormalizedName">
    <div class="modal-dialog displayStoreGamesByNormalizedNameDialog">
        <div class="modal-content displayStoreGamesByNormalizedNameContent">
      
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
<div class="modal fade bd-example-modal-lg add-edit-store-game-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="height:  calc(100% - 70px);">
        <div class="modal-content" style="height:  100%;">
            <div class="modal-header">
                <h4 class="modal-title">Modal Header</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
            </div>

            <div class="modal-body" style="height: 100%;overflow-y:auto;">
                <div class="row">
                    <!-- 1st row -------------------------- -->
                    <div class="col-6">
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">Merchant</span>
                        </div>
                        <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">Search name</span>
                        </div>
                        <br><br>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle add-edit-game-btn-edition" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;text-align: left;">Select edition</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%;">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>


                    <div class="col-6">
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">Game ID - Normalized name</span>
                        </div>
                        <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">Price</span>
                        </div>
                        <br><br>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle add-edit-game-btn-region" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;text-align: left;">Select region</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%;">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>

                    <!-- 2nd row -------------------------- -->
                    <div class="col-12">
                        <br><br>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle add-edit-game-btn-ratings" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;text-align: left;">Select RATINGS</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%;">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                        <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">URL</span>
                        </div>
                    </div>

                    <!-- 3rd row -------------------------- -->
                    <div class="col-6">
                        <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">Keyword</span>
                        </div>
                    </div>

                    <div class="col-6">
                        <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">Category</span>
                        </div>
                    </div>

                    <!-- 4th row -------------------------- -->
                     <div class="col-12">
                        <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">BUY URL BIS</span>
                        </div>
                    </div>

                    <!-- 5th row -------------------------- -->
                    <div class="col-6">
                        <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">BUY URL TIER</span>
                        </div>

                        <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">Releasedate</span>
                        </div>

                        <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">metacritic score </span>
                        </div>

                        <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">metacritic critic score </span>
                        </div>

                        <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">metacritic user score</span>
                        </div>
                    </div>

                    <div class="col-6">
                        <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label"> BUY URL 4 </span>
                        </div>

                        <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">releaseyear</span>
                        </div>

                        <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">metacritic count</span>
                        </div>

                        <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">metacritic critic count </span>
                        </div>

                        <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">metacritic user count </span>
                        </div>
                    </div>

                    <!-- 6th row -------------------------- -->
                    <div class="col-12">
                        <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);" style="border-color: green;" disabled/>
                            <span class="floating-label"> </span>
                        </div>
                         <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);" style="border-color: green;" disabled/>
                            <span class="floating-label"> </span>
                        </div>
                         <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);" style="border-color: green;" disabled/>
                            <span class="floating-label"> </span>
                        </div>
                         <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);" style="border-color: green;" disabled/>
                            <span class="floating-label"> </span>
                        </div>
                         <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);" style="border-color: green;" disabled/>
                            <span class="floating-label"> </span>
                        </div>
                         <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);" style="border-color: green;" disabled/>
                            <span class="floating-label"> </span>
                        </div>
                         <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);" style="border-color: green;" disabled/>
                            <span class="floating-label"> </span>
                        </div>
                         <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);" style="border-color: green;" disabled/>
                            <span class="floating-label"> </span>
                        </div>
                         <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);" style="border-color: green;" disabled/>
                            <span class="floating-label"> </span>
                        </div>
                         <br>
                        <div class="user-input-wrp">
                            <br/>
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);" style="border-color: green;" disabled/>
                            <span class="floating-label"> </span>
                        </div>
                         <br>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>


<!-- checksum Modal -->
<div id="checksum-modal" class="modal fade" role="dialog">
  <div class="modal-dialog checksum-dialog">

    <!-- Modal content-->
        <div class="modal-content modal-con-override" style="border-radius: .5rem">
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
                            <span class="pull-right"><i class="fa fa-caret-down" aria-hidden="true"></i></span>
                        </div>
                        <ul class="dropdown-menu cos-dropdown-menu">
                            <li class='opt-site-chk' data-website="aks">AKS</li>
                            <li class='opt-site-chk' data-website="cdd">CDD</li>
                            <li class='opt-site-chk' data-website="brexitgbp">BREXITGBP</li>
                        </ul>
                    </div>
                    <div class="pull-right custom-bkgd chkTable-total" style="padding: 8px;width: 120px;color: #fff;text-align: center;">TOTAL</div>
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
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title report-modal-header"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="display-more-report">
                        
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
        <div class="modal-content">
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
        <div class="modal-content">
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
                <span class="pull-right">By: <span class="checker-span"></span></span>
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
                <div class="pull-left">
                    <button type="button" class="btn btn-success" id="btn-fixed">Fixed</button>
                    <a class="btn btn-primary cr-msite-btn" target="_blank">Open merchant site</a>
                    <button class="btn btn-primary" id="cr-cac-recheck-btn"><i class="fa fa-recycle cr-cac-recheck-btn-icon" aria-hidden="true"></i></button>  
                    <div class="div-recheck">
                       <ul class="div-recheck-ul">
                           <li class="div-recheck-ul-li" id='r-swp'><i class="fa fa-caret-right" aria-hidden="true"></i> <span class="span-probs"></span></li>
                           <li class="div-recheck-ul-li"><i class="fa fa-caret-right" aria-hidden="true"></i> <span>Not the lowest price</span></li>
                           <li class="div-recheck-ul-li"><i class="fa fa-caret-right" aria-hidden="true"></i> <span>Others</span></li>
                           <li class="div-recheck-ul-li" id="r-ols"><i class="fa fa-caret-right" aria-hidden="true"></i> <span>Open Logs</span></li>
                       </ul>
                    </div>  
                </div>
                <div class="pull-right">
                    <div class="cr-modal-cac-list">
                        <ul class="cr-modal-cac-list-ul">
                            <li class="cr-cac-list-btn" id="cr-rtm"><i class="fa fa-caret-right" aria-hidden="true"></i> <span>Report to merchant</span></li>
                            <!-- <li class="cr-cac-list-btn" id="cr-spdf"><i class="fa fa-caret-right" aria-hidden="true"></i> <span>Small price difference, fixed</span></li>
                            <li class="cr-cac-list-btn" id="cr-pbf"><i class="fa fa-caret-right" aria-hidden="true"></i> <span>Proxy problem, fixed</span></li> -->
                            <li class="cr-cac-list-btn" id="cr-cr"><i class="fa fa-caret-right" aria-hidden="true"></i> <span>Set ratings "<b><span class="cac-list-btn-rating"></span></b>"</span></li>
                            <li class="cr-cac-list-btn" id="cr-ptz"><i class="fa fa-caret-right" aria-hidden="true"></i> <span>Price to zero</span></li>
                        </ul>
                    </div>
                    <i class="fa fa-cog cr-modal-show-list" aria-hidden="true" style="font-size: 30px;color: #0062cc;margin-top: 8px; cursor: pointer;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- report recheck log modal -->
<div class="modal fade" id="report-recheck-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
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
        <div class="modal-content" style="border-radius: 0;background-clip: initial;">
            <div class="modal-body">
                <div class="modal-content-header row">
                    <div class="col-12">
                        <h6 class="pull-left confirmation-tittle"></h6>
                        <button type="button" class="close pull-right" data-dismiss="modal" style="opacity: 1;outline:none;left: 30px;top: -32px;border-radius: 20px; position: relative;background-color: #fff; width: 20px;height: 20px;padding: 0;"><span style="position: relative;top: -3px;">&times;</span></button>
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


<!-- report recheck log modal -->
<div class="modal fade" id="open-additional-info" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="border-radius: 0;background-clip: initial;">
            <div class="modal-body">
                <div class="modal-content-header row">
                    <div class="col-12">
                        <h6 class="pull-left confirmation-tittle">Full information</h6>
                        <button type="button" class="close pull-right" data-dismiss="modal" style="opacity: 1;outline:none;left: 30px;top: -32px;border-radius: 20px; position: relative;background-color: #fff; width: 20px;height: 20px;padding: 0;"><span style="position: relative;top: -3px;">&times;</span></button>
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



<!-- add shift modal -->
<div class="modal fade" id="pc-add-shift-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-color: #fff">
            <div class="modal-header">
                <h5 class="modal-title modal-assign-title-txt" id="exampleModalLabel">Add Shift</h5>
                    <button type="button" class="close pull-right" data-dismiss="modal" style="opacity: 1;outline:none;left: 13px;top: -15px;border-radius: 20px; position: relative;background-color: #fff; width: 20px;height: 20px;padding: 0;"><span style="position: relative;top: -3px;">&times;</span></button>
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
<div class="modal fade" id="price_check_tool_modal_add_game" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-daily-title-txt" id="exampleModalLabel">Add Game To Check</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
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
<div class="modal fade" id="add-wrong-aff-link-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-wrong-title-txt" id="exampleModalLabel">Add Wrong Affiliate Links</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
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
