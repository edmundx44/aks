<div class="row report-div">
    <div class="col-sm-12 no-padding">
        <div class="col-md-3 report-div-sub">
            <div class="col-md-12 no-padding report-div-sub-sub report-ds">
                <p class="p-count">
                    <?php if(($this->disabledStores) != FALSE): ?>
                        <?= count($this->disabledStores) ?>
                    <?php endif; ?>
                </p>
                <p class="p-rname">Disabled Stores</p>
                <i class="fa fa-reply-all rdss-icon" aria-hidden="true"></i>
                <div class="display-data-report scrollbar-custom scrollbar-custom-ds">
                    <?php if(($this->disabledStores) != FALSE): ?>
                        <?php foreach($this->disabledStores as $key): ?>
                            <div class="report-ds-con-wrap">
                                <div class="report-ds-data">
                                    <?= strtoupper($key['store']) ." (" .$key['id'].')'?>
                                </div>
                            </div>
                        <?php endforeach;?>
                    <?php else:?>
                        <div class="">
                            Http error request failed. Please reload the page!!
                        </div>
                    <?php endif; ?>
                </div>
                <div class="report-foot">
                    <i class="fa fa-ban pull-left" aria-hidden="true"></i>
                    <p class="pull-right view-more-div" id="report-ds" data-text="Hide">View More</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 report-div-sub">
            <div class="col-md-12 no-padding report-div-sub-sub report-akssnap">
                <p class="p-count">
                    <?php if(($this->getSnapshotAks) != FALSE): ?>
                        <?= count($this->getSnapshotAks) ?>
                    <?php endif; ?>
                </p>
                <p class="p-rname">AKS Snapshot</p>
                <i class="fa fa-reply-all rdss-icon" aria-hidden="true"></i>
                <div class="display-data-report scrollbar-custom scrollbar-custom-akssnap">
                    <?php foreach($this->getSnapshotAks as $key): ?>
                        <div class="report-akssnap-con-wrap">
                            <div class="report-akssnap-data-title-div">
                                <div class="pull-left report-akssnap-data-title"><?= strtoupper($key->merchantName) ." (" .$key->merchantID.')'?></div>
                                <div class="div-<?= $this->buttonClass($key->updatedCount,$key->databaseCount)?> pull-right"><?= $key->difference ?></div>
                            </div>
                            <table class="table">
                                <tr>
                                    <th class="custom-width-th">UC</th>
                                    <th class="custom-width-th"># in DB</th>
                                    <th>Time scan</th>
                                    <th>DSS</th>
                                </tr>
                                <tr>
                                    <td><?= strtoupper($key->updatedCount)?></td>
                                    <td><?= strtoupper($key->databaseCount)?></td>
                                    <td><?= preg_replace('/H/', 'H ', strtoupper($key->timeToScan)) ?></td>
                                    <td><?= preg_replace('/H/', 'H ', strtoupper($key->timeSinceScan)) ?></td>
                                </tr>
                            </table>
                        </div>
                    <?php endforeach;?>
                </div>
                <div class="report-foot">
                    <i class="fa fa-tag pull-left" aria-hidden="true"></i>
                    <p class="pull-right view-more-div" id="report-akssnap" data-text="Hide">View More</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 report-div-sub">
            <div class="col-md-12 no-padding report-div-sub-sub report-cddsnap">
                <p class="p-count">
                    <?php if(($this->getSnapshotCdd) != FALSE): ?>
                        <?= count($this->getSnapshotCdd) ?>
                    <?php endif; ?>
                </p>
                <p class="p-rname">CDD Snapshot</p>
                <i class="fa fa-reply-all rdss-icon" aria-hidden="true"></i>
                <div class="display-data-report scrollbar-custom scrollbar-custom-cddsnap">
                    <?php foreach($this->getSnapshotCdd as $key): ?>
                        <div class="report-cddsnap-con-wrap">
                            <div class="report-cddsnap-data-title-div">
                                <div class="pull-left report-cddsnap-data-title"><?= strtoupper($key->merchantName) ." (" .$key->merchantID.')'?></div>
                                <div class="div-<?= $this->buttonClass($key->updatedCount,$key->databaseCount)?> pull-right"><?= $key->difference ?></div>
                            </div>
                            <table class="table">
                                <tr>
                                    <th class="custom-width-th">UC</th>
                                    <th class="custom-width-th"># in DB</th>
                                    <th>Time scan</th>
                                    <th>DSS</th>
                                </tr>
                                <tr>
                                    <td><?= strtoupper($key->updatedCount)?></td>
                                    <td><?= strtoupper($key->databaseCount)?></td>
                                    <td><?= preg_replace('/H/', 'H ', strtoupper($key->timeToScan)) ?></td>
                                    <td><?= preg_replace('/H/', 'H ', strtoupper($key->timeSinceScan)) ?></td>
                                </tr>
                            </table>
                        </div>
                    <?php endforeach;?>
                </div>
                <div class="report-foot">
                    <i class="fa fa-tags pull-left" aria-hidden="true"></i>
                    <p class="pull-right view-more-div" id="report-cddsnap" data-text="Hide">View More</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 report-div-sub">
            <div class="col-md-12 no-padding report-div-sub-sub report-dbfc">
                <p class="p-count">
                    <?php if(($this->dbCountFeedCount) != FALSE): ?>
                        <?= count($this->dbCountFeedCount) ?>
                    <?php endif; ?>
                </p>
                <p class="p-rname">DB/Feed Count</p>
                <i class="fa fa-reply-all rdss-icon" aria-hidden="true"></i>
                <div class="display-data-report scrollbar-custom scrollbar-custom-dbfc">
                    <div class="report-dbfc-con-wrap">
                        <?php foreach($this->dbCountFeedCount as $key): 
                            if($key->dbCount == 0)
                            continue;
                        ?>
                            <div class="div-<?=$key->website?>-site">
                                <div class="report-dbfc-data-title-div">
                                    <div class="report-dbfc-data-title"><?= strtoupper($key->name) ." (" .$key->merchant_id.')'?></div>
                                </div>
                                <br>
                                <div class="report-dbfc-data">
                                    <div class="">Website : <?= strtoupper($key->website)?></div>
                                    <div class="">Database Count : <?= $key->dbCount ?></div>
                                    <div class="">Feed Count : <?= $key->feedCount ?></div>
                                    <div class="">% DB/FC : <?= round($key->differences, 0)."%" ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <div class="report-foot">
              <i class="fa fa-compress pull-left" aria-hidden="true"></i>
              <p class="pull-right view-more-div" id="report-dbfc" data-text="Hide">View More</p>
            </div>
            </div>
        </div>

    </div>
</div>