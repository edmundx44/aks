<?php $this->setSiteTitle('Login'); ?>
<?php $this->start('head'); ?>

<link rel="stylesheet" href="<?=PROOT?>vendors/css/login.css" media="screen" title="no title" charset="utf-8">
<script src="<?=PROOT?>vendors/js/modernizer.js"></script>

<?php $this->end(); ?>
<?php $this->start('body'); ?>
	<ul class="background-slider">
		<li><span>Image 01</span><div><h3></h3></div></li>
		<li><span>Image 02</span><div><h3></h3></div></li>
		<li><span>Image 03</span><div><h3></h3></div></li>
		<li><span>Image 04</span><div><h3></h3></div></li>
		<li><span>Image 05</span><div><h3></h3></div></li>
		<li><span>Image 06</span><div><h3></h3></div></li>
	</ul>

	<div class="login-content-wrapper">
		<div class="row">

			<div class="col-md-4 offset-md-4 ">
				<div class="aks-logo">
					<img src="<?=PROOT?>vendors/image/aks-logo.png" class="img-responsive d-block mx-auto"/>
					<div class="img-out">
						<div class="img-out-before" ></div>
					</div>

					<h4 class="text-center p-title-1">ALLKEYSHOP</h4>
					<p class="text-center p-title-2">AKS LOGIN PANEL</p>

					<div class="text-center">
						<i class="fal fa-angle-double-down icon-1"></i>
					</div>

					<div class="div-form">
						<form class="form" action="<?=PROOT?>user/login" method="post">
							<div class="input-group">
								<span class="input-group-addon class-add-on-icon text-center"><i class="fas fa-user-circle"></i></span>
								<input type="text" id="username" name="username" class="form-control class-input" placeholder="Email">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon class-add-on-icon text-center"><i class="fas fa-unlock-alt"></i></span>
								<input type="password" id="password" name="password" class="form-control class-input" placeholder="Password">
							</div>
							<br>
							<div class="input-group btn-login-div">
								<input type="submit" name="" value="Sign In" class="btn btn-primary btn-login">
							</div>
							<div class="p-action">
								<label class="float-left label-1"><input type="checkbox" id="remember_me" name="remember_me" value="on"> Remember Me</label>
								<label class="float-right label-2" data-toggle="modal" data-target="#forgot-pass-modal">Forgot Password</label>
							</div>
						</form>
					</div>

					<!--  <div class="row div-or" >
						<div class="col-xs-5"><hr></div>
						<div class="col-xs-2 text-center or-txt">OR</div>
						<div class="col-xs-5"><hr></div>
					</div>

					<div class="text-center div-icon">
						<i class="fa fa-facebook-official i-1"></i> &nbsp; 
						<i class="fa fa-google-plus-square i-2></i> &nbsp; 
 						<i class="fa fa-instagram i-3"></i>
					</div> -->
				</div>
			</div>
		</div>
	</div>

	<!-- forgot password Modal -->
	<div id="forgot-pass-modal" class="modal fade forgot-pass-mdl" role="dialog">
		<div class="modal-dialog modal-dia-div">
			<div class="modal-content modal-content-div">
				<div class="modal-content-wrapper">
					<div class="modal-header modal-header-div">
						<button type="button" class="close close-div-mdl" data-dismiss="modal">&times;</button>
						<h4 class="modal-title modal-title-div">Forgot password!</h4>
						<p class="div-sub-title">This is auto generated system, kindly change your password after.</p>
					</div>
					<div class="modal-body">
					<div class="input-group div-ig-forgot">
						<span class="input-group-addon"><i class="glyphicon glyphicon-random"></i></span>
						<input type="text" name="" class="form-control forgot-txtbox" required>
						<span class="forgot-txtbox-border"></span>  
						<label class="label-txt">Email address</label>
					</div>
					</div>
					<div class="alert alert-warning text-center div-alert-reset"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-default">Reset password</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $this->end(); ?>
