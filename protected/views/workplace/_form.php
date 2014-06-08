<?php
/* @var $this WorkplaceController */
/* @var $model Workplace */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'workplace-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'id_cabinet'); ?>

		<?php $tmp=Cabinet::model()->findall();
echo $form->dropDownList($model,"id_cabinet",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->idFloor->idBuilding->bname.'/'.$tmp->idFloor->fname.'/'.$tmp->cname.' №'.$tmp->num);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_cabinet'); ?>
	</div>



	<div class="row">
		<?php echo $form->labelEx($model,'id_personnel'); ?>

		<?php echo Customfields::searchPersonnel($model,'id_personnel'); ?>

		<?php echo $form->error($model,'id_personnel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'wname'); ?>

		<?php echo $form->textField($model,'wname',array('size'=>50,'maxlength'=>50)); ?>

		<?php echo $form->error($model,'wname'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->