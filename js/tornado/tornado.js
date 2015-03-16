
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
                /*var mess = {
                    "type" :"user",
                    "id" :$.cookie("id_pers")
                };
                ws.send(JSON.stringify(mess));
                //alert(document.cookie);*/
                console.log('Socket opened');
            };

            ws.onclose = function () {
                console.log('Socket close');
            };


            ws.onmessage = function (e) {
                console.log(e.data);
                //alert(e.data);
                if(e.data=='updateChat')
                    updateChat();
                if(e.data=='updateMon')
                    updateMon();
                if(e.data=='onWrite')
                    onWrite();
                if(e.data=='onWriteOut')
                    onWriteOut();
                if(e.data=='updateTasks'){
                    updateChat();
                    updateTasks();
                }
            };
            this.ws = ws;
        }
    };

    Socket.init();
}


$(document).ready(init());