<?php $this->start('head'); ?>
	<script>
		$(document).ready(function(){
			//testAjax()
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
					console.log(data)
				},
				complete: function(){
					// testAjax()
				}
			});
		}

	</script>
	<style>
		
	</style>

<?php $this->end(); ?>
<?php $this->start('body')?>


	
<?php $this->end()?>
