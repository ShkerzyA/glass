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
    <?php echo $form->labelEx($model,'subject'); ?>

    <?php echo $form->dropDownList($model,'subject',$model->subjectList(),array('style' => 'height: 100px;', 'multiple' => 'multiple')); ?>

    <?php echo $form->error($model,'subject'); ?>
  </div>

  <?php switch ($this->route): 
   case 'equipmentLog/selectForAct': ?>
   <?php break; ?>

  <?php default: ?>
    <div class="row">
    <?php echo $form->labelEx($model,'type'); ?>

    <?php echo $form->dropDownList($model,'type',$model->filterType(),array('style' => 'height: 100px;', 'multiple' => 'multiple')); ?>

    <?php echo $form->error($model,'type'); ?>
  </div>

  <?php endswitch; ?>



	<div class="row buttons">
		<?php echo CHtml::submitButton('Искать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
<div style="clear: both"></div>