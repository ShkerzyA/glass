<?php
/* @var $this EventsoperController */
/* @var $model Eventsoper */
/* @var $form CActiveForm */
Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
Yii::app()->getClientScript()->registerCssFile(Yii::app()
    ->getClientScript()
    ->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css' );

?>

<div class="form">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'eventsoper-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


	<?php
		if (Yii::app()->user->checkAccess('inGroup',array('group'=>'operationsv')) or (Yii::app()->user->checkAccess('inGroup',array('group'=>array('operations')))) ) 
			$this->renderPartial('_common_form',array('form'=>$form,'model'=>$model)); 
		else
			$this->renderPartial('view',array('model'=>$model)); 

	?>

	<?php 
		if (Yii::app()->user->checkAccess('inGroup',array('group'=>'anestesiologist')) or Yii::app()->user->checkAccess('inGroup',array('group'=>array('operationsv'))))
			$this->renderPartial('_anest_form',array('form'=>$form,'model'=>$model)); ?>




	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->