<?php $this->setSiteTitle($this->pageTitle); ?>

<!-- css -->
<?php $this->start('head'); ?>
	<link rel="stylesheet" href="<?=PROOT?>vendors/css/reports-page.css" media="screen" title="no title" charset="utf-8">
<?php $this->end(); ?>
<!-- css -->

<!-- js -->
<?php $this->start('body-script'); ?>
	<script type="text/javascript" src="<?=PROOT?>vendors/js/reports-page.js"></script>
<?php $this->end(); ?>
<!-- js -->

<?php $this->start('body')?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 mtop-35px">
				<div class="card card-style card-normalmode">
					<div class="card-body no-padding "> 
						<div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-1">
							<div class="cr-create-report-btn-div">
								<input type="button" name="" value="Create report" class="btn btn-primary" id="createReportBtn">
							</div>
							<p class="cr-title">PROBLEM LIST</p>
						</div>

						<div class="cr-list">
							<div>
								<input type="button" name="" class="problem-lis-tab-btn normal-mode" id="pltb-report" value="Report">
								<input type="button" name="" class="problem-lis-tab-btn problem-lis-tab-btn-not-active" id="pltb-completed" value="Completed">
								<div class="hide-extra hide-extra1 normal-mode"></div>
								<div class="hide-extra hide-extra2 normal-mode"></div>
							</div>
							<div>
								<div class="pltb-report normal-mode">
									<input type="text" id="datepickerReport" placeholder="Date here" class="float-right datepicker-class">
									<i class="far fa-calendar-alt float-right datepicker-class-icon"></i>
									<span class="float-right span-all-report">Display All <i class="fas fa-globe float-right"></i></span>
									<br>
									<br>
									<div class="display-div">
										<table class="display-table">
											<thead>
												<tr class="thead-tr-style">
													<td class="td-1st-child normal-mode"></td>
													<td class="" style="width: 35%;padding: 15px 0 15px 15px;">URL</td>
													<td class="" style="width: 5%;text-align: center;">SITE</td>
													<td class="" style="width: 15%;text-align: center;">PROBLEM</td>
													<td class="" style="width: 25%;text-align: center;">ACTION</td>
													<td class="" style="width: 15%;text-align: center;">Date Added</td>
												</tr>
												
											</thead>
											<tbody class="cr-tbody">
												
											</tbody>
										</table>
									</div>
								</div>
								
								<div class="pltb-completed normal-mode">
									<!-- <input type="text" id="datepickerComplete" placeholder="Date here" class="float-right datepicker-class">
									<i class="far fa-calendar-alt float-right datepicker-class-icon"></i> -->
									<br>
									<br>
									<div class="display-div">
										<table class="display-table">
											<thead>
												<tr class="thead-tr-style">
													<!-- <td class="" style="padding: 15px 0 15px 0; text-align: center;">MERCHANT</td> -->
													<!-- <td class="" style="">WEBSITE</td> -->
													<!-- <td class="" style="padding: 15px 0 15px 0; text-align: center;">PROBLEM</td> -->
													<td class="" style="padding: 15px 0 15px 0;text-align:center;">ON SITE</td>
													<td class="" style="text-align:center;">ON FEED</td>
													<td class="" style="text-align:center;">ON MSITE</td>
													<td class="" style="">FEEDBACK</td>
													<!-- <td class="" style="">CHECKER</td> -->
													<td class="" style="">DATE</td>
													<td class="" style="text-align:center;">ACTION</td>
												</tr>
											</thead>
											<tbody class="display-completed-data">
												
											</tbody>
										</table>
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $this->end()?>