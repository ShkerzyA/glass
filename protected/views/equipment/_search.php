<?php
/* @var $this EquipmentController */
/* @var $model Equipment */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'place'); ?>

		<?php $tmp=Building::withFloorsInOneList();
				echo $form->dropDownList($model,"place",$tmp,array('empty' => '')); ?>
		<?php echo $form->error($model,'place'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'serial'); ?>
		<?php echo $form->textField($model,'serial',array('size'=>60,'maxlength'=>100)); ?>
	</div>
	

<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>

		<?php $tmp=EquipmentType::model()->findall();
				echo $form->dropDownList($model,"type",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->name);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'producer'); ?>

		<?php $tmp=EquipmentProducer::getAll();
			echo $form->dropDownList($model,'producer',$tmp['values'],array('empty' => '','options'=>$tmp['css_class']));
		 	echo $form->error($model,'producer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mark'); ?>

		<?php echo $form->textField($model,'mark',array('size'=>60,'maxlength'=>200,'class'=>'marksearch','autocomplete'=>"off")); ?>

		<?php echo $form->error($model,'mark'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inv'); ?>
		<?php echo $form->textField($model,'inv',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>

		<?php echo $form->dropDownList($model,'status',$model->getStatus(),array('empty' => '')); ?>

		<?php echo $form->error($model,'status'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'notes'); ?>
		<?php echo $form->textField($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
	</div> 

	<div class="row buttons">
		<?php echo CHtml::submitButton('Искать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->