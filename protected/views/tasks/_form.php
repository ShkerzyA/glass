<?php
/* @var $this TasksController */
/* @var $model Tasks */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tasks-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'tname'); ?>

		<?php echo $form->textField($model,'tname',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'tname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ttext'); ?>

		<?php echo $form->textArea($model,'ttext',array('rows'=>6, 'cols'=>50)); ?>

		<?php echo $form->error($model,'ttext'); ?>
	</div>
<?php if((Yii::app()->user->role=='administrator') and ($model->scenario!='insert')): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'date_begin'); ?>

		<?php echo $form->textField($model,'date_begin'); ?>

		<?php echo $form->error($model,'date_begin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_end'); ?>

		<?php echo $form->textField($model,'date_end'); ?>

		<?php echo $form->error($model,'date_end'); ?>
	</div>
<!--
	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>

		<?php echo $form->textField($model,'type'); ?>

		<?php echo $form->error($model,'type'); ?>
	</div> -->

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>

		<?php //echo $form->textField($model,'status'); ?>


		<?php echo $form->dropDownList($model,'status',$model->getStatus(),
              array('empty' => '')); ?>

		<?php echo $form->error($model,'status'); ?>
	</div>

<?php endif; ?>

<?php if($model->scenario!='insert'):?>
	<div class="row">
		<?php echo $form->labelEx($model,'id_department'); ?>

		<?php $tmp=Department::model()->working()->findall();
		echo $form->dropDownList($model,"id_department",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->name);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_department'); ?>
	</div>
<?php endif; ?>

<?php if($model->scenario!='insert'):?>
	<div class="row">
		<?php echo $form->labelEx($model,'creator'); ?>

		<?php $tmp=DepartmentPosts::model()->working()->findall();
echo $form->dropDownList($model,"creator",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->personnelPostsHistories[0]->idPersonnel->surname.' '.$tmp->personnelPostsHistories[0]->idPersonnel->name);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'creator'); ?>
	</div>
<?php endif; ?>
	<div class="row">
		<?php echo $form->labelEx($model,'executor'); ?>

		<?php
		$tmp=DepartmentPosts::model()->working()->with("postSubdivRn")->findall(array('condition'=>'"postSubdivRn".id='.$model->id_department));
echo $form->dropDownList($model,"executor",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->personnelPostsHistories[0]->idPersonnel->surname.' '.$tmp->personnelPostsHistories[0]->idPersonnel->name);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'executor'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->