<?php $this->start('head'); ?>
	<script>
		$(document).ready(function(){
			testAjax()
			testDisplay()
		});
		function testAjax(){
			$.ajax({
				url : '<?=PROOT?>checker/index',
				type: "POST",
				data : {
					action: 'testLoopAction',
				},
				datatype:'json',
				success : function(data){

				},
				complete: function(){
					 window.setTimeout( testAjax(), 1000);
					
				}
			});
		}
		function testDisplay(){

			$.ajax({
				url : '<?=PROOT?>checker/index',
				type: "POST",
				data : {
					action: 'testLoopDisplayAction',
				},
				datatype:'json',
				success : function(data){
					$(".testul-display").empty();
					for (var i in data){
					var appendDate = "<tr>";
						appendDate += "<td>"+data[i].gameName+"</td>";
						appendDate += "<td style='width:100px;'>"+data[i].price+"</td>";
						appendDate += "<td>"+data[i].stock+"</td>";
						appendDate += "<td>"+data[i].link+"</td>";
						appendDate += "<td>"+data[i].date+"</td>";
						appendDate += "<td style='width:100px;'>"+data[i].action+"</td>";
						appendDate += "</tr>";
						$(".testul-display").append(appendDate);
					}
				},
				complete: function(){
					 window.setTimeout( testDisplay(), 1000);
					
				}
			});
		}
	</script>
	<style>
		
	</style>

<?php $this->end(); ?>
<?php $this->start('body')?>

<div class="testcheck-content" style="padding: 25px 15px;">
	<div class="col-xs-12">
		<!-- <ul class="col-xs-12 no-padding list-inline testul-display" style="border:solid 1px red;word-break: break-all;"> -->
			<!-- <li class="col-xs-2">aas</li>
			<li class="col-xs-2">aas</li>
			<li class="col-xs-2">aas</li>
			<li class="col-xs-2">aas</li>
			<li class="col-xs-2">aas</li>
			<li class="col-xs-2">aas</li> -->
		<!-- </ul> -->
		<table class="table">
			<tbody class="testul-display" style="word-break: break-all;">
			
			</tbody>
		</table>
	</div>
</div>
	
<?php $this->end()?>
