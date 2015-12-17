<?php
/* @var $this EventsoperController */
/* @var $model Eventsoper */
/* @var $form CActiveForm */
Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
Yii::app()->getClientScript()->registerCssFile(Yii::app()
    ->getClientScript()
    ->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css' );

//print_r($_POST);
?>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicle-shedule-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


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


		<table style="width: 97%;"> 
		<tr>
			<td>
	<div class="row">
		<?php echo $form->labelEx($model,'timestamp'); ?>

		<?php echo $form->textField($model,'timestamp',array('readonly'=>true)); ?>

		<?php echo $form->error($model,'timestamp'); ?>
	</div>
			</td>
			<td>
	<div class="row">
		<?php echo $form->labelEx($model,'timestamp_end'); ?>

		<?php echo $form->textField($model,'timestamp_end',array('readonly'=>true)); ?>

		<?php echo $form->error($model,'timestamp_end'); ?>
	</div>

			</td>
		</tr>
	</table>

	
	<?php 
	$evItervals=array(); 
	$this->renderPartial('_indicator_slider',array('model'=>$model),false,false); ?>
	<div id="slider" style="width: 93%;"></div>

<?php if((Yii::app()->user->role=='administrator') and ($model->scenario!='insert')): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'creator'); ?>

		<?php $tmp=Personnel::model()->findall();
echo $form->dropDownList($model,"creator",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->fio_full());}),array('empty' => '')); ?>
		<?php echo $form->error($model,'creator'); ?>
	</div>
<?php endif; ?>
	<div class="row">
		<?php echo $form->labelEx($model,'week'); ?>
		<table>
		<tr>
			<td>Пн</td><td>Вт</td><td>Ср</td><td>Чт</td><td>Пт</td><td>Сб</td><td>Вс</td>
		</tr>
		<tr>
			
		<td><?php echo $form->checkBox($model,'week[0]'); ?></td>
		<td><?php echo $form->checkBox($model,'week[1]'); ?></td>
		<td><?php echo $form->checkBox($model,'week[2]'); ?></td>
		<td><?php echo $form->checkBox($model,'week[3]'); ?></td>
		<td><?php echo $form->checkBox($model,'week[4]'); ?></td>
		<td><?php echo $form->checkBox($model,'week[5]'); ?></td>
		<td><?php echo $form->checkBox($model,'week[6]'); ?></td>
		</tr></table>

		<?php echo $form->error($model,'week'); ?>
	</div>

	<!--
	<div class="row">
		<?php echo $form->labelEx($model,'weekdays'); ?>

		<?php echo $form->checkBox($model,'weekdays'); ?>

		<?php echo $form->error($model,'weekdays'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'holydays'); ?>

		<?php echo $form->checkBox($model,'holydays'); ?>

		<?php echo $form->error($model,'holydays'); ?>
	</div> -->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->