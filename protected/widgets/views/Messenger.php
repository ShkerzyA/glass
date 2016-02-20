<!--                array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest) -->

<?php if(!Yii::app()->user->isGuest):?>

<?php Yii::app()->clientScript->registerPackage('userjs'); ?>
    <audio id='serg_good' src="<?php echo Yii::app()->baseUrl?>/media/mess/serg.ogg"></audio>
    <?php if (!empty(Yii::app()->user->chatsound)):?>
        <audio id='incmess1' src="<?php echo Yii::app()->baseUrl?>/media/mess/mess1.ogg"></audio>
        <audio id='incmess2' src="<?php echo Yii::app()->baseUrl?>/media/mess/mess2.ogg"></audio>
        <audio id='incmess3' src="<?php echo Yii::app()->baseUrl?>/media/mess/mess3.ogg"></audio>
        <audio id='incmess4' src="<?php echo Yii::app()->baseUrl?>/media/mess/mess4.ogg"></audio>
    <?php endif; ?>
    <?php if (!empty(Yii::app()->user->tasksound)):?>
        <?php $sound=(!empty(Yii::app()->user->horn))?Yii::app()->user->horn:'horn6.ogg'?>
        <audio id='horn' src="<?php echo Yii::app()->baseUrl?>/media/horn/<?php echo $sound ?>"></audio>
    <?php endif; ?>
<script type="text/javascript">


var timem="<?php echo date('Y-m-d H:i:s');?>";
var viewChat=<?php echo Yii::app()->user->viewChat;?>;
var timeout=null;
function init(){
    keypressing=0;
    $('.messenger').live('mouseenter',function(){
        $(".mess_head").css("background","black");
    });
    $('#Messages_ttext').live('keydown',function(e){
          if(e.keyCode==13){
            $('#Messages_submit').click();
        }
    });

    $('#Messages_ttext').live('keydown',function(){
        if(keypressing==0){
            keypressing=1;
            Socket.ws.send('{"type":"action","id":"onWrite"}');    
        }
        if(timeout != null) clearTimeout(timeout);  
        timeout =setTimeout(function(){ 
            Socket.ws.send('{"type":"action","id":"onWriteOut"}'); 
            keypressing=0;
        },1000);          
    });
    /*
    setInterval(function(){
        updateChat();
    },5000);

    setInterval(function(){
        updateMon();
    },20000); */

}
function onWrite(user){
    //$('#Messages_ttext').attr('placeholder',user+'набирает сообщение');
    $('#mess_info').empty();
    $('#mess_info').append(user+'набирает сообщение');
}

function onWriteOut(){
    //$('#Messages_ttext').attr('placeholder','текст сообщения (enter)');
    $('#mess_info').empty();
}

function updateMon(){
    $.post('/glass/messages/updMon',{time: timem},function(response){
            var res=$.parseJSON(response);
            $("#serb").empty();
            $.each(res, function(i, x) {
                $("#serb").append('<img title="'+x.label+'" src="/glass/images/led'+x.value+'.gif">');
            });

            
        });
    }
function sergGood(){
    document.getElementById('serg_good').play();
}

function updateChat(){
    $.post('/glass/messages/showNew',{time: timem},function(response){
            var res=$.parseJSON(response);
            timem=res.timem;
        $(".mess_content").prepend(res.data);
        $(".mess_content").animate({"scrollTop":0},"slow");
        if(res.taskUpd==true){
          notifyUser('Задачи','Добавлена новая задача');
          document.getElementById('horn').play();
        }
            if(res.data.length>0){
                if(viewChat!=0){
                    $(".mess_head").css("background","red");
                }               
            randnum=Math.floor(Math.random( ) * (4 - 1 + 1)) + 1;
            document.getElementById('incmess'+randnum).play();
            notifyUser('Чат','Новое сообщение');
            }
        });
    $("#MessLock").hide();
}
updateMon();
$(document).ready(init());

window.onload=function(){
    $(".mess_content").animate({"scrollTop":0},"slow");
}


</script>
    <!--<div style="position: absolute; left: 0px; top 50px; border: 4px solid red;">
        <embed src="http://localhost/glass/uflvplayer.swf" allowFullScreen="false" type="application/x-shockwave-flash" flashvars="way=http://localhost:7654/video.flv&skin=whiteblack&autoplay=1" /></embed>
    </div> -->
    <!--
    <video width="320" height="240" controls="controls" autoplay poster="video/duel.jpg" style="position: absolute; top: 2px; right: 2px">
            <source src="http://localhost:7654" type='video/mp4' codecs="h264" />
            <source src="http://localhost:7654/demo.webm" type='video/webm; codecs="vp8, vorbis"' /> 
    </video>  -->
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
            <div id=ancor></div>
            </div>
           <!-- <div id=MessLock style=""><img height=100% src='<?php echo Yii::app()->baseUrl ?>/images/load.gif'> </div> -->
            <div class="mess_form">
                <div id='mess_info'></div>
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