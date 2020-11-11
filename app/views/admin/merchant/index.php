<?php
  use App\Models\Users;
  use Core\Session;
?>
<?php $this->start('head'); ?>

	<link rel="stylesheet" href="<?=PROOT?>plugins/codemirror/lib/codemirror.css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="<?=PROOT?>plugins/codemirror/theme/dracula.css" media="screen" title="no title" charset="utf-8">
	<script src="<?=PROOT?>plugins/codemirror/lib/codemirror.js"></script>
	<script src="<?=PROOT?>plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="<?=PROOT?>plugins/codemirror/mode/xml/xml.js"></script>
    <script src="<?=PROOT?>plugins/codemirror/mode/javascript/javascript.js"></script>
    <script src="<?=PROOT?>plugins/codemirror/mode/css/css.js"></script>
    <script src="<?=PROOT?>plugins/codemirror/mode/clike/clike.js"></script>
    <script src='<?=PROOT?>plugins/codemirror/mode/php/php.js'></script>

    <script src='<?=PROOT?>plugins/codemirror/addon/selection/active-line.js'></script>
    <script src='<?=PROOT?>plugins/codemirror/addon/edit/closetag.js'></script>

<script>
	var editorSave;
	
	$(document).ready(function(){
		showOption();
		
		$(document).on('click', '.add-code-label', function(){
			$('.txtarea-codes').slideToggle();
			$('#icon-add-code').toggleClass('fa-minus-circle')

			var defaultCode = "<"+"?php\n\n";
				defaultCode += "use Core\\Session;\n\n";
				defaultCode += "// Main code insert on this area\n\n";
				defaultCode += "Session::set('merchantData', $array);";
			$('.txt-merchant-code').val(defaultCode)

			$('.CodeMirror').remove();
			var code = $('.txt-merchant-code')[0];
				editorSave = CodeMirror.fromTextArea(code, {
					mode: 'application/x-httpd-php',
					lineNumbers: true,
					theme: "dracula",
					autoCloseTags: true,
					styleActiveLine: {nonEmpty: true},
					styleActiveSelected: true,
					undoDepth: 200,
			});
		});

		$(document).on('click', '.btn-run-merchant', function(){
			$.ajax({
				type: "POST",
				url : '<?=PROOT?>merchant/index',
				data : {
					action: 'runMerchantAction',
					codes: $('.txt-run-code').val()
				},
				success : function(data){
					console.log(data)
				}
			});
		});

		$(document).on('click', '.btn-add-merchant', function(){
			if($('.txt-merchant-name').val() == '' || $('.txt-merchant-id').val() == '') {
				alert('Error, Please fill up the following.');
			}else{
				var editorSaveData = (editorSave.getValue().replace(/\\/g, '\\\\')).replace(/'/g, '"');
				saveMerchant(editorSaveData)
			}
		});

		$(document).on('click', '.opt-div', function(){
			$('.selected-data').text($(this).data('mname'));
			$('#run-merchant-modal').modal('show')
			$('.title-run').text($(this).data('mname') + " " + "(" + $(this).attr('id') + ")");
			
			showCodes($(this).data('id'));

			$('#run-merchant-modal').on('shown.bs.modal', function (e) {
				$('.CodeMirror').remove();
				var code = $('.txt-run-code')[0];
				var	editorRun = CodeMirror.fromTextArea(code, {
					mode: 'application/x-httpd-php',
					lineNumbers: true,
					theme: "dracula",
					autoCloseTags: true,
					styleActiveLine: {nonEmpty: true},
					styleActiveSelected: true,
					undoDepth: 200,
				});
			});
		});

		$('.dropdown-div').click(function () {
			$(this).find('.dropdown-menu').slideToggle(200);
		});
		$('.dropdown-div').focusout(function () {
			$(this).find('.dropdown-menu').slideUp(200);
		});

	}); // end document ready ====================================================

	function saveMerchant($editorSaveData){
		$.ajax({
			type: "POST",
			url : '<?=PROOT?>merchant/index',
			data : {
				action: 'addMerchantAction',
				merchantName: $('.txt-merchant-name').val(),
				merchantID: $('.txt-merchant-id').val(),
				codes: $editorSaveData,
			},
			success : function(data){
				if($.trim(data) == "101"){
					alert("ERROR: Merchant name OR Merchant ID, already exist");
				}else{
					showOption();
					$('#add-merchant-modal').modal('toggle')
					$('.txt-merchant-name, .txt-merchant-id, .txt-merchant-code').val('');
					$('.txtarea-codes').slideToggle();
				}
			}
		});
	}
	function showOption(){
		$.ajax({
			type: "POST",
			url : '<?=PROOT?>merchant/index',
			data : {
				action: 'displayMerchantAction',
			},
			success : function(data){
				$('.opt-div').remove();
				for (var i in data) {
					var displayOption = "<li class='opt-div' id="+data[i].merchantID+" data-mname="+data[i].merchantName+" data-id="+data[i].id+">"+data[i].merchantName+"</li>";
						$('.select-opt').append(displayOption); 
				}
					
			}
		});
	}

	function showCodes($id){
		$('.txt-run-code').val('');
		$.ajax({
			type: "POST",
			url : '<?=PROOT?>merchant/index',
			data : {
				action: 'displayMerchantCodesAction',
				id: $id
			},
			success : function(data){
				$('.txt-run-code').val(data);
			}
		});
	}


</script>
<style>
.CodeMirror {
	height: 500px;
}

.CodeMirror-vscrollbar {
	bottom:0 !important;
}
.CodeMirror-vscrollbar::-webkit-scrollbar {
  width: 8px !important;
}
.CodeMirror-vscrollbar::-webkit-scrollbar-thumb {
  background: #e7e7e7 !important;
}
.CodeMirror-vscrollbar::-webkit-scrollbar-track {
  background: #3f51b5 !important;
}

.CodeMirror-hscrollbar {
	right: 0 !important;
}
.CodeMirror-hscrollbar::-webkit-scrollbar {
  height: 8px !important;
}
.CodeMirror-hscrollbar::-webkit-scrollbar-thumb {
  background: #e7e7e7 !important;
}
.CodeMirror-hscrollbar::-webkit-scrollbar-track {
  background: #3f51b5 !important;
}
.CodeMirror-scrollbar-filler {
	display: none !important;
}



/*modal here ----------------------------------------------------------------*/

.modal-dia-div {
	height: auto !important;
}
.modal-content-div {
	background: rgba(0,191,255, .7) !important;
	border-radius: 0 !important;
	padding-bottom: 10px !important;
}
.modal-content-wrapper {
	margin: 10px 0 0 10px !important;
	width: 96.5% !important;
	height: 96.5% !important;
	background-color: rgba(65,105,225, .7) !important;
	color: #ffffff ;
}
.close-div-mdl {
	color: #ffffff !important;
}
.modal-header-div {
	border: none !important;
	background-color: rgba(11, 36, 40, .8);
}
.modal-title-div {
	margin: 20px 0 0 0 !important;
}
.div-sub-title {
	margin: 3px 0 0 0 !important;
	line-height: 2 !important;
}
.modal-txtbox:valid ~ .label-txt{
	font-size:15px;
	font-weight: 500;
	letter-spacing: 2px;
	text-transform: uppercase;
	color: #fff !important;
	-webkit-transform: translate(-52px, -30px);
	-moz-transform: translate(-52px, -30px);
	-o-transform: translate(-52px, -30px);
	-ms-transform: translate(-52px, -30px);
	transform: translate(-52px, -30px);
}
.div-ig-forgot {
	margin: 15px 0 0 0;
	background: #fff;
}
.div-ig-forgot span {
	border-radius: 0;
}
.div-ig-forgot span i {
	color: #3f51b5;
	border: none;
}
.div-ig-forgot input {
	border: none;
	background: transparent;
	-webkit-transition: .6s ease-in-out;
	-moz-transition: .6s ease-in-out;
	-o-transition: .6s ease-in-out;
	transition: .6s ease-in-out
}
.div-ig-forgot, .input-group-addon{
	border: none !important;
}
.label-txt {
	top: 9px;
	left: 53px;
	color: #C7C7CD; 
	font-weight: normal;
	-webkit-transition: .3s ease-in-out;
	-moz-transition: .3s ease-in-out;
	-o-transition: .3s ease-in-out;
	transition: .3s ease-in-out;     
	position: absolute;               
}
/*normal css codes here ----------------------------------------------------------*/
.add-height-merchant {
	height: 500px;
}
.add-code-label {
	margin-top: 20px;
	cursor: pointer;
	font-weight: 500;
}
.add-code-label span {
	top: -1px;
	position: relative;
	font-size: 10px;
	letter-spacing: 2px;
}
.txtarea-codes {
	display: none;
	height: 500px;
	padding-bottom: 10px;
	/*position: absolute;*/
}
.txtarea-run-codes {
	height: 500px;
	padding-bottom: 10px;
}
.txtarea-codes textarea,
.txtarea-run-codes textarea{
	margin-top: 10px;
	width: 100%;
	height: 100%;
	resize: none;
	color: #6b6d70;
}
.txtarea-codes textarea:focus{
	outline: none !important;
}

/*Styling Selectbox here ----------------------------------------------------------*/
.dropdown-div {
  width: 100%;
  display: inline-block;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 0 2px rgb(204, 204, 204);
  transition: all .5s ease;
  position: relative;
  font-size: 14px;
  color: #474747;
  height: 100%;
  text-align: left
}
*{
	outline: 0;
}
.dropdown-div .select {
    cursor: pointer;
    display: block;
    padding: 10px;
    background-color: #3f51b5;
    color: #fff;
}
.dropdown-div .select > i {
    font-size: 13px;
    color: #fff;
    cursor: pointer;
    transition: all .3s ease-in-out;
    float: right;
    line-height: 20px
}

.dropdown-div:hover {
    box-shadow: 0 0 4px rgb(204, 204, 204)
}
.dropdown-div:active {
    background-color: #f8f8f8
}
.dropdown-div .dropdown-menu {
    position: absolute;
    background-color: #fff;
    width: 100%;
    left: 0;
    margin-top: 1px;
    box-shadow: 0 1px 2px rgb(204, 204, 204);
    border-radius: 0 1px 2px 2px;
    overflow: hidden;
    display: none;
    overflow-y: auto;
    z-index: 9
}
.dropdown-div .dropdown-menu li {
    padding: 10px;
    transition: all .2s ease-in-out;
    cursor: pointer
} 
.dropdown-div .dropdown-menu {
    padding: 0;
    list-style: none
}
.dropdown-div .dropdown-menu li:hover {
    background-color: #f2f2f2
}
.dropdown-div .dropdown-menu li:active {
    background-color: #e2e2e2
}

</style>
<?php $this->end(); ?>
<?php $this->start('body')?>

<div class="merchant-content" style="padding: 25px 15px;">
	<div class="col-sm-12" style="padding: 0 30px;">
		<div class="row merchant-header" style="background-color: #fff;">
			<div class="col-sm-12 no-padding">
				<div class="col-sm-6" style="padding: 15px 15px;">
					<div class="dropdown-div">
						<div class="select">
							<span class="selected-data">Select Merchant</span>
							<i class="fa fa-chevron-down"></i>
						</div>
						<ul class="dropdown-menu select-opt">

						</ul>
					</div>
				</div>
				<div class="col-sm-6" style="padding: 15px 15px;"> 
					<input type="button" name="" class="btn btn-success" style="width: 100%;height: 3em;border-radius: 0;" value="ADD MERCHANT" data-toggle="modal" data-target="#add-merchant-modal">
				</div>
			</div>
		</div>
	</div>	
</div>


<?php $this->end()?>
