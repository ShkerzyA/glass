	<script>
$(document).ready(init());

function init(){
	$('#id_doc').live('change', function go(){
		$("#adddoc").submit();
	});
}

	</script>
	<?php echo CHtml::beginForm('addDoc','get',array('id'=>'adddoc')); ?>
  <?php 
        $tmp=Catalogs::allAccessCat();
        echo CHtml::dropDownList('id_doc', '', 
              $tmp,array('empty' => 'Прикрепить док','style' =>'width: 99%;')); ?>
  <?php echo CHtml::hiddenField('id', $model->id); ?>
	<?php echo CHtml::endForm(); ?>
