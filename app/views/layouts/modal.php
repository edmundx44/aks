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
        <div class="modal-content modal-con-override">
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
                            <tr class='getCount'>
                                <td class="tbody-td-1" data-tbl-td="Merchant"><b>Royal Key Software (285)</b></td>
                                <td class="tbody-td-2" data-tbl-td="Checksum">4fa0d3f7068cff3c95993c23734461e0</td>
                                <td class="tbody-td-3" data-tbl-td="Last Update">Mar 17 2021 05:50 PM</td>
                                <td class="tbody-td-1 text-center" data-tbl-td="Status"><b>Updated</b></td>
                            </tr>
                            <tr class='getCount'>
                                <td class="tbody-td-1" data-tbl-td="Merchant"><b>Eneba (285)</b></td>
                                <td class="tbody-td-2" data-tbl-td="Checksum">4fa0d3f7068cff3c95993c23734461e0</td>
                                <td class="tbody-td-3" data-tbl-td="Last Update">Mar 17 2021 05:50 PM</td>
                                <td class="tbody-td-1 text-center" data-tbl-td="Status"><b>Updated</b></td>
                            </tr>

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
                            <input type="text" value='' class="inputText" id="cr-url-txtbox" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">URL</span>
                        </div>
                        <div style="padding: 10px;margin-left: 15px;font-size: 12px;letter-spacing: 1px;" class="url-msg">
                            
                        </div>
                    </div>
                    <br/> 
                    <br/> 
                    <br/>
                    <div class="col-12 ">

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
                    </div>

                    <div class="col-12">
                        <br/>
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
                            <input type="text" value='' class="inputText cr-txtbox-problem-div" id="" onkeyup="this.setAttribute('value', this.value);"/>
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


<!-- Create reports reports modal -->
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


                </p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <span class="cr-cac-site" style="position: relative; text-align: center;letter-spacing: 2px; font-weight: 700;background-color: #777;padding: 0 15px 0 15px;color: #fff;z-index: 1;"></span>
                        <div class="site-data">
                            
                        </div>
                    </div>
                    <div class="col-6">
                        <span style="position: relative; text-align: center;letter-spacing: 2px; font-weight: 700;background-color: #777;padding: 0 15px 0 15px;color: #fff;z-index: 1;">MERCHANT FEED</span>
                        <div class="mfeed-data">
                           
                        </div>
                    </div>
                    <div class="col-12" style="height: 100px;">
                        <textarea placeholder="add image here" style="width: 100%;height: 100%;resize: none;border: solid 2px #777;"></textarea>
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
                    <a class="btn btn-primary cr-msite-btn" target="_blank">Open merchant site</a>
                    <button type="button" class="btn btn-success">Fixed</button>
                </div>
                <div class="pull-right">
                    <div class="cr-modal-cac-list">
                        <ul class="cr-modal-cac-list-ul">
                            <li class="cr-cac-list-btn" id="cr-rtm"><i class="fa fa-caret-right" aria-hidden="true"></i> <span>Report to merchant</span></li>
                            <li class="cr-cac-list-btn" id="cr-spdf"><i class="fa fa-caret-right" aria-hidden="true"></i> <span>Small price difference, fixed</span></li>
                            <li class="cr-cac-list-btn" id="cr-pbf"><i class="fa fa-caret-right" aria-hidden="true"></i> <span>Proxy problem, fixed</span></li>
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


<style type="text/css">
    .dropdown-toggle::after {
        position: absolute;
        right: 15px;
        top: 17px;
    }
    .site-data, 
    .mfeed-data {
        top: -12px;
        
       /* border: none;
        border-top: solid 2px #777;*/
        position: relative;
        padding: 20px 15px 15px 15px;
    }
    .ms-data-price {
        font-weight: 700;
    }
    .ms-data-price,
    .ms-data-stock,
    .ms-data-url {
        font-size: 15px;
    }
    .ms-data-url {
        word-break: break-all;
    }
    .cr-modal-cac-list {
        width: 250px;
        height: 200px;
        position: absolute;
        bottom: 5px;
        right: 55px;
        box-shadow: 0 1px 5px 0 rgb(0 0 0 / 56%);
        background-color: #fff;
        display: none;
    }
    .cr-modal-cac-list:after {
        content: "";
        width: 0;
        height: 0;
        bottom: 10px;
        right: -10px ;
        box-sizing: border-box;
        border: 5px solid black;
        border-color: transparent transparent #fff #fff;
        transform-origin: 0 0;
        transform: rotate(-135deg);
        box-shadow: -3px 3px 3px 0 rgb(0 0 0 / 20%);
        position: absolute;
    }
    .cr-modal-cac-list-ul {
        list-style-type: none;
        margin-top: 10px;
        padding: 0px;
    }
    .cr-modal-cac-list-ul li {
        padding: 5px 15px 5px 15px;
        cursor: pointer;
        /*border: solid 1px red;*/
    }
    .cr-modal-cac-list-ul li:hover > span {
        text-decoration: underline;
    }
    .cr-modal-show-list:hover {
        color: #004ea3 !important;
    }
</style>