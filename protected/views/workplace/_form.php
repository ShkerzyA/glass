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
		<?php echo $form->labelEx($model,'deactive'); ?>

		<?php echo $form->checkBox($model,'deactive',array('value'=>1)); ?>

		<?php echo $form->error($model,'deactive'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_cabinet'); ?>

		<?php $tmp=Cabinet::model()->with("idFloor.idBuilding")->findall(array('order'=>'"idBuilding".bname ASC, "idFloor".fnum ASC, t.num ASC'));
echo $form->dropDownList($model,"id_cabinet",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->idFloor->idBuilding->bname.'/'.$tmp->idFloor->fname.'/'.$tmp->num.' '.$tmp->cname);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_cabinet'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'wp_subdiv_rn'); ?>

		<?php $tmp=Department::model()->findall(array('order'=>'t.name asc'));
echo $form->dropDownList($model,"wp_subdiv_rn",CHtml::listData($tmp,"subdiv_rn",function($tmp) {
				return CHtml::encode($tmp->name);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'wp_subdiv_rn'); ?>
	</div>




	<div class="row">
		<?php echo $form->labelEx($model,'id_personnel'); ?>

		<?php echo Customfields::searchPersonnel($model,'id_personnel'); ?>

		<?php echo $form->error($model,'id_personnel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'wname'); ?>

		<?php echo $form->textField($model,'wname',array('size'=>50,'maxlength'=>50,'placeholder'=>'Заполнять только при невозможности привязки персонала')); ?>

		<?php echo $form->error($model,'wname'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>

		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>100,'placeholder'=>'Личный телефонный номер рабочего места')); ?>

		<?php echo $form->error($model,'phone'); ?>
	</div>
	<div class="row">
	<?php if($model->scenario!='insert'):?>
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>60,'maxlength'=>100,'placeholder'=>'1 - склад.')); ?>
		<?php echo $form->error($model,'type'); ?>
	<?php endif;?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->