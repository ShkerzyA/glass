

function init(){
	$('#userEd').live('click',function(){ 
		load_modalForm();
	});

	$('.close_this').live('click',function(){ 
		$('.'+this.id).remove();
	});

  $('.killClick').live('click',function(){ 
    $(this).remove();
  });

	$("#EquipmentLog_details").live('keydown',function(e){
        if(e.keyCode==13){
        	tmp=$("#EquipmentLog_details").val();
        	$("#EquipmentLog_details").val(tmp+',');
        }
    });

  $(".filter_eq").live('click',function sss(){
      //alert($(this).text());
      $(".str_eq").hide();
      $(".str_eq:contains('"+$(this).text()+"')").show();
  });

	$('.mess_head').live('click',function(){
		$('.mess_body').toggle();
		$.post("/glass/Users/viewChat", {},
            function(data, status) {
                if (status == "success") {
                    }else{
                    alert('Ошибка');
                }
            },"html"
        );
	});

	$('.showlog').live('click',function(){
		showLog(this.id);
	});

}

function awesomeWindowWrap(data){
  var res='<div class="back"><div class="window_awesom killClick" style="width: 80%; left: 10%; position: fixed; max-width: 90%; min-height: 50px; top: 30%; margin: auto; font-size: 9pt; overflow: hidden;"><div id="back" class="close_this"></div><div class="wa_body" style="min-height: 200px;">'+ data + '</div></div></div>';
  return res;
}


$(document).ready(init());





function showLog(id){
    if (id) {
        $.post("/glass/EquipmentLog/showLog", {id: id},
            function(data, status) {
                if (status == "success") {
                    $('html').append(awesomeWindowWrap(data));
                }else{
                    alert('Ошибка');
                }
            },"html"
        );
    }

}

function load_modalForm(){
	$.post('/glass/Users/modalForm',{},function(data,status){
		if(status=='success'){
			$('html').append('<div class="back"><div class="window_awesom" style="right: 5px; top: 5px;"><div id="back" class="close_this"></div>'+ data + '</div></div></div>');
		}
	},'html');
}


function notifyUser(mtitle,mbody) {
          if (!('Notification' in window)) {
            return false;
          }
          var title;
          var options;
            title = mtitle;
            options = {
              body: mbody,
              tag: 'preset',
              icon: '/glass/images/eye.png'
            };
  
          Notification.requestPermission(function() {
            var notification = new Notification(title, options);
          });
    }
  