	<script>
$(document).ready(init());

function init(){
	$('#id_pers').live('change', function go(){
		$("#fsubscribe").submit();
	});
}

	</script>
	<?php echo CHtml::beginForm('join','get',array('id'=>'fsubscribe')); ?>
  <?php 
        $tmp=$model->potentialExecutors();
        echo CHtml::dropDownList('id_pers', '', 
              $tmp,array('empty' => 'Подписать','style' =>'width: 99%;')); ?>
  <?php echo CHtml::hiddenField('id', $model->id); ?>
	<?php echo CHtml::endForm(); ?>
