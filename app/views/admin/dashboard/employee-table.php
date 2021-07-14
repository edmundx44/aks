<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
	<link rel="stylesheet" href="<?=PROOT?>vendors/css/employee-table.css" media="screen" title="no title" charset="utf-8">
	<script type="text/javascript" src="<?=PROOT?>vendors/js/employee-table.js"></script>  

	<!-- data tables -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" >
	<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<?php $this->end(); ?>

<?php $this->start('body')?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 mtop-35px">
			<div class="card card-style">
				<div class="card-body rdl-card-main-wrap no-padding">
					<!-- HEADER STARTS row-4-card-div-overflow-style-->
					<div class="card-div-overflow-style row-4-card-div-overflow-style-2 et-div-header">
						<div class="row et-div-header-row">
							<div class="div-topheader-1 col-lg-12">
								<h5 class="et-div-header-h5">Employees Count Activity</h5>
								<p class="et-div-header-p">Display all actions create, open, modify and delete for every employee</p>
							</div>
						</div>
					</div >
					<div class="activities-content">
						<div class="filter-activities">
							<span class="ac-add-filter"><i class="fas fa-plus-square"></i> &nbsp; <span class="ac-add-filter-span">Add Filter</span></span>
							<div class="filter-functions">
								<div class="dropdown filter-function-date">
									<div>
										<input id="date-start" class="form-control" type="text" placeholder="Date" value="">
									</div>
								</div>

								<div class="dropdown filter-function-date">
									<div>
										<input id="date-end" class="form-control" type="text" placeholder="Date" value="">
									</div>
								</div>
								<div class="filter-function-date">
									<button class="btn btn-success" id="date-submit-filter">Search</button>
								</div>
							</div>
						</div>

						<div class="display-activities-content"> 
							<table class="col-12">

							</table>
						</div>
					</div>
					<!-- CONTENT STARTS -->
					<div class="col-xs-12 div-body-table mt-4 mb-2" class="merchant-edition">
						<table id="user-counts-table" class="display" width="100%">
								
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->end()?>

