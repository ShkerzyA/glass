<?php /* @var $this Controller */ ?>
<?php //if($this->beginCache('cachemeid')) { ?>
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
	<?php Yii::app()->getClientScript()->registerCoreScript('jquery.cookie'); ?>
	<?php Yii::app()->getClientScript()->registerCoreScript('glassCommon'); ?>
	<?php Yii::app()->request->cookies['tornado'] = new CHttpCookie('tornado', Yii::app()->params['tornado']); ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>

<div id="header">
		<div id="auth">
			<?php $this->widget('application.widgets.GlassAuth'); ?>
		</div>
	<!--	<div id=it_tools> 
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
		</div> -->
		

</div><!-- header -->
<div class="container" id="page" class="killClick">

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
	</div><!-- footer -->

</div><!-- page -->
<?php 

echo<<<END
<script type='text/javascript'>

function scrollT(){
	$("html").animate({"scrollTop":0},"slow");
}

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
           onClick='scrollT(); return false' onMouseOver='sttopmode(this,true)' onMouseOut='sttopmode(this,false)'>&#9650 Наверх</div> 
END;

?>

</body>
</html>
<?php 
	//$this->endCache(); } 
?>
	
