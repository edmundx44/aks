<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
	<link rel="stylesheet" href="<?=PROOT?>vendors/css/price-check.css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>
	<script type="text/javascript" src="<?=PROOT?>vendors/js/price-check.js"></script>
<?php $this->end(); ?>
<?php $this->start('body')?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-body no-padding"> 
					<div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-1">
						<p class="card-bulletin pc-card-bulitin">MENU :</p>
						<ul class="pc-cb-ul-menu">
							<li class="pc-li-btn active-pc-menu" id="pc-cda-div">Daily Activity</li>
							<li class="pc-li-btn" id="pc-ac-div">Assign Checker</li>
							<li class="pc-li-btn" id="pc-adlg-div">Add Daily Listing</li>
							<li class="pc-li-btn" id="pc-pr-div">Affiliate Problem Report</li>
						</ul>
					</div>

					<div class="pc-content">
						<div class="pc-content-div pc-cda-div">
							<div class="form-group">
								<div class="user-input-wrp">
									<br/>
									<input type="text" value='' class="inputText" id="pc-cda-search" onkeyup="this.setAttribute('value', this.value);"/>
									<span class="floating-label pc-cda-search-span ">Search checker or activity</span>
									<i class="fa fa-search pc-cda-search-icon"></i>
								</div>
							</div>

							<table class="col-12">
								<thead>
									<tr class="pc-header-tr">
										<th class="pc-cda-table-h-sticky pc-th-class">Checker</th>
										<th class="pc-cda-table-h-sticky pc-th-class" style="width: 100px;">Game ID</th>
										<th class="pc-cda-table-h-sticky pc-th-class">Game Name</th>
										<th class="pc-cda-table-h-sticky pc-th-class">Activity</th>
										<th class="pc-cda-table-h-sticky pc-th-class">Url</th>
										<th class="pc-cda-table-h-sticky pc-th-class">Date</th>
									</tr> 
								</thead>
								<tbody class="pc-cda-div-display">
									<!-- dynamic data here from database -->
								</tbody>
								<tfoot class="pc-cda-tfoot">
									<tr>
										<td colspan="6" style="" class="text-center pt-4">
											<p>
												<span class="data-display-function pc-lmore-fucntion mr-1"> 
													<i class="fa fa-spinner" aria-hidden="true"></i> Load More 
												</span> 
												<span class="data-display-function pc-dall-function ml-1"> 
													<i class="fa fa-globe" aria-hidden="true"></i> Display All
												</span>
											</p>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="pc-content-div pc-ac-div">
							<div class="form-group pull-right">
								<button class="btn btn-primary" data-toggle="modal" data-target="#pc-add-shift-modal" style="width: 200px;"><i class="fa fa-plus-square" aria-hidden="true"></i> &nbsp; Add shift</button>
							</div>

							<table class="col-12">
								<thead>
									<tr class="pc-header-tr">
										<th class="pc-cda-table-h-sticky pc-th-class">Assign Checker</th>
										<th class="pc-cda-table-h-sticky pc-th-class">Week Day's</th>
										<th class="pc-cda-table-h-sticky pc-th-class">Sunday</th>
										<th class="pc-cda-table-h-sticky pc-th-class pc-th-class-wc">Action</th>
									</tr> 
								</thead>
								<tbody class="pc-ac-div-display">
									<!-- dynamic data here from database -->
								</tbody>
							</table>
						</div>
						<div class="pc-content-div pc-adlg-div">
							<div class="form-group pull-right">
								<button class="btn btn-primary" data-toggle="modal" data-target="#price_check_tool_modal_add_game" style="width: 200px;"><i class="fa fa-plus-square" aria-hidden="true"></i> &nbsp; Add Games</button>
							</div>

							<table class="col-12">
								<thead>
									<tr class="pc-header-tr">
										<th class="pc-cda-table-h-sticky pc-th-class">ID</th>
										<th class="pc-cda-table-h-sticky pc-th-class">Game Name</th>
										<th class="pc-cda-table-h-sticky pc-th-class">Release Date</th>
										<th class="pc-cda-table-h-sticky pc-th-class">Created By</th>
										<th class="pc-cda-table-h-sticky pc-th-class">Date Created</th>
										<th class="pc-cda-table-h-sticky pc-th-class pc-th-class-wc">Action</th>
									</tr> 
								</thead>
								<tbody class="pc-adlg-div-display">
									<!-- dynamic data here from database -->
								</tbody>
							</table>
						</div>
						<div class="pc-content-div pc-pr-div">
							<div class="form-group pull-left">
								<div class="p-2 bg-danger text-white rounded text-center" style="width: 250px;">Today's Problem  &nbsp; : &nbsp; <b><span class="result-today"></span></b> </div>
							</div>

							<div class="form-group pull-right">
								<button class="btn btn-primary" data-toggle="modal" data-target="#add-wrong-aff-link-modal" style="width: 200px;"><i class="fa fa-plus-square" aria-hidden="true"></i> &nbsp; Add Wrong Affiliate</button>
							</div>

							<table class="col-12">
								<thead>
									<tr class="pc-header-tr">
										<th class="pc-cda-table-h-sticky pc-th-class">Number of affiliate links problem</th>
										<th class="pc-cda-table-h-sticky pc-th-class">Date added</th>
										<th class="pc-cda-table-h-sticky pc-th-class pc-th-class-wc">Action</th>
									</tr> 
								</thead>
								<tbody class="pc-pr-div-display">
									<!-- dynamic data here from database -->
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->end()?>
