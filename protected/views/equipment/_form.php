<?php
/* @var $this EquipmentController */
/* @var $model Equipment */
/* @var $form CActiveForm */
?>
<script>
	function init(){
		$('#Equipment_type').live('change',function(){ 

			
			$('#Equipment_producer option:first').attr('selected', 'selected');
			$('.c0, .c1, .c2, .c3, .c4, .c5').hide();
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

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'id_workplace'); ?>

		<?php $tmp=Workplace::model()->findall();
echo $form->dropDownList($model,"id_workplace",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->idCabinet->cname.' '.$tmp->idCabinet->num.'/'.$tmp->wname);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_workplace'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'serial'); ?>

		<?php echo $form->textField($model,'serial',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'serial'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>

		<?php echo $form->dropDownList($model,'type',$model->getType()); ?>

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

		<?php echo $form->textField($model,'mark',array('size'=>60,'maxlength'=>200)); ?>

		<?php echo $form->error($model,'mark'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inv'); ?>

		<?php echo $form->textField($model,'inv',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'inv'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>

		<?php echo $form->dropDownList($model,'status',$model->getStatus()); ?>

		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'notes'); ?>

		<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>

		<?php echo $form->error($model,'notes'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->