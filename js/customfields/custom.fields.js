var globalTimeout = null; 
var globid = null;
function init(){
	$('.close_this').live('click',function(){ 
		$('.'+this.id).remove();
	});

	$('.add_group').live('click',function(){ 
		$('.modal2').remove();
		getAjax_groups(this.id);
	});

	$('.add_post').live('click',function(){ 
		$('.modal2').remove();
		getAjax_posts();
	});

	$('.add_mark').live('click',function(){ 
		text=$(this).text();
		t_id=$('#target_id').val();
		$('#'+t_id).val(text);
		$('.back').remove();
		
	});

	$('.marksearch').live('click',function(){
		id=$(this).attr('id');
        if(globalTimeout != null) clearTimeout(globalTimeout);  
        globalTimeout =setTimeout(function(){ getAjax_markSearch(id) },100);  
    });

    $('.vehiclemarksearch').live('keyup',function(){
		id=$(this).attr('id');
        if(globalTimeout != null) clearTimeout(globalTimeout);  
        globalTimeout =setTimeout(function(){ getAjax_vehiclemarkSearch(id) },100);  
    });

	$('.add_person').live('click',function(){ 
		$('.modal2').remove();
		globid=this.id;
		getAjax_surnameSearch();
	});

	$('.add_shedule').live('click',function(){ 
		$('.modal2').remove();
		globid=this.id;
		getAjax_sheduleSearch();
	});

	$('.add_executors').live('click',function(){ 
		$('.modal2').remove();
		globid=this.id;
		getAjax_executors();
	});

	$('.add_oper').live('click',function(){ 
		$('.modal2').remove();
		globid=this.id;
		getAjax_operSearch();
	});

	$('.search_surname').live('keyup',function(){
        if(globalTimeout != null) clearTimeout(globalTimeout);  
        globid=this.id;
        globalTimeout =setTimeout(getAjax_surnameSearch,600);  
    });

    $('.search_oper').live('keyup',function(){
        if(globalTimeout != null) clearTimeout(globalTimeout);  
        globid=this.id;
        globalTimeout =setTimeout(getAjax_operSearch,1200);  
    });

	$('.join_group').live('click',function(){ 
		$('.'+this.id).remove();
		$('.multichoise#'+($(this).attr('f'))+'').append('<div class="choise_unit '+($(this).attr('f'))+this.id+'"><input type=hidden name='+this.getAttribute('field')+' value='+this.id+'>'+this.getAttribute('text')+'<div id='+($(this).attr('f'))+this.id+' class="close_this"></div></div>');
	});

	$('.join_post').live('click',function(){ 
		$('.'+this.id).remove();
		$('.multichoise').append('<div class="choise_unit '+this.id+'"><input type=hidden name="executors['+this.id+']" value='+this.id+'>'+this.getAttribute('text')+'<div id='+this.id+' class="close_this"></div></div>');
	});

	$('.join_personnel').live('click',function(){ 
		$('.'+($(this).attr('f'))+this.id).remove();
		$('.multichoise#'+($(this).attr('f'))+'').append('<div class="choise_unit '+($(this).attr('f'))+this.id+'"><input type=hidden name="'+$(this).attr('field')+'" value='+this.id+'>'+this.getAttribute('text')+'<div id='+($(this).attr('f'))+this.id+' class="close_this"></div></div>');
	});

	$('.replace_personnel').live('click',function(){ 
		$('.multichoise#'+($(this).attr('f'))+' .choise_unit').remove();
		$('.multichoise#'+($(this).attr('f'))+'').append('<div class="choise_unit '+($(this).attr('f'))+this.id+'"><input type=hidden name="'+$(this).attr('field')+'" value='+this.id+'>'+this.getAttribute('text')+'<div id='+($(this).attr('f'))+this.id+' class="close_this"></div></div>');
	});


	$('#Eventsoper_id_room,#date').live('change',function(){ 
		getAjax_freeday();
	});
}

function getAjax_freeday(){
	var id_room=$('#Eventsoper_id_room').val();
	var date=$('#date').val();

	if(!id_room || !date){
		return false;
	}

	$.post('/glass/Eventsoper/freeDay',{'Eventsoper[id_room]': id_room, 'Eventsoper[date]': date,},function(data,status){
		if(status=='success'){
			$('.indicator_slider').replaceWith(data);
		}
	},'html');
}


/*
function getAjax_groups(){
	var model=$('.modelN#groups').val()
	$.post('/glass/PostsGroups/allgroups?mn='+model,{},function(data,status){
		if(status=='success'){
			show_groups(data);
		}
	},'html');
}*/

function getAjax_groups(id){
	var field=$('.field#'+id+'').val();
	var modelN=$('.modelN#'+id+'').val();
	//alert(search);
	$.get('/glass/PostsGroups/allgroups',{mn: modelN, field: field},function(data,status){
		if(status=='success'){
			show_groups(data);
		}
	},'html');
}



function getAjax_posts(){
	var dep=$('#id_dep').val();
	$.post('/glass/Personnel/depposts',{id_department: dep},function(data,status){
		if(status=='success'){
			show_groups(data);
		}
	},'html');
}

function getAjax_surnameSearch(){
	var id=globid;
	var field=$('.field#'+id+'').val();
	var modelN=$('.modelN#'+id+'').val();
	var search=$('.search_surname#'+id+'').val();
	var action=$('.action#'+id+'').val();
	//alert(search);
	$.post('/glass/Personnel/surnameSearch',{search: search, field: field, modelN: modelN, action: action},function(data,status){
		if(status=='success'){
			show_res(data,'search_surname');
		}
	},'html');
}

function getAjax_sheduleSearch(){
	var id=globid;
	var field=$('.field#'+id+'').val();
	var modelN=$('.modelN#'+id+'').val();
	var search=$('.search_shedule#'+id+'').val();
	var action=$('.action#'+id+'').val();
	//alert(search);
	$.post('/glass/VehicleShedule/sheduleSearch',{search: search, field: field, modelN: modelN, action: action},function(data,status){
		if(status=='success'){
			show_res(data,'search_shedule');
		}
	},'html');
}

function getAjax_executors(){
	var id=globid;
	
	var modelN=$('.modelN#'+id+'').val();

	switch (modelN) {
	   case 'Tasks':
	      var project=$('#Tasks_project').val();
	      break;
	   case 'Projects':
	      var project=$('#Projects_id').val();
	      break;
	}


	//alert(search);
	$.get('/glass/Projects/projectGroupMembers',{id: project, modelN: modelN},function(data,status){
		if(status=='success'){
			show_res(data,'search_surname');
		}
	},'html');
}


function getAjax_operSearch(){
	var id=globid;
	var field=$('.field#'+id+'').val();
	var modelN=$('.modelN#'+id+'').val();
	var search=$('.search_oper#'+id+'').val();
	var action=$('.action#'+id+'').val();
	//alert(search);
	$.get('/glass/Eventsoper/operSearch',{search: search, field: field, modelN: modelN, action: action},function(data,status){
		if(status=='success'){
			show_res(data,'search_oper');
		}
	},'html');
}

function getAjax_markSearch(id){
	id_s=id.replace("mark", ""); 
	type=$('#'+id_s+'type').val();
	producer=$('#'+id_s+'producer').val();
	if(type.length){
		$.post('/glass/Equipment/markSearch',{type: type, producer: producer},function(data,status){
			if(status=='success'){
				show_under(id,data);
			}
		},'html');	
	}
}


function getAjax_vehiclemarkSearch(id){
	val=$('#'+id).val();
	if(val.length>2){
		$.post('/glass/Vehicles/markSearch',{val: val},function(data,status){
			if(status=='success'){
				show_under(id,data);
			}
		},'html');	
	}
}



function show_res(data,search){
	var id=globid;
	$('.back').remove();
	coords=$('.add_unit#'+id+'').offset();
	$('html').append(data);
	var v = $('.'+search).val();
    $('.'+search).focus().val("").val(v);
	$(".window_awesom").offset({top:coords.top+26, left:coords.left})
}

function show_groups(data){
	$('.back').remove();
	coords=$('.add_unit').offset();
	
	$('html').append(data);
	$(".window_awesom").offset({top:coords.top+26, left:coords.left})
}

function show_under(id,data){

	coords=$('#'+id).offset();
	
	$('html').append(data);
	$('.window_awesom').append('<input type=hidden id=target_id name=target_id value="'+id+'">');
	$(".window_awesom").offset({top:coords.top+26, left:coords.left})
}


$(document).ready(init);
