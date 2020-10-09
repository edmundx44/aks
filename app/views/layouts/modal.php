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
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success addChangeLog">Submit</button>
            </div>
        </div>

    </div>
</div>

<!-- checksum Modal -->
<div id="checksum-modal" class="modal fade" role="dialog">
  <div class="modal-dialog checksum-dialog">

    <!-- Modal content-->
        <div class="modal-content modal-background">
            <div class="modal-header new-head">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title modal-title-1">CHECKSUM</h5>
            </div>
            <div class="modal-body no-padding">

                <div class="modal-checksum-data scrollbar-widht">

                    <?php if(!empty($this->checksumData)): ?>
                        <table class="table table-checksum">
                            <thead class="header-sticky header-titles font-size-2">
                                <tr>
                                    <td>Merchant</td>
                                    <td>Checksum Data</td>
                                    <td>Last Update</td>
                                    <td>Update Count</td>
                                </tr>
                            </thead>
                            <tbody class="font-bold">
                                <?php foreach($this->checksumData as $key): ?>
                                   <?php 
                                    $id = $key->merchant_id;
                                        if(array_key_exists($id, $this->countPerDayChecksum)){
                                            ?>
                                                <tr>
                                                    <td><?= strtoupper($key->merchant_name)." (".$key->merchant_id.")"; ?></td>
                                                    <td><?= $key->checksum_data ?></td>
                                                    <td><?= $this->formatFulltime($key->lastupdate); ?></td>
                                                    <td><?= $this->countPerDayChecksum[$id]['count'] ?></td>
                                                </tr>
                                            <?php
                                        }else{
                                            ?>
                                                <tr>
                                                    <td><?= strtoupper($key->merchant_name)." (".$key->merchant_id.")"; ?></td>
                                                    <td><?= $key->checksum_data ?></td>
                                                    <td><?= $this->formatFulltime($key->lastupdate); ?></td>
                                                    <td>0</td>
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
            <div class="modal-footer new-foot">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-success addChangeLog">Submit</button> -->
            </div>
        </div>

    </div>
</div>

<!-- fail reports Modal -->
<div id="freports-modal" class="modal fade" role="dialog">
    <div class="modal-dialog failed-stores-dialog">

        <!-- Modal content-->
        <div class="modal-content modal-background">
            <div class="modal-header new-head">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title modal-title-1">FAILED STORES (2 HOURS)</h5>
            </div>
            <div class="modal-body new-pad">

                <div class="modal-failed-data">
                    <?php if(!empty($this->failedStores)): ?>
                        <?php foreach($this->failedStores as $key): ?>
                            <div class="new-margin div-stores new-width">
                                <div class="header-flex font-bold ">
                                    <div class="header-flex div-data-stores font-size-2"><?= strtoupper($key->name) ." (". $key->merchant_id.")";?></div>
                                    <div class="div-<?= $this->websiteClass($key->website) ?>"><?= strtoupper($key->website)?></div>
                                </div>
                                <div class="dark-gray"><?= $this->formatFUlltime($key->successRunTime)?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="div-stores modal-no-data">NO FAILED STORES FOR NOW</div>
                    <?php endif; ?>
                </div>

                <div class="modal-footer new-foot">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-success addChangeLog">Submit</button> -->
                </div>
            </div>
        </div>

    </div>
</div>

<!-- success reports  Modal -->
<div id="sreports-modal" class="modal fade" role="dialog">
    <div class="modal-dialog success-stores-dialog">

        <!-- Modal content-->
        <div class="modal-content modal-background">
            <div class="modal-header new-head">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title modal-title-1">Success (2 HOURS)</h5>
            </div>
            <div class="modal-body new-pad">

                <div class="modal-success-data">
                    <?php if(!empty($this->successStores)): ?>
                        <?php foreach($this->successStores as $key): ?>
                        <div class="new-margin div-stores new-width">
                            <div class="header-flex strong font-bold ">
                                <div class="header-flex div-data-stores font-size-2"><?= strtoupper($key->name) ." (". $key->merchant_id.")";?></div>
                                <div class="div-<?= $this->websiteClass($key->website) ?>"><?= strtoupper($key->website)?></div>
                            </div>
                        <div class="dark-gray"><?= $this->formatFUlltime($key->successRunTime)?></div>
                        </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <div class="div-stores modal-no-data">NO SUCCESS RUNTIME FOR NOW</div>
                    <?php endif; ?>
                </div>

            </div>
            <div class="modal-footer new-foot">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-success addChangeLog">Submit</button> -->
            </div>
        </div>

    </div>
</div>