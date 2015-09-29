	<script>
$(document).ready(init());

function init(){
	$('#datefilter').live('change', function go(){
		$("#fdatefilter").submit();
	});
}

	</script>
	<?php echo CHtml::beginForm('','get',array('id'=>'fdatefilter')); ?>
	<div><?php 
  $date=(!empty($_GET['date']))?$_GET['date']:'';
	$this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'date',
   'value' => $date,
   'attribute' => 'date',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
   		'id'=> 'datefilter',
       'style' => 'height:20px;',
       'placeholder'=>'посмотреть за дату'
   ),
	));?></div>
  <?php echo CHtml::hiddenField('type',4); ?>
	<?php echo CHtml::endForm(); ?>
