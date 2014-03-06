<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */
Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
Yii::app()->getClientScript()->registerCssFile(Yii::app()
    ->getClientScript()
    ->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css' );

?>
<script>

$(document).ready(init);

function init(){

	//$('#Events_timestamp').val()
	//$('#Events_timestamp_end').val()
	var x=$('#Events_timestamp').val();
	var y=$('#Events_timestamp_end').val();

	if(x){
		x=x.split(":");
		var begin=(x[0]*60)+(x[1]*1);
	}else{
		var begin=600;
	}
	if(y){
		y=y.split(":");
		var end=(y[0]*60)+(y[1]*1);
	}else{
		var end=800;
	}
	

	$("#slider").slider({values:[begin,end],
   min:480,
   max:1020,
   range:true,
   step:15,
   slide:function(event,ui){
   		var z0 = ui.values[0]/60;
		var x0 = parseInt(z0); //Целая часть
		if(x0<10)
			x0='0'+x0;
		var y0 = (z0 - x0)*60;
		if(y0<10)
			y0='0'+y0;
		var z1 = ui.values[1]/60;
		var x1 = parseInt(z1); //Целая часть
		if(x1<10){
			x1='0'+x1;
		}
		var y1 = (z1 - x1)*60;
		if(y1<10){
			y1='0'+y1;
		}
			

      $("#Events_timestamp").val(x0+':'+y0);
      $("#Events_timestamp_end").val(x1+':'+y1);
   }});
}

</script>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>

		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>45)); ?>

		<?php echo $form->error($model,'name'); ?>
	</div>

	<table>
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

	<div id="slider"></div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>

		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>

		<?php echo $form->error($model,'description'); ?>
	</div>


	

<?php if((Yii::app()->user->role=='administrator') and ($model->scenario!='insert')): ?>

		<div class="row">
		<?php echo $form->labelEx($model,'creator'); ?>

		<?php $tmp=DepartmentPosts::model()->findall();
echo $form->dropDownList($model,"creator",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->post);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'creator'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_room'); ?>

		<?php $tmp=Rooms::model()->findall();
echo $form->dropDownList($model,"id_room",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->idCabinet->cname.' '.$tmp->idCabinet->num);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_room'); ?>
	</div>
<!--
	<div class="row">
		<?php echo $form->labelEx($model,'repeat'); ?>

		<?php echo $form->textField($model,'repeat'); ?>

		<?php echo $form->error($model,'repeat'); ?>
	</div>
-->
	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>

			<?php echo $form->dropDownList($model,'status',$model->getStatus(),
              array('empty' => '')); ?>

		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
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
		<?php echo $form->error($model,'date'); ?>
	</div>

<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->