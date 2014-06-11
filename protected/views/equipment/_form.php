<?php
/* @var $this EquipmentController */
/* @var $model Equipment */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerPackage('customfields');
?>

<script>
	function init(){

		$(this).live('keydown',function(e){
        	if(e.keyCode==13){
            	return false;
        	}
    	});

		$('#Equipment_type').live('change',function (){ 

			$('#Equipment_producer option:first').attr('selected', 'selected');
			$('#Equipment_producer option').hide();
			$('.c'+($(this).val())).show();
			
		});
	}
	$(document).ready(init);
</script>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'equipment-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

<?php if($model->scenario!='insert'): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'id_workplace'); ?>

		<?php $tmp=Workplace::model()->findall();
				echo $form->dropDownList($model,"id_workplace",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->idCabinet->cname.' '.$tmp->idCabinet->num.'/'.$tmp->wname);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_workplace'); ?>
	</div>
<?php endif; ?>



	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>

		<?php echo $form->dropDownList($model,'type',$model->getType(),array('empty' => '')); ?>

		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'producer'); ?>

		<?php $prod=$model->getProducer();?>
		<?php echo $form->dropDownList($model,'producer',$prod['values'],array('empty' => '','options'=>$prod['css_class'])); ?>

		<?php echo $form->error($model,'producer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mark'); ?>

		<?php echo $form->textField($model,'mark',array('size'=>60,'maxlength'=>200,'class'=>'marksearch','autocomplete'=>"off")); ?>

		<?php echo $form->error($model,'mark'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'serial'); ?>

		<?php echo $form->textField($model,'serial',array('size'=>60,'maxlength'=>100,'autocomplete'=>"off")); ?>

		<?php echo $form->error($model,'serial'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inv'); ?>

		<?php echo $form->textField($model,'inv',array('size'=>60,'maxlength'=>100,'autocomplete'=>"off")); ?>

		<?php echo $form->error($model,'inv'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>

		<?php echo $form->dropDownList($model,'status',$model->getStatus()); ?>

		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'notes'); ?>

		<?php echo $form->textArea($model,'notes',array('rows'=>1, 'cols'=>1)); ?>

		<?php echo $form->error($model,'notes'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->