<?php $this->start('body')?>
<div class="dashboard-div">
	<div class="row db-header font-bold">
		<div class="top-btn">
			<div class="list-bar pull-right text-center visible-xs-block visible-sm-block">
				<i class="fa fa-bars" aria-hidden="true"></i>
			</div>
			
		</div>
		<div class="db-title"><i class="fa fa-bar-chart" aria-hidden="true"></i><span>Dashboard</span></div>
		<div class="bread-crumb">AKS - DASHBOARD</div>
		
		<div class="form-group col-md-6 text-search">
			<span class="glyphicon glyphicon-search form-control-feedback span-override"></span>
			<input type="text" class="form-control" placeholder="Search">
		</div>
	</div>

	<div class="row dashboard-content">
		<div class="col-md-6">
			<div class="content-wrap">
				<div class="content-title">
					<i class="fa fa-exclamation-circle" aria-hidden="true"></i>
					<span class="header-titles">Checksum Stores Update Chart</span>
					<!-- <div class="div-arrow">
						<i class="fa fa-angle-double-down i-arrow" aria-hidden="true"></i>
					</div> -->
				</div>
				<div class="content-display">
					<div class="col-md-12 no-padding canvas-div">
						<canvas id="myChart" class="checksum-canvas"></canvas>
					</div>
					<div class="col-md-12" style="top:260px;position:absolute;height: 200px">
						<div class="row">
							<div class="col-xs-8">
								<canvas id="reportChart" class="reports-canvas"></canvas>
								<!-- style="height:30vh; width:80vw" -->
							</div>
							<div class="col-xs-4 btn-reports-div">
								<input type="button" name="" class="btn btn-primary f-width" value="Checksum" data-toggle="modal" data-target="#checksum-modal">
								<input type="button" name="" class="btn btn-danger f-width" value="Fail Reports" data-toggle="modal" data-target="#freports-modal">
								<input type="button" name="" class="btn btn-success f-width" value="Success Reports" data-toggle="modal" data-target="#sreports-modal">
							</div>
						</div>
						
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-md-6">
			<div class="content-wrap" style="background-color: rgb(12,238,108, .5 );">
				<div class="content-title">
					<i class="fa fa-cubes" aria-hidden="true"></i>
					<span class="header-titles">Add Change Log</span>
					<div class="div-arrow">
						<i class="fa fa-angle-double-up i-arrow" aria-hidden="true"></i>
					</div>
				</div>
				<div class="content-display-change-log scrollbar-widht">
					<div class="col-md-6 pull-right">
						<input type="button" class="btn btn-success f-width add-change-log-btn" value="ADD LOG" data-toggle="modal" data-target="#show-add-log-modal">
					</div>
					<div class="col-md-12">
						<ul class="change-log-div font-bold">
						
						</ul>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="row dashboard-reports">
		<h4 class="text-center header-titles">REPORTS</h4>
		<h4 class="text-center"><i class="fa fa-minus" aria-hidden="true"></i></h4>
		
		<div class="col-md-3 dr-con">
			<div class="dr-con-dev">
				<div class="dr-con-dev-title">
					<i class="fa fa-ban" aria-hidden="true"></i>
					<?php if(($this->disabledStores) != FALSE): ?>
						<span class="header-titles">Disabled <?= count($this->disabledStores)." "; ?> Stores</span>
					<?php else:?>
						<span class="header-titles">Disabled Stores</span>
					<?php endif; ?>
				</div>
				<div class="dr-con-dev-content scrollbar-widht">
					<?php if(($this->disabledStores) != FALSE): ?>
						<?php foreach($this->disabledStores as $key): ?>
							<div class="div-stores div-disabled-sizing header-titles">
								<?= strtoupper($key['store']) ." (" .$key['id'].')'?>
							</div>
						<?php endforeach;?>
					<?php else:?>
						<div class="modal-no-data div-stores">
							Http error request failed. Please reload the page!!
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="col-md-3 dr-con" style="padding-right: 10px;">
			<div class="dr-con-dev">
				<div class="dr-con-dev-title">
					<i class="fa fa-address-card" aria-hidden="true"></i>
					<span class="header-titles">AKS Snapshot</span>
				</div>
				<div class="dr-con-dev-content scrollbar-widht">
					<?php foreach($this->getSnapshotAks as $key): ?>
						<div class="div-stores">
							<div class="div-stores-headers header-flex">
								<div class="div-data-stores header-titles"><?= strtoupper($key->merchantName) ." (" .$key->merchantID.')'?></div>
								<div class="div-<?= $this->buttonClass($key->updatedCount,$key->databaseCount)?>"><?= $key->difference ?></div>
							</div>
							<table class="table mb font-size-1">
								<tr>
									<th>UC</th>
									<th># in DB</th>
									<th>Time scan</th>
									<th>DSS</th>
								</tr>
								<tr>
									<td class="vuc"><?= strtoupper($key->updatedCount)?></td>
									<td class="vdb"><?= strtoupper($key->databaseCount)?></td>
									<td class="vts"><?= preg_replace('/H/', 'H ', strtoupper($key->timeToScan)) ?></td>
									<td class="vds"><?= preg_replace('/H/', 'H ', strtoupper($key->timeSinceScan)) ?></td>
								</tr>
							</table>
						</div>
					<?php endforeach;?>
				</div>
			</div>
		</div>

		<div class="col-md-3 dr-con" style="padding-left: 7px;">
			<div class="dr-con-dev">
				<div class="dr-con-dev-title">
					<i class="fa fa-address-card-o" aria-hidden="true"></i>
					<span class="header-titles">CDD Snapshot</span>
				</div>
				<div class="dr-con-dev-content scrollbar-widht">
					<?php foreach($this->getSnapshotCdd as $key): ?>
						<div class="div-stores">
							<div class="div-stores-headers header-flex">
								<div class="div-data-stores header-titles"><?= strtoupper($key->merchantName) ." (" .$key->merchantID.')'?></div>
								<div class="div-<?= $this->buttonClass($key->updatedCount,$key->databaseCount)?>"><?= $key->difference ?></div>
							</div>
							<table class="table mb font-size-1">
								<tr>
									<th>UC</th>
									<th># in DB</th>
									<th>Time scan</th>
									<th>DSS</th>
								</tr>
								<tr>
									<td class="vuc"><?= strtoupper($key->updatedCount)?></td>
									<td class="vdb"><?= strtoupper($key->databaseCount)?></td>
									<td class="vts"><?= preg_replace('/H/', 'H ', strtoupper($key->timeToScan)) ?></td>
									<td class="vds"><?= preg_replace('/H/', 'H ', strtoupper($key->timeSinceScan)) ?></td>
								</tr>
							</table>
						</div>
					<?php endforeach;?>
				</div>
			</div>
		</div>

		<div class="col-md-3 dr-con no-padding">
			<div class="dr-con-dev">
				<div class="dr-con-dev-title">
					<i class="fa fa-compress" aria-hidden="true"></i>
					<span class="header-titles">Database/Feed Count</span>
				</div>
				<div class="dr-con-dev-content scrollbar-widht">
					<?php foreach($this->dbCountFeedCount as $key): 
						if($key->dbCount == 0)
							continue;
					?>
						<div class="div-stores">
							<div class="header-flex div-stores-headers">
								<div class="div-data-stores header-titles" ><?= strtoupper($key->name) ." (" .$key->merchant_id.')'?></div>
								<div class="div-<?= $this->websiteClass($key->website) ?>"><?= strtoupper($key->website)?></div>
							</div>
							<div class="div-DbFc-sizing font-size-1">
								<div class="">Database Count : <?= $key->dbCount ?></div>
								<div class="">Feed Count : <?= $key->feedCount ?></div>
								<div class="">% DB/FC : <?= round($key->differences, 0)."%" ?></div>
							</div>
			            </div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		asdas<br>
		asdas<br>
		asdas<br>
		asdas<br>
		asdas<br>
		asdas<br>
		asdas<br>
		asdas<br>
		asdas<br>
		asdas<br>
	</div>
</div>
<?php $this->end()?>
