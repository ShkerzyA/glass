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
		<?php echo $form->labelEx($model,'Запомнить меня'); ?><br>
		<?php echo $form->checkBox($model,'rememberMe') ?>
	</div>

	<div class="inline buttons">
		<?php echo CHtml::submitButton('Вход'); ?>
	</div>

<?php $this->endWidget(); ?>
	</div><!-- form -->
<?php endif?>


<?php if(!Yii::app()->user->isGuest):?>
	<?php $patr=(!empty(Yii::app()->user->patr))?(Yii::app()->user->patr):''; ?>
<span class=auth><div class=logout  style="color: black; height: 20px; float: right;"><span id="userEd"><img style="height: 100%; cursor: pointer;" title="<?php if (!empty(Yii::app()->user->lastlogin) and Yii::app()->user->checkAccess('inGroup',array('group'=>array('it')))) echo Yii::app()->user->lastlogin?>" src=<?php echo Yii::app()->baseUrl.'/images/edit_user.png'?>> <?php echo(Yii::app()->user->name).' '.$patr.' '?></span><a href="<?php echo(Yii::app()->request->baseUrl); ?>/site/logout"><img alt="выход" title="выход" style="height: 100%" src=<?php echo Yii::app()->baseUrl.'/images/logout.png'?>> </a> </div></span>
<?php endif?>


