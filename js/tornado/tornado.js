
function init(){
    $('html').live('keydown',function(e){
        if(e.ctrlKey && e.keyCode==13){
            Socket.ws.send('Hey server, whats up?');
        }
    });
    Socket = {
        ws: null,
        init: function () {
            //ws = new WebSocket('ws://' + document.location.host + ':8888/websocket'); должно быть так. прописано жестко, потому что еще develop server работает
            ws = new WebSocket('ws://'+$.cookie("tornado")+'/websocket');
            ws.onopen = function () {
                var mess = {
                    'type' :'user',
                    'id' :$.cookie('pers')
                };
                ws.send(JSON.stringify(mess));
                //alert(document.cookie);*/
                console.log('Socket opened');
            };

            ws.onclose = function () {
                console.log('Socket close');
            };


            ws.onmessage = function (e) {
                //alert(e.data);
                var res=$.parseJSON(e.data);
                console.log(e.data);
                if(res.type='action'){
                    if(res.id=='updateChat')
                        updateChat();
                    if(res.id=='updateTaskMessage')
                        updateTaskMessage(res.task);
                    if(res.id=='updateMon')
                        updateMon();
                    if(res.id=='onWrite')
                        onWrite(res.user);
                    if(res.id=='onWriteOut')
                        onWriteOut();
                    if(res.id=='updateTasks'){
                        updateChat();
                        updateTasks();
                    }
                    if(res.id=='sergGood'){
                        sergGood();
                    }
                }
            };
            this.ws = ws;
        }
    };

    Socket.init();
}


$(document).ready(init());
