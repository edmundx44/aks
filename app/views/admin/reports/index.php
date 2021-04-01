<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
	<script type="text/javascript">
		$(function (){
			$(document).on('click', '#createReportBtn', function(){
				$('#createReportModal').modal('show');
			})
		});
	</script>
	<style type="text/css">

	</style>
<?php $this->end(); ?>
<?php $this->start('body')?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-body no-padding "> 
					<div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-1">
						<div style="text-align: right">
							<input type="button" name="" value="Create report" class="btn btn-primary" id="createReportBtn" style="left: -10px;margin-top: 10px; position: relative;">
						</div>
					</div>





				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->end()?> 