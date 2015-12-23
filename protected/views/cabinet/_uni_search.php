<?php
/* @var $this PersonnelController */
/* @var $model Personnel */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	
	<!--
	<div class="row">

		<?php /* $tmp=Building::withFloorsInOneList();
				echo $form->dropDownList($model,"place",$tmp,array('empty' => 'Выбор местоположения (опционально)')); 
		 echo $form->error($model,'place'); */ ?>
	</div> -->
	<div class="row">
		

		<?php 	$tmp=Building::model()->findall();
				echo $form->dropDownList($model,"id_building",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->bname);}),array('empty' => '(выбор корпуса)','onchange'=>'submit()')); ?>
		<?php 	echo $form->error($model,'id_building'); ?>
	</div>

	<div class="inline">
		<?php echo $form->textField($model,'allfields',array('size'=>50,'maxlength'=>50,'placeholder'=>'ПОИСК (по ФИО, должности, кабинету, номеру телефона)')); ?>
	</div>
	
	<div class="row buttons inline">
		<?php echo CHtml::submitButton('Поиск'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->