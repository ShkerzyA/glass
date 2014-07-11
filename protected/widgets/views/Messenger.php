<!--				array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest) -->

<?php if(!Yii::app()->user->isGuest):?>

<?php Yii::app()->clientScript->registerPackage('userjs'); ?>
	<div class="messenger">
		<div class="mess_head">Имя пользователя число сообщений</div>
		<div class="mess_body">
			<div class="mess_content">

				is supposed to force browsers to print pages in landscape mode. This rule is mentioned in many questions on stackoverflow, on many other programming sites, and in reference works such as O'Reilly's HTML/XTHML The Definitive Guide, Fifth Edition.

I've tried to using this CSS rule with many different format tweaks with both inline styles and linked style sheets, specifying media and not specifying media, with IE8, Chrome 7.0, and Firefox 3.6. I've tried printing to a Xerox Phaser 8560 and to the Adobe PDF print driver. All of my testing has been done on Windows Vista Ultimate 64 bit.

I have never see this CSS rule actually work, i.e. I've never seen a page print landscape on any attempt. Admittedly I haven't done really thorough QA on this, since I've only tried 2 printer drivers and one OS.

Have you actually seen this rule work for a browser, OS, and printer configuration? There is some mention in other questions on this topic that the rule is not broadly supported. Since I can't get it to work on my development machine at all I am wondering when, if ever, does it work? It would help to get specifics on browser, OS, and printer combinations that are known to work, or to confirm that this is a waste of time.
			</div>
			<div class="mess_form">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'eventsoper-form',
					'enableAjaxValidation'=>true,
					)); ?>


					<div style="float: right; width: 30%"><?php echo CHtml::submitButton($model->isNewRecord ? 'Отправить' : 'Сохранить'); ?></div>
						<?php echo $form->textArea($model,'ttext'); ?>
						<?php echo $form->error($model,'ttext'); ?>
					<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
<?php endif?>



