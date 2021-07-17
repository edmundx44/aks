<?php $this->setSiteTitle($this->pageTitle); ?>

<?php $this->start('head'); ?>
	<link rel="stylesheet" href="<?=PROOT?>vendors/css/utilities-page.css" media="screen" title="no title" charset="utf-8">
<?php $this->end(); ?>

<?php $this->start('body-script'); ?>
	<script type="text/javascript" src="<?=PROOT?>vendors/js/critics-error.js"></script>
<?php $this->end(); ?>

<?php $this->start('body')?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 mtop-35px">
				<div class="card card-style">
					<div class="card-body no-padding">
						<!-- HEADER STARTS row-4-card-div-overflow-style-->
						<div class="card-div-overflow-style row-4-card-div-overflow-style-2" style="position:relative; padding-top:20px;">
							<div class="row" style="color:#fff;margin: 0;">
								<div class="header-div col-lg-10">
									<h5 class="header-title-page">Metacritics Error Check</h5>
									<p class="header-text-paragraph">Error will appears here if the critics or user rating score is above <b class="cdd_color" style="font-size:18px">10</b></p>
								</div>
							</div>
						</div>
						<!-- CONTENT STARTS row-4-card-div-overflow-style-->
						<div>
							<div class="col-lg-12" style="font-size: 14px;">
								<table id="table-metacritics-error-rating" class="display" width="100%">

								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $this->end()?> 