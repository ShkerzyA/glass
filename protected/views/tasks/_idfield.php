<div class=rw>	
<script>
$(document).ready(init());

function init(){
	$('#idfield').live('change', function go(){
		$("#idfield").submit();
	});
}

	</script>
	<?php echo CHtml::beginForm('/glass/tasks/view/','get',array('id'=>'idfield')); ?>
	<?php echo CHtml::textField('id',($date=(!empty($_GET['id']))?$_GET['id']:''),array('placeholder'=>'Номер задачи','size'=>18,'maxlength'=>18)); ?>
	<?php echo CHtml::endForm(); ?>
</div>