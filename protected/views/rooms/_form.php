<?php
/* @var $this RoomsController */
/* @var $model Rooms */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'rooms-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'id_cabinet'); ?>

		<?php $tmp=Cabinet::model()->with('idFloor.idBuilding')->findall(array('order'=>'"idBuilding".bname ASC, "idFloor".fname ASC, t.num ASC'));
echo $form->dropDownList($model,"id_cabinet",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->idFloor->idBuilding->bname.'/'.$tmp->idFloor->fname.'/'.$tmp->num.' '.$tmp->cname);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_cabinet'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'managers'); ?>

		<?php echo Customfields::multiPersonnel($model,'managers'); ?>

		<?php echo $form->error($model,'managers'); ?>
	</div> 
	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>

	<?php echo $form->dropDownList($model,'type',$model->getType(),
              array('empty' => '')); ?>
    	<?php echo $form->error($model,'type'); ?>
	</div> 

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->