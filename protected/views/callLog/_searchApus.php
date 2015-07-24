<?php
/* @var $this CallLogController */
/* @var $model CallLog */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
    <?php echo $form->labelEx($model,'timestamp'); ?>
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
  <?php echo $form->labelEx($model,'timestamp_end'); ?>
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
	<div class="row">
		<?php echo $form->label($model,'tarif'); ?>
		<?php echo $form->textField($model,'tarif',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'calling_number'); ?>
		<?php echo $form->textField($model,'calling_number',array('size'=>14,'maxlength'=>14)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Искать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
<div style="clear: both"></div>