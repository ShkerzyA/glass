
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

  $('.remove_this').live('click',function(){ 
        $(this).parent("div").remove();
  });

  $('.portlet-decoration').live('click',function(){ 
    $(this).siblings('.portlet-content').toggle();
  });

  $('.killClick').live('click',function(){ 
    $(this).remove();
  });

  $('.prjT').live('click',function(){
    $('.prj'+this.id).toggle();
  });

  $('.bindExistingTasks').live('click',function(){
    bindExistTask($(this).attr('id'));
  });

  $('.hideT').live('click',function(){
    $('.hide'+this.id).toggle();
  });

  $('.hideT').live('click',function(){
    $('.hide'+this.id).toggle();
  });


  $('.addPersProgram').live('click',function(){
      var form_idx = $(this).attr('id');
      $('#tablePersProg').append($('#emptyPersProgram').html().replace(/__prefix__/g, form_idx));
      $(this).attr('id',parseInt(form_idx) + 1);
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

	$('.actFind').live('click',function(){
		$.get("/glass/actOfTransfer/actsForEq", {id : this.id},
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
	});

  $('.simplyAttach').live('click',function(){
    var sa=$(this);
    $.get("/glass/Files/CreateAjax", {},
            function(data, status) {
                if (status == "success") {
                    if(data.length>0){
                        sa.after(simplyWrap(data,'formFileAjax'));
                    }
                }else{
                    alert('Ошибка');
                }
            },"html"
        );
  });

  

  $('#file-ajax-submit-btn').live('click',function(){
    myAjaxSendData();
  });


  function myAjaxSendData() {
    var formData = new FormData($("#files-form-ajax")[0]);
    var fd=$('#files-form-ajax');
    $.ajax({
        url: "/glass/Files/CreateAjax",
        type: 'POST',
        data: formData,
        datatype:'json',
        success: function (data) {
            var data=$.parseJSON(data);
            var fta=fd.parents('.findTxArea');
            if(!!fta.attr('model')){
                fta.find('.simplyAttach').after('<div class="icowithdel"><div class="remove_this"></div><input type=hidden name='+fta.attr('model')+'[files][] value='+data.id+'>'+data.ico+'</div>');
            }else{
                fta.find('.simplyAttach').after(data.ico);
                fta.find('.putFileLink').val(function(i, text) {
                  return text + data.file;
                }); 
            }

            

            $('#formFileAjax').remove();
        },
        error: function (data) {
            alert("Ошибка загрузки");
            $('#formFileAjax').remove();
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
} 



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

function bindExistTask(id){
if(id){
    $.get("/glass/tasks/bindTasks", {id: id},
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

function simplyWrap(data,id){
  var res='<div class="window_awesom" id="'+id+'" style="position: absolute; left: -50px; top: -100px; min-width: 380px; font-size: 9pt; overflow: auto;"><div id="back" class="remove_this"></div><div>'+ data + '</div></div>';
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
  if (typeof updTape=='function')
    updTape();
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
  