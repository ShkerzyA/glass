<?php
/* @var $this EquipmentController */
/* @var $model Equipment */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerPackage('customfields');
?>

<script>
	function init(){

		$(this).live('keydown',function(e){
        	if(e.keyCode==13){
            	return false;
        	}
    	});

		$('#Equipment_type').live('change',function (){ 

			$('#Equipment_producer option:first').attr('selected', 'selected');
			$('#Equipment_producer option').hide();
			$('.c'+($(this).val())).show();
			
		});
	}
	$(document).ready(init);
</script>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'equipment-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

<?php if($model->scenario!='insert' or empty($model->id_workplace)): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'id_workplace'); ?>
		<?php $tmp=Workplace::model()->with('idCabinet.idFloor.idBuilding','idPersonnel')->findall(array('order'=>'bname ASC, "idFloor".fnum ASC, "idCabinet".num ASC'));
				echo $form->dropDownList($model,"id_workplace",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->wpNameFull());}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_workplace'); ?>
	</div>
<?php endif; ?>
	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>

		<?php $tmp=EquipmentType::model()->findall();
				echo $form->dropDownList($model,"type",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->name);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'producer'); ?>

		<?php $tmp=EquipmentProducer::getAll();
			echo $form->dropDownList($model,'producer',$tmp['values'],array('empty' => '','options'=>$tmp['css_class']));
		 	echo $form->error($model,'producer'); ?>
	</div>



	<div class="row">
		<?php echo $form->labelEx($model,'mark'); ?>

		<?php echo $form->textField($model,'mark',array('size'=>60,'maxlength'=>200,'class'=>'marksearch','autocomplete'=>"off")); ?>

		<?php echo $form->error($model,'mark'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'serial'); ?>

		<?php echo $form->textField($model,'serial',array('size'=>60,'maxlength'=>100,'autocomplete'=>"off")); ?>

		<?php echo $form->error($model,'serial'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inv'); ?>

		<?php echo $form->textField($model,'inv',array('size'=>60,'maxlength'=>100,'autocomplete'=>"off")); ?>

		<?php echo $form->error($model,'inv'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'ip'); ?>

		<?php echo $form->textField($model,'ip',array('size'=>60,'maxlength'=>100,'autocomplete'=>"off")); ?>

		<?php echo $form->error($model,'ip'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'mac'); ?>

		<?php echo $form->textField($model,'mac',array('size'=>60,'maxlength'=>100,'autocomplete'=>"off")); ?>

		<?php echo $form->error($model,'mac'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>

		<?php echo $form->dropDownList($model,'status',$model->getStatus(); ?>

		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'notes'); ?>

		<?php echo $form->textArea($model,'notes',array('rows'=>1, 'cols'=>1)); ?>

		<?php echo $form->error($model,'notes'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'released'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'released',
   'model' => $model,
   'attribute' => 'released',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
       'style' => 'height:20px;'
   ),
));?>
		<?php echo $form->error($model,'released'); ?>
	</div>


<?php if($model->scenario=='update'): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>

		<?php $tmp=$model->neighborsEq();
			echo $form->dropDownList($model,'parent_id',$tmp['values'],array('empty' => ''));
		 	echo $form->error($model,'parent_id'); ?>
	</div>
<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>
<?php 
	if(!empty($mass_id))
		echo CHtml::hiddenField('mass_id',implode(',',$mass_id));
?>
<?php $this->endWidget(); ?>

</div><!-- form -->