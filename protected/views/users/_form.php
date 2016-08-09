<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

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
		<?php echo $form->labelEx($model,'startpage'); ?>

		<?php echo $form->textField($model,'startpage',array('size'=>250,'maxlength'=>250)); ?>

		<?php echo $form->error($model,'startpage'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bg'); ?>

		<?php echo $form->textField($model,'bg',array('size'=>250,'maxlength'=>250)); ?>

		<?php echo $form->error($model,'bg'); ?>
	</div>

	 <div class="row">
        <?php echo $form->labelEx($model,'horn'); ?>


        <?php echo $form->dropDownList($model,'horn',Users::SoundList(),
              array('empty' => '')); ?>
        <?php echo $form->error($model,'horn'); ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'id_post'); ?>

		<?php $tmp=UsersPosts::model()->findall();
echo $form->dropDownList($model,"id_post",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->post);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_post'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>

		<?php echo $form->textField($model,'email',array('size'=>100,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
        <?php echo $form->labelEx($model,'tasks_send_mail'); ?>

        <?php echo $form->checkBox($model,'tasks_send_mail',array('value'=>1,'size'=>2,'maxlength'=>2)); ?>

        <?php echo $form->error($model,'tasks_send_mail'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->