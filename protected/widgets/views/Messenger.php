<!--				array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest) -->

<?php if(!Yii::app()->user->isGuest):?>

<?php Yii::app()->clientScript->registerPackage('userjs'); ?>
<script type="text/javascript">
var timem="<?php echo date('Y-m-d H:i:s');?>";
var viewChat=<?php echo Yii::app()->user->viewChat;?>;
function init(){
	$('.messenger').live('mouseenter',function(){
    	$(".mess_head").css("background","black");
	});
	$('#Messages_ttext').live('keydown',function(e){
          if(e.keyCode==13){
            $('#Messages_submit').click();
        }
    });
	setInterval(function(){
    	updateChat();
  	},5000);
}

function updateChat(){
	$.post('/glass/messages/showNew',{time: timem},function(response){
    		var res=$.parseJSON(response);
    		timem=res.timem;
    		if(res.data.length>0){
    			$(".mess_head").css("background","red");
      			$(".mess_content").prepend(res.data);
    		}
    	});
}
 $(document).ready(init());

</script>
	<div class="messenger">
		<div class="mess_head">чат "Кровь и бетон"</div>
		<div class="mess_body">
			<div class="mess_content">
			<?php
				foreach ($model as $v) {
					$this->controller->renderPartial('/messages/compactview',array('model'=>$v),false,false);
				}
			?>

			</div>
			<div class="mess_form">
			<?php echo CHtml::form();
 
echo CHtml::textArea('Messages[ttext]', $input,array('placeholder'=>'текст сообщения (enter)'));
echo CHtml::ajaxSubmitButton('Отправить', '/glass/actions/chatSaveMessage', array(
    'type' => 'POST',
    'success' => 'function(response) {
    	$("#Messages_ttext").val("");
    	updateChat();
  	}',

),
array(
    'type' => 'submit',
    'id'=>'Messages_submit',
    'style'=>'display: none;'
));
 
echo CHtml::endForm();?>
<script type="text/javascript">
	if(viewChat==0){
 		$('.mess_body').hide();
 	}else if(viewChat==1){
 		$('.mess_body').show();
 	}
</script>
			</div>
		</div>
	</div>
<?php endif?>



