<?php $this->start('head'); ?>
	<link rel="stylesheet" href="<?=PROOT?>vendors/css/store-page.css" media="screen" title="no title" charset="utf-8">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>
	<script type="text/javascript" src="<?=PROOT?>vendors/js/store-page.js"></script>
<?php $this->end(); ?>

<?php $this->start('body')?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 mtop-35px">
			<div class="card card-style">
				<div class="card-body no-padding store-card-main-wrap"> 
					<div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-1 store-card-div-page-title">
						<p class="store-list-title">Store list</p>
						<p class="store-list-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
					</div>

					<!-- breadcrumbs and search -->
					<div class="card-header breadcrumbs-div">
						<div class="row">
							<div class="col-sm-12 no-padding">
								<ul class="breadcrumbs-ul">
									<li class="site-bcrumbs"><span class="site-bcrumbs-span">AKS</span></li>
									<li class="store-bcrumbs"><i class="fas fa-arrow-right breadcrumbs-arrow"></i> Store</li>
									<li class="show-dropdown-li">
										<button type="button" class="btn dropdown-toggle sticky-dropdown"></button>
										<div class="dropdown-menu col-12 dropdown-menu-div sticky-dropdown-menu-div">
											<a class="dropdown-item dropdown-items-store-page-search" >AKS</a>
											<a class="dropdown-item dropdown-items-store-page-search" >CDD</a>
											<a class="dropdown-item dropdown-items-store-page-search" >BREX</a>
										</div>
									</li>
								</ul>
								
							</div>

							<div class="col-lg-9 no-padding">
								<div class="input-group">
									<input type="text" class="form-control store-page-search" placeholder="Dig more in Store page!">
									<div class="input-group-append">
										<button class="btn bg-transparent store-search-btn" type="button" >
											<i class="fas fa-search-plus"></i>
										</button>
									</div>
								</div>
							</div>

							<div class="col-lg-3 store-select-site-div">
								<div class="dropdown">
									<button type="button" class="btn dropdown-toggle col-12 dropdown-menu-btn" data-toggle="dropdown">AKS</button>
									<div class="dropdown-menu col-12 dropdown-menu-div">
										<a class="dropdown-item dropdown-items-store-page-search" >AKS</a>
										<a class="dropdown-item dropdown-items-store-page-search" >CDD</a>
										<a class="dropdown-item dropdown-items-store-page-search" >BREX</a>
									</div>
								</div>
								<!-- <input type="button" class="btn btn-primary col-12" value="SITE"> -->
							</div>
							
						</div>
					</div>

					<div class="card-body no-padding">
						<div class="row store-data-div"></div>
						<div class="row store-games-data-div" style="display: none;padding-left: 15px;padding-right: 15px;">
							<div class="col-sm-12 no-padding store-games-data-div-sub">
								<table class="store-games-data-div-table">
									<thead>
										<tr class="store-games-data-table-thead-data">
											<td class="child-1">Link</td>
											<td class="child-2">Price</td>
											<td class="child-3">Status</td>
										</tr>
									</thead>
									<tbody class="store-games-data-table-tbody">
										
									</tbody>
									<tfoot class="store-games-data-table-tfoot">
										<tr>
											<td colspan="3" style="padding-top: 20px;">
												<p style="text-align: center;">
													<span class="data-display-function lmore-fucntion"> 
														<i class="fas fa-spinner"></i> Load More 
													</span> 
													<span class="data-display-function dall-function"> 
														<i class="fas fa-globe"></i> Display All
													</span>
												</p>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->end()?>
