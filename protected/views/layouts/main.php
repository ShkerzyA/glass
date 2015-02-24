<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />
	<link rel="icon" type="image/png" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.png" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css" />

	<?php Yii::app()->getClientScript()->registerCoreScript('jquery'); ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<?php if(!(Yii::app()->user->isGuest)): ?>

	<?php if(!empty(Yii::app()->user->bg) and is_file(Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->user->bg)): ?>
	<style>
		body{
			background: url("/glass/images/<?php echo Yii::app()->user->bg; ?>") 100% fixed;
			background-size: 100%;
		}
	</style>
	<?php endif; ?>
	<?php if (in_array(1011,Yii::app()->user->id_departments)): ?>
		<?php if((Yii::app()->user->id_pers==19705) or (Yii::app()->user->id_pers==20024) or (Yii::app()->user->id_pers==2)):?>
			<div id='omsk'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/nyan_bz.gif"></div>
		<?php else: ?>
			<div id='omsk'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/nyan.gif"></div>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>

<div id="header">
		<div id="auth">
			<?php $this->widget('application.widgets.GlassAuth'); ?>
		</div>
		<a href="http://10.126.84.31/"><div id="logo" style="float: left"><?php echo CHtml::encode(Yii::app()->name); ?></div></a>
		<div id=it_tools> 
			<img src="/glass/images/it_ico/coil.png"> 
			<img src="/glass/images/it_ico/cable.png"> 
			<img src="/glass/images/it_ico/connector.png"> 
			<img src="/glass/images/it_ico/crimp.png"> 
			<img src="/glass/images/it_ico/drill.png"> 
			<img src="/glass/images/it_ico/dvd.png"> 
			<img src="/glass/images/it_ico/flash.png"> 
			<img src="/glass/images/it_ico/hammer.png"> 
			<img src="/glass/images/it_ico/nippers.png"> 
			<img src="/glass/images/it_ico/pilot.png"> 
			<img src="/glass/images/it_ico/scotch.png"> 
			<img src="/glass/images/it_ico/screwdriver.png"> 
			<img src="/glass/images/it_ico/tester.png"> 
			<img src="/glass/images/it_ico/ties.png"> 
		</div>
		

</div><!-- header -->
<div class="container" id="page">
	<div id="mainmenu">

				<!--array('label'=>'КККОД', 'url'=>array('/site/index')),
				array('label'=>'Контакты', 'url'=>array('/site/page', 'view'=>'about')),-->
		<?php $this->widget('application.widgets.MyMenu',array(
			'items'=>array(

				array('label'=>'События', 'url'=>array('/rooms/show?Event_type=events'),'submenu'=>array(
                			array('Мед. оборудование','/medicalEquipment/plan',Yii::app()->user->checkAccess('inGroup',array('group'=>'medequipment'))),
                			array('Общественные','/rooms/show?Event_type=events'),
                			array('Операционные','/rooms/show?Event_type=eventsOpPl',((Yii::app()->user->checkAccess('inGroup',array('group'=>'operationsv'))) or (Yii::app()->user->checkAccess('inGroup',array('group'=>'operations'))) )))),
				array('label'=>'Справочник', 'url'=>array('/cabinet/phones'),'submenu'=>
						array(array('Телефоны','/cabinet/phones'),
							array('Операции','/Eventsoper/plan2',((Yii::app()->user->checkAccess('inGroup',array('group'=>'operationsv'))) or (Yii::app()->user->checkAccess('inGroup',array('group'=>'operations'))) )),
							array('IT help','/Catalogs/26',Yii::app()->user->checkAccess('inGroup',array('group'=>'it'))),
							array('Кадры', '/personnel/index',Yii::app()->user->checkAccess('inGroup',array('group'=>'it'))),
							array('Оборудование', '/equipment/index',Yii::app()->user->checkAccess('inGroup',array('group'=>'it'))),
							array('Отделы', '/department/tree',!Yii::app()->user->isGuest),
							)),
                array('label'=>'Документы', 'url'=>array('/myDocs/index')),
                array('label'=>'Задачи', 'url'=>array('/tasks/helpDesk')),
                	array('label'=>'КККОД', 'url'=>array('/myAdmin/index'), 'visible'=>Yii::app()->user->checkAccess('inGroup',array('group'=>'it'))),

				array('label'=>'Админ', 'url'=>array('/admin/index'), 'visible'=>(Yii::app()->user->role=='administrator'))
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
<?php 

echo<<<END
<script type='text/javascript'>
$(function () {
 var scroll_timer;
 var displayed = false;
 var \$message = $("#scrollToTop");
 var \$window = $(window);
 var top = $(document.body).children(0).position().top;

 \$window.scroll(function () {
  window.clearTimeout(scroll_timer);
  scroll_timer = window.setTimeout(function () { 
   if (\$window.scrollTop()<=top+50) {
    displayed = false;
    \$message.fadeOut(200);
   } else if (displayed == false) {
    displayed = true;
    \$message.stop(true, true).fadeIn(200).click(function() {
     \$message.fadeOut(200);
    });
   }
  }, 100);
 });
});

function sttopmode(elem,over) {
 if (over) {
  elem.style.backgroundColor="rgba(0,0,0,0.1)";
 } else {
  elem.style.backgroundColor="rgba(255,255,255,0)";
 }
}

</script>
<div id='scrollToTop' style='display:none; z-index:999; background:rgba(255,255,255,0); position:fixed; bottom:0px; left:0;
           width:100%; color:#939393;  height:14px; padding-top:1px; text-align:center; cursor:pointer;'
           onClick='scroll(0,0); return false' onMouseOver='sttopmode(this,true)' onMouseOut='sttopmode(this,false)'>&#9650 Наверх</div> 
END;

?>

<?php if(!(Yii::app()->user->isGuest)): ?>
	<?php if (in_array(1011,Yii::app()->user->id_departments)): ?>
		<?php $this->widget('application.widgets.Messenger');  ?>
	<?php endif; ?>
<?php endif; ?>

</body>
</html>
	
