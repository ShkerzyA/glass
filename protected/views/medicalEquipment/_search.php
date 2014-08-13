<?php
/* @var $this EventsoperController */
/* @var $model Eventsoper */
/* @var $form CActiveForm */
?>

<div class="slim form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row" style="width: 260px;">

		<?php $tmp=$model->listCreators();
echo $form->dropDownList($model,"creator",$tmp,array('empty'=>'Все')); ?>
	</div>




	<div class="row"><div style="float: left; position: relative;">ОТ</div>

		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'date',
   'model' => $model,
   'attribute' => 'date',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
       'style' => 'height:20px;',
       'placeholder' => 'Начальная дата'
   ),
	));?>

	</div>

	<div class="row"><div style="float: left; position: relative;">ДО</div>

		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'date_end',
   'model' => $model,
   'attribute' => 'date_end',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
       'style' => 'height:20px;',
       'placeholder' => 'Конечная дата'
   ),
	));?>

	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Выбрать'); ?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- search-form -->