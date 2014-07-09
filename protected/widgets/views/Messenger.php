<!--				array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest) -->


<?php Yii::app()->clientScript->registerPackage('userjs'); ?>
<?php if(Yii::app()->user->isGuest):?>

		<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<div class="inline">
		<?php echo $form->error($model,'username'); ?>
		<?php echo $form->labelEx($model,'Логин'); ?>
		<?php echo $form->textField($model,'username'); ?>
	</div>

	<div class="inline">
		<?php echo $form->error($model,'password'); ?>
		<?php echo $form->labelEx($model,'Пароль'); ?>
		<?php echo $form->passwordField($model,'password'); ?>

	</div>

	<div class="inline rememberMe">

		<?php echo $form->error($model,'rememberMe'); ?>
		<?php echo $form->label($model,'Запомнить меня'); ?>
		<?php echo $form->checkBox($model,'rememberMe'); ?>
	</div>

	<div class="inline buttons">
		<?php echo CHtml::submitButton('Вход'); ?>
	</div>

<?php $this->endWidget(); ?>
	</div><!-- form -->
<?php endif?>


<?php if(!Yii::app()->user->isGuest):?>
	<?php $patr=(!empty(Yii::app()->user->patr))?(Yii::app()->user->patr):''; ?>
<span class=auth><div class=logout style="color: black"><span id="userEd"><?php echo(Yii::app()->user->name).' '.$patr.' '?></span><a href="<?php echo(Yii::app()->request->baseUrl); ?>/site/logout">(выход) </a> </div></span>
<?php endif?>


