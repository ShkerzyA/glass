<!--				array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest) -->

<?php if(!Yii::app()->user->isGuest):?>

<?php Yii::app()->clientScript->registerPackage('userjs'); ?>
<script type="text/javascript">
var timem="<?php echo date('Y-m-d H:i:s');?>";
function init(){
	$('#Messages_ttext').live('keydown',function(e){
          if(e.ctrlKey && e.keyCode==13){
            $('#Messages_submit').click();
        }
    });
	setInterval(function(){
    	updateChat();
  	},10000);
}

function updateChat(){
	$.post('/glass/messages/showNew',{time: timem},function(response){
    		var res=$.parseJSON(response);
    		timem=res.timem;
      		$(".mess_content").prepend(res.data);
      	
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
 
echo CHtml::textArea('Messages[ttext]', $input,array('placeholder'=>'текст сообщения (ctrl+enter)'));
echo CHtml::ajaxSubmitButton('Отправить', '/glass/actions/saveMessage', array(
    'type' => 'POST',
    'success' => 'function(response) {
    	updateChat();
    	$("#Messages_ttext").val("");
  	}',

),
array(
    'type' => 'submit',
    'id'=>'Messages_submit',
    'style'=>'display: none;'
));
 
echo CHtml::endForm();?>
			</div>
		</div>
	</div>
<?php endif?>



