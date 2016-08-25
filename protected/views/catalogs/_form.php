<?php
/* @var $this CatalogsController */
/* @var $model Catalogs */
/* @var $form CActiveForm */


?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalogs-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

<?php if(Yii::app()->user->role=='moderator'):?>
	<div class="row">
		<?php echo $form->labelEx($model,'id_parent'); ?>

		<?php $tmp=Catalogs::model()->findall();
echo $form->dropDownList($model,"id_parent",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->cat_name);}),array('empty' => '','disabled'=>!$do=(Yii::app()->user->CheckAccess('administrator')))); ?>
		<?php echo $form->error($model,'id_parent'); ?>
	</div>
<?php else: ?>
	<?php echo $form->hiddenField($model,'id_parent',array('size'=>60,'maxlength'=>100)); ?>
<?php endif; ?>




<?php if(Yii::app()->user->role=='administrator'):?>
	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>

		<?php echo $form->dropDownList($model,'type',$model->getType(),
              array('empty' => '')); ?>

		<?php echo $form->error($model,'type'); ?>
	</div>
<?php endif; ?>



	<div class="row">
		<?php echo $form->labelEx($model,'cat_name'); ?>

		<?php echo $form->textField($model,'cat_name',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'cat_name'); ?>
	</div>


<?php if($model->scenario!='insert'):?>
	<div class="row">
		<?php echo $form->labelEx($model,'owner'); ?>
		<?php echo Customfields::searchPersonnel($model,'owner'); ?>
		<?php echo $form->error($model,'owner'); ?>
	</div>

<?php endif; ?>

	<div class="row">
		<?php echo $form->labelEx($model,'groups'); ?>
		<?php echo Customfields::multigroup($model); ?>
		<?php echo $form->error($model,'groups'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'persons'); ?>
		<?php echo Customfields::multiPersonnel($model,'persons'); ?>
		<?php echo $form->error($model,'persons'); ?>
	</div>

	<br>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->