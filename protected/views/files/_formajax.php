<?php
/* @var $this FilesController */
/* @var $model Files */
/* @var $form CActiveForm */
?>





<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'files-form-ajax',
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>

	<h3>Прикрепить файл</h3>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>

		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>

		<nobr>
			<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255,'style'=>'max-width:30%;','placeholder'=>'url')); ?>
			<?php echo $form->fileField($model,'link',array('size'=>60,'maxlength'=>255,'style'=>'max-width:30%;')); ?>
			
		
		</nobr>

		<?php echo $form->error($model,'link'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::htmlButton('Сохранить',array(
                // on submit call JS send() function
                'id'=> 'file-ajax-submit-btn', // button id
                'class'=>'post_submit',
            ));
   		 ?>

	</div>

<?php $this->endWidget(); ?>



