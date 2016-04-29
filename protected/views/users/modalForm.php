<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>

		<?php echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50)); ?>

		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>

		<?php echo $form->passwordField($model,'password',array('size'=>50,'maxlength'=>50)); ?>

		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model->personnels,'photo'); ?>

		<?php echo $form->fileField($model->personnels,'photo',array('size'=>50,'maxlength'=>50)); ?>

		<?php echo $form->error($model->personnels,'photo'); ?>
	</div>

<?php if(Yii::app()->user->checkAccess('inGroup',array('group'=>array('it')))): ?>
	<div class="row">
        <?php echo $form->labelEx($model,'horn'); ?>


        <?php echo $form->dropDownList($model,'horn',Users::SoundList(),
              array('empty' => '')); ?>
        <?php echo $form->error($model,'horn'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'bg'); ?><br>
        <?php echo $form->radioButtonList($model,'bg',Users::BgList(),array('separator'=>''));?>
        <?php echo $form->error($model,'bg'); ?>
    </div>

	<div class="row">
        <?php echo $form->labelEx($model,'chatsound'); ?>

        <?php echo $form->checkBox($model,'chatsound',array('value'=>1,'size'=>2,'maxlength'=>2)); ?>

        <?php echo $form->error($model,'chatsound'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'tasksound'); ?>

        <?php echo $form->checkBox($model,'tasksound',array('value'=>1,'size'=>2,'maxlength'=>2)); ?>

        <?php echo $form->error($model,'tasksound'); ?>
    </div>
<?php endif; ?>
	<!--
	Фото
	<?php echo CHtml::fileField('photo', '', $htmlOptions=array ( )); ?>
 	-->
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->