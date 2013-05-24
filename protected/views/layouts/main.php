<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div id="header">
		<div id="auth">
			<?php $this->widget('application.widgets.GlassAuth'); ?>
		</div>
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
</div><!-- header -->
<div class="container" id="page">
	<div id="mainmenu">

				<!--array('label'=>'КККОД', 'url'=>array('/site/index')),
				array('label'=>'Контакты', 'url'=>array('/site/page', 'view'=>'about')),-->
		<?php $this->widget('application.widgets.MyMenu',array(
			'items'=>array(
				array('label'=>'Кадры', 'url'=>array('/personnel')),
                                array('label'=>'Отделы', 'url'=>array('/department/tree')),
				array('label'=>'Админ', 'url'=>array('/admin'), 'visible'=>(Yii::app()->user->name=='admin'))
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
