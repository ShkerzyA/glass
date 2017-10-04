<?php
/* @var $this TasksController */
/* @var $model Tasks */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>


	<div class="row">
    <?php echo CHtml::label('ДАТА',''); ?>
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'timestamp',
   'model' => $model,
   'attribute' => 'timestamp',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
       'dateFormat'=>'yy-mm-dd',

   	),
  	'htmlOptions' => array(
  		'placeholder'=> 'ОТ',
       	'style' => 'height:20px; width: 30%;'
   	),
	));?>
   	<?php echo CHtml::label('ДО',''); ?>
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'timestamp_end',
   'model' => $model,
   'attribute' => 'timestamp_end',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
       'dateFormat'=>'yy-mm-dd',
   ),
   'htmlOptions' => array(
   		'placeholder'=> 'ДО',
       	'style' => 'height:20px; width: 30%;'
   ),
	));?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Искать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->