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