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

	<div class="row">

		<?php $tmp=Rooms::model()->getRooms('eventsOpPl');
echo $form->dropDownList($model,"status",array('0,1,2,4'=>'План','3'=>'Мониторинг')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">

		<?php $tmp=Rooms::model()->getRooms('eventsOpPl');
echo $form->dropDownList($model,"id_room",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->idCabinet->cname);}),array('empty' => 'Все операционные',)); ?>
		<?php echo $form->error($model,'id_room'); ?>
	</div>

	<div class="row">

		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'date',
   'model' => $model,
   'attribute' => 'date',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
       'style' => 'height:20px;'
   ),
	));?>

	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('ОК'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->