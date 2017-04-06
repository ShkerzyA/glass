
var plcJsFlt=0;
var globTimeout = null;
var mchck=false;
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

  $('.prjT').live('click',function(){
    $('.prj'+this.id).toggle();
  });

  $('.hideT').live('click',function(){
    $('.hide'+this.id).toggle();
  });

	$("#EquipmentLog_details").live('keydown',function(e){
        if(e.keyCode==13){
        	tmp=$("#EquipmentLog_details").val();
        	$("#EquipmentLog_details").val(tmp+',');
        }
    });

  $('#num_str').live('keydown',function(){
    clearInterval(globTimeout);
    globTimeout=setTimeout(function(){
      $('#subsNum').empty();
      $('#subsNum').append($('#num_str').val()-$('#lastNumSt').val());
    },1000);
    
  });

  $(".plcJsFilter").live('click',function sss(){
      if(plcJsFlt==0){
        $(".taskpanel").hide();
        $(".taskpanel:contains('"+this.id+"')").show();
        scrollT();
        plcJsFlt=1;
      }else{
        $(".taskpanel").show();
        plcJsFlt=0;
      }
  });

  $(".filter_eq").live('click',function sss(){
      //alert($(this).text());
      $(".str_eq").hide();
      mchck=false;
      $('.mass_checkbox').prop('checked',''); 
      $(".str_eq:contains('"+$(this).text()+"')").show();
  });

  
  $('.check_mass_checkbox').live('click',function(){
    if(mchck){
      mchck=false;
      $('.str_eq:visible .mass_checkbox').prop('checked',''); 
    }else{
      mchck=true;
      $('.str_eq:visible .mass_checkbox').prop('checked','checked');    
    }
    return false;
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
		showLogEq(this.id);
	});

  $('.showlogUni').live('click',function(){
    showLog(this.id,$(this).attr('mod'));
  });

  $('.showlogWpEq').live('click',function(){
    showLogWp(this.id);
  });

}

function sameTasks(id,type){
if(id){
    $.get("/glass/tasks/sameTasks", {id: id, type: type},
            function(data, status) {
                if (status == "success") {
                    if(data.length>0){
                        $('html').append(awesomeWindowWrap(data));
                    }
                }else{
                    alert('Ошибка');
                }
            },"html"
        );
    } 
}

function vehiclesAccess(id){
if(id){
    $.get("/glass/vehicles/checkVehiclesAccess", {id: id},
            function(data, status) {
                if (status == "success") {
                    if(data.length>0){
                        $('.result').empty()
                        $('.result').append(data);
                    }
                }else{
                    alert('Ошибка');
                }
            },"html"
        );
    } 
}


function awesomeWindowWrap(data){
  var res='<div class="back"><div class="window_awesom killClick" style="width: 80%; left: 10%; position: fixed; max-width: 90%; min-height: 50px; top: 30%; margin: auto; font-size: 9pt; overflow: hidden;"><div id="back" class="close_this"></div><div class="wa_body" style="min-height: 200px;">'+ data + '</div></div></div>';
  return res;
}


$(document).ready(init());





function showLogEq(id){
    if (id) {
        $.get("/glass/EquipmentLog/showLog", {id: id},
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

function showLog(id,mname){
    if (id) {
        $.get("/glass/Log/showLog", {id: id, mname: mname},
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

function showLogWp(id){
    if (id) {
        $.get("/glass/EquipmentLog/showLogWp", {id_w: id},
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

function updateTaskMessage(task){
  notifyUser('Задачи','Новый комментарий к задаче','http://'+window.location.host+'/glass/tasks/'+task);
}


function notifyUser(mtitle,mbody,url) {
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
            notification.onclick = function() {
              if(url){
                window.open(url, '_blank');
              }
            }
          });
    }
  