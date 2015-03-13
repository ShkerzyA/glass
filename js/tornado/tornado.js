
function init(){
    $('html').live('keydown',function(e){
        if(e.ctrlKey && e.keyCode==13){
            Socket.ws.send('Hey server, whats up?');
        }
    });
    Socket = {
        ws: null,
        init: function () {
            ws = new WebSocket('ws://' + document.location.host + ':8888/websocket');
            ws.onopen = function () {
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