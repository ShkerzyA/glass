

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'department-posts-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Поля с <span class="required">*</span> обязательны.</p>

    <?php echo $form->errorSummary($model); ?>


    <div class="row">
        <?php echo $form->labelEx($model,'post'); ?>

        <?php echo $form->textField($model,'post',array('size'=>60,'maxlength'=>80)); ?>

        <?php echo $form->error($model,'post'); ?>
    </div>

	<div class="row">
        <?php echo $form->labelEx($model,'islead'); ?>

        <?php echo $form->checkBox($model,'islead',array('value'=>1,'size'=>2,'maxlength'=>2)); ?>

        <?php echo $form->error($model,'islead'); ?>
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



    <div class="row">
        <?php echo $form->labelEx($model,'post_subdiv_rn'); ?>


        <?php $tmp=Department::model()->findall();
echo $form->dropDownList($model,"post_subdiv_rn",CHtml::listData($tmp,"subdiv_rn",function($tmp) {
                return CHtml::encode($tmp->name);}),array('empty' => '')); ?>
        <?php echo $form->error($model,'post_subdiv_rn'); ?>
    </div>

    <div class="row">
    <?php echo $form->labelEx($model,'groups'); ?>
    <?php echo Customfields::multigroup($model); ?>
    <?php echo $form->error($model,'groups'); ?>
  </div>
    
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>

<?php $this->endWidget(); ?>

</div>