var globalTimeout = null; 
var globid = null;
function init(){
	$('.close_this').live('click',function(){ 
		$('.'+this.id).remove();
	});

	$('#add_group').live('click',function(){ 
		$('.modal2').remove();
		getAjax_groups();
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

	$('.add_unit').live('click',function(){ 
		$('.modal2').remove();
		globid=this.id;
		getAjax_surnameSearch();
	});

	$('.search_surname').live('keyup',function(){
        if(globalTimeout != null) clearTimeout(globalTimeout);  
        globid=this.id;
        globalTimeout =setTimeout(getAjax_surnameSearch,600);  
    });

	$('.join_group').live('click',function(){ 
		$('.'+this.id).remove();
		$('.multichoise').prepend('<div class="choise_unit '+this.id+'"><input type=hidden name="groups['+this.id+']" value='+this.id+'>'+this.getAttribute('text')+'<div id='+this.id+' class="close_this"></div></div>');
	});

	$('.join_post').live('click',function(){ 
		$('.'+this.id).remove();
		$('.multichoise').prepend('<div class="choise_unit '+this.id+'"><input type=hidden name="executors['+this.id+']" value='+this.id+'>'+this.getAttribute('text')+'<div id='+this.id+' class="close_this"></div></div>');
	});

	$('.join_personnel').live('click',function(){ 
		$('.'+this.id).remove();
		$('.multichoise#'+($(this).attr('f'))+'').prepend('<div class="choise_unit '+($(this).attr('f'))+this.id+'"><input type=hidden name="'+$(this).attr('field')+'['+this.id+']" value='+this.id+'>'+this.getAttribute('text')+'<div id='+($(this).attr('f'))+this.id+' class="close_this"></div></div>');
	});

	$('.replace_personnel').live('click',function(){ 
		$('.multichoise#'+($(this).attr('f'))+' .choise_unit').remove();
		$('.multichoise#'+($(this).attr('f'))+'').prepend('<div class="choise_unit '+($(this).attr('f'))+this.id+'"><input type=hidden name="'+$(this).attr('field')+'" value='+this.id+'>'+this.getAttribute('text')+'<div id='+($(this).attr('f'))+this.id+' class="close_this"></div></div>');
	});
}

function getAjax_groups(){
	$.post('/glass/PostsGroups/allgroups',{},function(data,status){
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
	//alert(search);
	$.post('/glass/Personnel/surnameSearch',{search: search, field: field, modelN: modelN},function(data,status){
		if(status=='success'){
			show_users(data);
		}
	},'html');
}

function getAjax_markSearch(id){
	id_s=id.replace("mark", ""); 
	type=$('#'+id_s+'type').val();
	producer=$('#'+id_s+'producer').val();
	if(type.length && producer.length){
		$.post('/glass/Equipment/markSearch',{type: type, producer: producer},function(data,status){
			if(status=='success'){
				show_under(id,data);
			}
		},'html');	
	}
	
}

function show_users(data){
	var id=globid;
	$('.back').remove();
	coords=$('.add_unit#'+id+'').offset();
	
	$('html').append(data);
	$(".window_awesom").offset({top:coords.top+26, left:coords.left})
}

function show_groups(data){
	$('.back').remove();
	coords=$('#add_group').offset();
	
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
