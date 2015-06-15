<?php
/* @var $this EquipmentLogController */
/* @var $model EquipmentLog */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'timestamp',
   'model' => $model,
   'attribute' => 'timestamp',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   	),
  	'htmlOptions' => array(
  		'placeholder'=> 'ОТ',
       	'style' => 'height:20px; width: 40%;'
   	),
	));?>

	<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'timestamp_end',
   'model' => $model,
   'attribute' => 'timestamp_end',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
   		'placeholder'=> 'ДО',
       	'style' => 'height:20px; width: 40%;'
   ),
	));?>
	</div>




	<div class="row buttons">
		<?php echo CHtml::submitButton('Искать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->