<!-- Modal -->
<div id="show-add-log-modal" class="modal fade" role="dialog">
    <div class="modal-dialog changelog-dialog">

        <!-- Modal content-->
        <div class="modal-content modal-background">
            <div class="modal-header new-head">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title modal-title-1">Add Change Log</h5>
            </div>
            <div class="modal-body no-padding div-stores modal-body-mg">
                <dic class="row">
                    <div class="form-group col-md-6">
                        <label>ID :</label>
                        <input type="text" name="" class="form-control alog-id">
                    </div>
                    <div class="form-group col-md-6">
                        <label>DATE :</label>
                        <input type="text" name="" class="form-control alog-date" disabled>
                    </div>
                    <div class="col-md-12 div-textarea">
                        <textarea class="alog-textarea"></textarea>
                    </div>
                </dic>
            </div>
            <div class="modal-footer new-foot">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success addChangeLog">Submit</button>
            </div>
        </div>

    </div>
</div>

<!-- checksum Modal -->
<div id="checksum-modal" class="modal fade" role="dialog">
  <div class="modal-dialog checksum-dialog">

    <!-- Modal content-->
        <div class="modal-content modal-con-override">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title dateChange">CHECKSUM 
                    <?php 
                        echo "(PH:". $today = date('M d',strtotime(date('M d'))).")";
                    ?>
                </h5>
                <div class="div-inputDate">INPUT: <input type="text" value="<?=date('Y-m-d')?>" data-phDate='<?=date('Y-m-d')?>' data-year='<?=date('Y')?>' class="chk-inputDate" placeholder="YYYY-MM-DD" maxlength="10"onkeypress="return isNumber(event)"></div>
            </div>
            <div class="div-btn-checksum">
                <input type="button" class="btn btn-success container-fluid-wrap" data-modal-checksumsite="aks" id="modal-checksum-site" value="AKS">
            </div>
            <div class="modal-body">
                <div class="modal-checksum-data">
                    <?php if(!empty($this->checksumData)): ?>
                        <table class="table table-checksum">
                            <thead>
                                <tr>
                                    <th>Merchant</td>
                                    <th>Checksum Data</td>
                                    <th>Last Update</td>
                                    <th>Count</td>
                                </tr>
                            </thead>
                            <tbody class="checksum-body">
                                <?php foreach($this->checksumData as $key): ?>
                                   <?php 
                                    $id = $key['merchant_id'];
                                        if(array_key_exists($id, $this->countPerDayChecksum)){
                                            ?>
                                                <tr class="getCount" data-count="<?= $this->countPerDayChecksum[$id]['count'] ?>">
                                                    <td class="tbody-td-1"><?= strtoupper($key['merchant_name'])." (".$key['merchant_id'].")"; ?></td>
                                                    <td class="tbody-td-2"><?= $key['checksum_data'] ?></td>
                                                    <td class="tbody-td-3"><?= $this->formatFulltime($key['lastupdate']); ?></td>
                                                    <td class="tbody-td-1 text-center"><?= $this->countPerDayChecksum[$id]['count'] ?></td>
                                                </tr>
                                            <?php
                                        }else{
                                            ?>
                                                <tr class="getCount" data-count="0">
                                                    <td class="tbody-td-1"><?= strtoupper($key['merchant_name'])." (".$key['merchant_id'].")"; ?></td>
                                                    <td class="tbody-td-2"><?= $key['checksum_data'] ?></td>
                                                    <td class="tbody-td-3"><?= $this->formatFulltime($key['lastupdate']); ?></td>
                                                    <td class="tbody-td-1 text-center">0</td>
                                                </tr>
                                            <?php      
                                        }    
                                   ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="div-stores modal-no-data">NO DATA FOR NOW</div>
                    <?php endif; ?>  

                 </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-success addChangeLog">Submit</button> -->
            </div>
        </div>

    </div>
</div>

<!-- fail reports Modal -->
<div id="freports-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content modal-con-override">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">FAILED STORES (2 HOURS)</h5>
            </div>
            <div class="modal-body">
                <div class="modal-reports-data">
                    <?php if(!empty($this->failedStores)): ?>
                        <?php foreach($this->failedStores as $key): ?>
                            <div class="div-data-col col-xs-6">
                                <div class="pull-left"><?= strtoupper($key->name) ." (". $key->merchant_id.")";?></div>
                                <div class="pull-right color-<?= $this->websiteClass($key->website) ?>"><?= strtoupper($key->website)?></div>
                                <br>
                                <div><?= $this->formatFUlltime($key->successRunTime)?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <h4 class="text-center">" NO FAILED STORES FOR NOW "</h4>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning close-btn" data-dismiss="modal">Close</button>
                 <!-- <button type="button" class="btn btn-success addChangeLog">Submit</button> -->
            </div>
        </div>

    </div>
</div>

<!-- success reports  Modal -->
<div id="sreports-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content modal-con-override">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">SUCCESS (2 HOURS)</h5>
            </div>
            <div class="modal-body">
                <div class="modal-reports-data">
                    <?php if(!empty($this->successStores)): ?>
                        <?php foreach($this->successStores as $key): ?>
                            <div class="div-data-col col-xs-6">
                                <div class="pull-left"><?= strtoupper($key->name) ." (". $key->merchant_id.")";?></div>
                                <div class="pull-right color-<?= $this->websiteClass($key->website) ?>"><?= strtoupper($key->website)?></div>
                                <br>
                                <div><?= $this->formatFUlltime($key->successRunTime)?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <h4 class="text-center">" NO SUCCESS RUNTIME FOR NOW "</h4>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning close-btn" data-dismiss="modal">Close</button>
                 <!-- <button type="button" class="btn btn-success addChangeLog">Submit</button> -->
            </div>
        </div>

    </div>
</div>