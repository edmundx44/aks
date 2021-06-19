<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<script type="text/javascript">
	
</script>
<script>
	$(function() {
		$(document).on('click input', '.me-merchant-selinp',function(){
			$('.dropdown-menu-div').hide();
			$('.me-dmd-merchant').show().empty();

			$append = '<div class="dropdown-menu-div-sub dmds-edition" data-nameni="+2000 v-bucks" data-idni="159">';
			$append += '<span class="dmds-data-name">+2000 v-bucks</span> = <span class="dmds-data-id"> 159 </span>';
			$append += '</div>';
			$append += '<div class="dropdown-menu-div-sub dmds-edition" data-nameni="1 pc 5 years" data-idni="129">';
			$append += '<span class="dmds-data-name">1 pc 5 years</span> = <span class="dmds-data-id"> 129 </span>';
			$append += '</div>';
			$append += '<div class="dropdown-menu-div-sub dmds-edition" data-nameni="1 pc 5 years" data-idni="129">';
			$append += '<span class="dmds-data-name">1 pc 5 years</span> = <span class="dmds-data-id"> 129 </span>';
			$append += '</div>';

			$('.me-dmd-merchant').append($append) ;

		});
		$(document).on('click input', '.me-edition-selinp',function(){
			$('.dropdown-menu-div').hide();
			$('.me-dmd-edition').show().empty();

			$append = '<div class="dropdown-menu-div-sub dmds-edition" data-nameni="+2000 v-bucks" data-idni="159">';
			$append += '<span class="dmds-data-name">+2000 v-bucks</span> = <span class="dmds-data-id"> 159 </span>';
			$append += '</div>';
			$append += '<div class="dropdown-menu-div-sub dmds-edition" data-nameni="1 pc 5 years" data-idni="129">';
			$append += '<span class="dmds-data-name">1 pc 5 years</span> = <span class="dmds-data-id"> 129 </span>';
			$append += '</div>';
			$append += '<div class="dropdown-menu-div-sub dmds-edition" data-nameni="1 pc 5 years" data-idni="129">';
			$append += '<span class="dmds-data-name">1 pc 5 years</span> = <span class="dmds-data-id"> 129 </span>';
			$append += '</div>';

			$('.me-dmd-edition').append($append);

		});

		$(document).on('click', '.me-dd-select-site',function(){
			$('.dropdown-menu-div').hide();
			$('.dmd-select-site').show();
		});

		$(document).on('click', '.dmds-select-site',function(){
			$('.dropdown-menu-div').hide();
			$('.dd-btn-text').html($(this).html())
		});
		
		
	});
	// me-merchant-selinp
</script>
<style>
	.me-select-input:focus ~ .me-si-span {
		right:  0 !important;
	}
	.dropdown-btn {
		left: 0;
		border: transparent;
		/*border-left: solid 1px transparent;*/
		width: 100%;
		border-radius: 5px;
		cursor: pointer;
		background-color: #007bff;
		color: #fff;
		font-size: 18px;
	}
	button:focus {
		outline: none !important;
	}
	.dropdown-btn:hover{
		background-color: #0069d9;
	}
</style>
<?php $this->end(); ?>

<?php $this->start('body')?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-body no-padding" style=""   > 
					<div class="card-div-overflow-style row-1-card-div-overflow-style-1" style="padding-bottom: 8px;position: relative;z-index: 2;">
						<div>
							<p style="position: relative;top: 20px;padding-left: 20px;padding-right: 20px;color: #fff;letter-spacing: 1px;">
							Merchant Edition Check
							</p>
							<p style="position: relative;top: 3px;padding-left: 20px;padding-right: 20px;color: #fff;font-size: 13px;">
								Check using Merchant and Edition
							</p>
						</div>
						<div class="dropdown" style="width: 150px;position: absolute;right: 0;top: 50%;transform: translate(-20px, -50%);">
							<div class="dropdown" style="background-color: transparent;">
								<button  name="" class="input-text-class dropdown-inputbox dropdown-btn me-dd-select-site" ><span class="dd-btn-text float-left">Select site</span><span class="float-right" style="top:2.3px;right: 10px;position:relative;"><i class="fas fa-angle-down"></i></span></button>
								
								<div class="dropdown-menu-div dmd-select-site" >
									<div class="dropdown-menu-div-sub dmds-select-site">AKS</div>
									<div class="dropdown-menu-div-sub dmds-select-site">CDD</div>
									<div class="dropdown-menu-div-sub dmds-select-site">BREX</div>
								</div>
							</div>
							<!-- <button class="btn btn-primary dropdown-toggle col-12 me-website-btn" data-toggle="dropdown" >Select Site</button>
							<div class="dropdown-menu col-12" aria-labelledby="dropdownMenuButton" style="width: 150px;min-width: unset;">
								<span class="dropdown-item">AKS</span>
								<span class="dropdown-item">CDD</span>
								<span class="dropdown-item">BREX</span>
							</div> -->
						</div>
					</div>
					<div class="me-content-div" style="">
						<div class="row" style="padding: 10px 0;">
							<div class="col-6">
								<div class="dropdown">
									<input type="text" name="" class="input-text-class dropdown-inputbox me-select-input me-merchant-selinp" autocomplete='off' style="left: 0;border-left: solid 2px #ccc;border-right: none;padding: 0 5px;" required>
									<i class="input-text-i fal fa-angle-down"></i>
									<span class="input-text-span me-si-span" style="left: 5px">Select Merchant</span>
									<span class="input-text-border"></span>

									<div class="dropdown-menu-div me-dmd-merchant">
										<!-- data from database -->
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="dropdown">
									<input type="text" name="" class="input-text-class dropdown-inputbox me-select-input me-edition-selinp" autocomplete='off' style="left: 0;border-left: solid 2px #ccc;border-right: none;padding: 0 5px;" required>
									<i class="input-text-i fal fa-angle-down"></i>
									<span class="input-text-span me-si-span" style="left: 5px">Select Edition</span>
									<span class="input-text-border"></span>

									<div class="dropdown-menu-div me-dmd-edition">
										<!-- data from database -->
									</div>
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

