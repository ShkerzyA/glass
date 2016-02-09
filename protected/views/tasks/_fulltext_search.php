<div class=rw>	
<script>
$(document).ready(init());

function init(){
	$('#fulltextsearch').live('change', function go(){
		$("#fulltextsearch").submit();
	});
}

	</script>
	<?php echo CHtml::beginForm('','get',array('id'=>'fdatefilter')); ?>
	<?php echo CHtml::textField('search',($date=(!empty($_GET['search']))?$_GET['search']:''),array('placeholder'=>'Поиск по задачам','size'=>60,'maxlength'=>60)); ?>
  <?php echo CHtml::hiddenField('type',5); ?>
	<?php echo CHtml::endForm(); ?>
</div>