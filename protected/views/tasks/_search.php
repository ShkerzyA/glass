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
		<?php echo CHtml::label('Поиск',''); ?>
		<?php echo $form->textField($model,'tname',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php $project_arr=Projects::inArrayPrj('myGroupProjects'); 

		?>
		<?php echo $form->label($model,'project'); ?>
		<?php echo $form->dropDownList($model,'project',$project_arr,array('empty'=>'')); ?>
	</div>
	<!--
	<div class="row">
		<?php echo $form->labelEx($model,'place'); ?>

		<?php $tmp=Building::withFloorsInOneList();
				echo $form->dropDownList($model,"place",$tmp,array('empty' => '')); ?>
		<?php echo $form->error($model,'place'); ?>
	</div> -->

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

	<div class="row">
		<?php $status_arr=$model->getStatus(); ?>
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',$status_arr,array('empty'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',Tasks::$types,array('empty'=>'')); ?>
	</div>

	<div class="row">
    <?php echo $form->labelEx($model,'creator'); ?>

    <?php echo $form->dropDownList($model,'creator',EquipmentLog::subjectList(),array('style' => 'height: 100px;', 'multiple' => 'multiple')); ?>

    <?php echo $form->error($model,'creator'); ?>
  </div>

    <div class="row">
    <?php echo $form->labelEx($model,'executors'); ?>

    <?php echo $form->dropDownList($model,'executors',EquipmentLog::subjectList(),array('style' => 'height: 100px;', 'multiple' => 'multiple')); ?>

    <?php echo $form->error($model,'executors'); ?>
  </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Искать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->