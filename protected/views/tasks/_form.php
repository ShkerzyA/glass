<?php
/* @var $this TasksController */
/* @var $model Tasks */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tasks-form',
	'enableAjaxValidation'=>false,
)); 
?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>


	<?php echo $form->errorSummary($model); ?>

	<input type=hidden name=id_dep id=id_dep value="<?php echo $model->id_department ?>">
	<div class="row">
		<?php echo $form->labelEx($model,'tname'); ?>

		<?php echo $form->textField($model,'tname',array('size'=>60,'maxlength'=>100)); ?>

		<?php echo $form->error($model,'tname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ttext'); ?>

		<?php echo $form->textArea($model,'ttext',array('rows'=>6, 'cols'=>50)); ?>

		<?php echo $form->error($model,'ttext'); ?>
	</div>
<?php if((Yii::app()->user->role=='administrator') and ($model->scenario!='insert')): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'timestamp'); ?>

		<?php echo $form->textField($model,'timestamp'); ?>

		<?php echo $form->error($model,'timestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timestamp_end'); ?>

		<?php echo $form->textField($model,'timestamp_end'); ?>

		<?php echo $form->error($model,'timestamp_end'); ?>
	</div>
<!--
	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>

		<?php echo $form->textField($model,'type'); ?>

		<?php echo $form->error($model,'type'); ?>
	</div> -->

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>

		<?php //echo $form->textField($model,'status'); ?>


		<?php echo $form->dropDownList($model,'status',$model->getStatus(),
              array('empty' => '')); ?>

		<?php echo $form->error($model,'status'); ?>
	</div>

<?php endif; ?>

<?php if($model->scenario!='insert'):?>
	<div class="row">
		<?php echo $form->labelEx($model,'id_department'); ?>

		<?php $tmp=Department::model()->working()->findall();
		echo $form->dropDownList($model,"id_department",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->name);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_department'); ?>
	</div>
<?php endif; ?>

<?php if($model->scenario!='insert'):?>
	<div class="row">
		<?php echo $form->labelEx($model,'creator'); ?>

		<?php $tmp=Personnel::model()->working()->findall();
echo $form->dropDownList($model,"creator",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->surname.' '.$tmp->name);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'creator'); ?>
	</div>
<?php endif; ?>

<?php if($model->scenario!='insert'):?>
	<div class="row">
		<?php echo $form->labelEx($model,'group'); ?>

		<?php $tmp=PostsGroups::model()->findall();
echo $form->dropDownList($model,"group",CHtml::listData($tmp,"group_key",function($tmp) {
				return CHtml::encode($tmp->group_name);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'group'); ?>
	</div>
<?php endif; ?>
 <!--
	<div class="row">
		<?php //echo $form->labelEx($model,'executor'); ?>

		<?php
		//$tmp=DepartmentPosts::model()->working()->with("postSubdivRn")->findall(array('condition'=>'"postSubdivRn".id='.$model->id_department));
//echo $form->dropDownList($model,"executor",CHtml::listData($tmp,"id",function($tmp) {
				//return CHtml::encode($tmp->personnelPostsHistories[0]->idPersonnel->surname.' '.$tmp->personnelPostsHistories[0]->idPersonnel->name);}),array('empty' => '')); ?>
		<?php //echo $form->error($model,'executor'); ?>
	</div> -->

	<div class="row">
		<?php echo $form->labelEx($model,'executors'); ?>
		<?php echo Customfields::getFieldPosts($model); ?>
		<?php echo $form->error($model,'executors'); ?>
	</div>

	

<?php $this->endWidget(); ?>

</div><!-- form -->