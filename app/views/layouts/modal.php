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
    <div class="modal-dialog modal-md">
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
                            <input type="text" value='' class="inputText" onkeyup="this.setAttribute('value', this.value);"/>
                            <span class="floating-label">URL</span>
                        </div>
                    </div>

                    <div class="col-6">
                        <br/>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle cr-select-site-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;text-align: left;">Select Site</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%;">
                                        <a class="dropdown-item" href="#">AKS</a>
                                        <a class="dropdown-item" href="#">CDD</a>
                                        <a class="dropdown-item" href="#">BREX</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <br/>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle cr-select-problem-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;text-align: left;">Select Problem</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 100%;">
                                        <a class="dropdown-item" href="#">Wrong price</a>
                                        <a class="dropdown-item" href="#">Wrong stock</a>
                                        <a class="dropdown-item" href="#">Other</a>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">SUBMIT</button>
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
</style> 