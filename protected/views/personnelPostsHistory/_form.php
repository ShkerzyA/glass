<?php
/* @var $this PersonnelPostsHistoryController */
/* @var $model PersonnelPostsHistory */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'personnel-posts-history-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля отмеченые <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_personnel'); 
		$personnels=Personnel::model()->findall(array('order'=>'t.surname ASC'));
		 echo $form->dropDownList($model,'id_personnel',CHtml::listData($personnels,'id',function($personnels) {
			return CHtml::encode($personnels->surname.' '.$personnels->name.' '.$personnels->patr);
		}	
	)); ?>
		<?php echo $form->error($model,'id_personnel'); ?>
	</div>

	    <div class="row">
        <?php echo $form->labelEx($model,'id_post'); ?>

        <?php $tmp=DepartmentPosts::model()->findall(array('order'=>'t.id ASC'));
echo $form->dropDownList($model,"id_post",CHtml::listData($tmp,"id",function($tmp) {
                return CHtml::encode($tmp->id.' '.$tmp->post.'/'.$tmp->postSubdivRn->name);}),array('empty' => '')); ?>
        <?php echo $form->error($model,'id_post'); ?>
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