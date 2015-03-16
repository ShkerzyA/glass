<!--                array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest) -->

<?php if(!Yii::app()->user->isGuest):?>

<?php Yii::app()->clientScript->registerPackage('userjs'); ?>
 <audio id='incmess' src="<?php echo Yii::app()->baseUrl?>/media/mess/kib2.ogg"></audio>
 <audio id='horn' src="<?php echo Yii::app()->baseUrl?>/media/horn/horn.ogg"></audio>
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

    $('#Messages_ttext').live('focus',function(){
        Socket.ws.send('onWrite');
    });

    $('#Messages_ttext').live('focusout',function(){
        Socket.ws.send('onWriteOut');
    });

    /*
    setInterval(function(){
        updateChat();
    },5000);

    setInterval(function(){
        updateMon();
    },20000); */

}
function onWrite(){
    $('#Messages_ttext').attr('placeholder','Нечто набирает сообщение');
}

function onWriteOut(){
    $('#Messages_ttext').attr('placeholder','текст сообщения (enter)');
}

function updateMon(){
    $.post('/glass/messages/updMon',{time: timem},function(response){
            var res=$.parseJSON(response);
            $("#serb").empty();
            $.each(res, function(i, x) {
                $("#serb").append('<img title="'+x.label+'" src="/glass/images/led'+x.value+'.png">');
            });

            
        });
    }


function updateChat(){
    $.post('/glass/messages/showNew',{time: timem},function(response){
            var res=$.parseJSON(response);
            timem=res.timem;
        $(".mess_content").prepend(res.data);
        if(res.taskUpd==true){
          notifyUser('Задачи','Добавлена новая задача');
          document.getElementById('horn').play();
        }
            if(res.data.length>0){
                if(viewChat!=0){
                    $(".mess_head").css("background","red");
                }               
            document.getElementById('incmess').play();
            notifyUser('Чат','Новое сообщение');
            }
        });
    $("#MessLock").hide();
}
updateMon();
$(document).ready(init());



</script>
    
    <div class="serb"><div style="float: left;"></div><div style="float: left;" id="serb"></div></div>
  
    <div class="messenger">
        <div class="mess_head"></div>
        <div class="mess_body">
            <div class="mess_content">
            <?php
                foreach ($model as $v) {
                    $this->controller->renderPartial('/messages/compactview',array('model'=>$v),false,false);
                }
            ?>

            </div>
           <!-- <div id=MessLock style=""><img height=100% src='<?php echo Yii::app()->baseUrl ?>/images/load.gif'> </div> -->
            <div class="mess_form">
            <?php echo CHtml::form();
 
echo CHtml::textArea('Messages[ttext]','',array('placeholder'=>'текст сообщения (enter)'));
echo CHtml::ajaxSubmitButton('Отправить', '/glass/actions/chatSaveMessage', array(
    'type' => 'POST',
    'success' => 'function(response) {
        $("#Messages_ttext").val("");
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