<?php
/* @var $this PersonnelController */
/* @var $model Personnel */
/* @var $form CActiveForm */
//Yii::app()->clientScript->registerScriptFile(CHtml::asset(Yii::getPathOfAlias('ext.assets').'/modalAjax.js'),CClientScript::POS_END);

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	'id'=>'personnel-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поле с <span class="required">*</span> обязательно для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'surname'); ?>
		<?php echo $form->textField($model,'surname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'surname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'patr'); ?>
		<?php echo $form->textField($model,'patr',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'patr'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'orbase_rn'); ?>
		<?php echo $form->textField($model,'orbase_rn',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'orbase_rn'); ?>
	</div>
	

	<div class="row">
		<?php echo $form->labelEx($model,'photo'); ?>
		<?php echo $form->fileField($model,'photo',array('size'=>50,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'photo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_user'); ?>

				<?php $tmp=Users::model()->findall();
echo $form->dropDownList($model,"id_user",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->username.'/'.($pers=(!empty($tmp->personnels))?$tmp->personnels->fio_full():''));}),array('empty' => '')); ?>


		<?php // echo $form->dropDownList($model,'id_user',CHtml::listData(Users::model()->findall(),'id','username'),array('empty' => '(Привязать пользователя)')); ?>
		<?php echo $form->error($model,'id_user'); ?>
	</div>

		<div class="row">
		<?php echo $form->labelEx($model,'birthday'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'birthday',
   'model' => $model,
   'attribute' => 'birthday',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
       'style' => 'height:20px;'
   ),
));?>
		<?php echo $form->error($model,'birthday'); ?>
	</div>

		<div class="row">
		<?php echo $form->labelEx($model,'date_begin'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'date_begin',
   'model' => $model,
   'attribute' => 'date_begin',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
       'style' => 'height:20px;'
   ),
));?>
		<?php echo $form->error($model,'date_begin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_end'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'date_end',
   'model' => $model,
   'attribute' => 'date_end',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
       'style' => 'height:20px;'
   ),
));?>
		<?php echo $form->error($model,'date_end'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>




</div><!-- form -->