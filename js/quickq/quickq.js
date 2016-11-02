
function init(){
     $('#qqLogin').live('click',function(e){
        var mess = {
                    "command": "login",
                    "data": {
                        "component": "workplace",
                        "login": "ian",
                        "password": "76d80224611fc919a5d54f0ff9fba446",
                        "workplace": 50
                }
            };
            SocketQQ.ws.send(JSON.stringify(mess));
                //alert(document.cookie);*/
             console.log('QQ Login ok');
    });

    $('#qqNewUser').live('click',function(e){
        var mess = {
                    "token":SocketQQ.token,
                    "command": "newUser",
                    "data":{
                        "login":   $('#newUserQQLogin').val(),
                        "password":    $('#newUserQQPassword').val(),
                        "surname": $('#qqS').val(),
                        "name" :   $('#qqN').val(),
                        "patronymic":  $('#qqP').val(),
                        "role_id": $('#newUserQQRole').val(),
                        "clerk":{"all_operations": 0, "priority": 50, "default_workplace": null}
                    }
            };
            SocketQQ.ws.send(JSON.stringify(mess));
    });   

    $('#qqLogout').live('click',function(e){
            if(SocketQQ.token){
                var mess = {
                    "token":SocketQQ.token,
                    "command": "logout",
                    "data": {
                    }
                };
                SocketQQ.ws.send(JSON.stringify(mess));
                //alert(document.cookie);*/
                console.log('QQ Logout');  
            }    
    });

    SocketQQ = {
        token: null,
        ws: null,
        init: function () {
            //ws = new WebSocket('ws://' + document.location.host + ':8888/websocket'); должно быть так. прописано жестко, потому что еще develop server работает
            ws = new WebSocket('ws://10.126.80.180:55556');
            ws.onopen = function () {
                //var mess = {
                //    'type' :'user',
                //    'id' :$.cookie('pers')
                //};
                //ws.send(JSON.stringify(mess));
                //alert(document.cookie);*/
                console.log('Socket quickq opened');
            };

            ws.onclose = function () {
                console.log('Socket quickq close');
            };


            ws.onmessage = function (e) {
                //alert(e.data);
                var res=$.parseJSON(e.data);
                console.log(e.data);
                switch(res.command){
                    case 'login':
                        SocketQQ.token=res.data.token;
                    break;
                    case 'logout':
                    break;
                }
            };
            this.ws = ws;
        }
    };

    SocketQQ.init();
}


$(document).ready(init());
