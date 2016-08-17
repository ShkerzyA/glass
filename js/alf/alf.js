function init(){
	$("#alf_login").live('click',function(){
        
        var url = "http://10.126.80.179:8080/alfresco/service/api/login";
       // var userInfo = {username : "ian" , password: "qwe"};
        
           

            $.ajax({
                        type: 'GET',
                        url:'http://10.126.80.179:8080/alfresco/service/api/login?u=ian&pw=qwe',
                        crossDomain: true,
                        //beforeSend: function (xhr){ xhr.setRequestHeader('Authorization', setAuthTokenHere() }
                        //data: JSON.stringify(userInfo) ,
                        dataType: 'json',
                        xhrFields: { withCredentials: true },
                        contentType: 'json',
                        success: function (response) {
                            alert('ok');
                        },
                        error: function (response) {
                            alert('fail');
                        }
                    });
            /*
				 	$.ajax({
            			type: 'POST',
            			url: url,
                        crossDomain: true,
                        //beforeSend: function (xhr){ xhr.setRequestHeader('Authorization', setAuthTokenHere() }
            			data: JSON.stringify(userInfo) ,
            			dataType: 'json',
	    				contentType: 'application/json',
            			success: function (response) {
                            alert('ok');
            			},
            			error: function (response) {
                            alert('fail');
            			}
        			}); */
		});
	

    $("#alf_add").live('click',function(){
        
        var url = "http://10.126.80.179:8080/alfresco/service/api/people";
        var userInfo = {userName : "testuser" , password: "testpassword" , firstName : "testfirst", lastName : "testlast", email : "testemail@test.com",  disableAccount: false, quote: -1, groups: []};
        
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: JSON.stringify(userInfo) ,
                        dataType: 'json',
                        contentType: 'application/json',
                        success: function (response) {
                            alert('ok');
                        },
                        error: function (response) {
                            alert('fail');
                        }
                    });
        });
    };
$(document).ready(init());