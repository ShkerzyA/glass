function init(){
	$('.close_this').live('click',function(){ 
		$('.'+this.id).remove();
	});

	$('#add_group').live('click',function(){ 
		$('.modal2').remove();
		getAjax_groups();
	});

	$('#add_post').live('click',function(){ 
		$('.modal2').remove();
		getAjax_posts();
	});

	$('.join_group').live('click',function(){ 
		$('.'+this.id).remove();
		$('.multichoise').prepend('<div class="choise_unit '+this.id+'"><input type=hidden name="groups['+this.id+']" value='+this.id+'>'+this.getAttribute('text')+'<div id='+this.id+' class="close_this"></div></div>');
	});

	$('.join_post').live('click',function(){ 
		$('.'+this.id).remove();
		$('.multichoise').prepend('<div class="choise_unit '+this.id+'"><input type=hidden name="executors['+this.id+']" value='+this.id+'>'+this.getAttribute('text')+'<div id='+this.id+' class="close_this"></div></div>');
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
	$.post('/glass/DepartmentPosts/depposts',{id_department: dep},function(data,status){
		if(status=='success'){
			show_groups(data);
		}
	},'html');
}

function show_groups(data){
	coords=$('.add_unit').offset();
	
	$('.multichoise').append(data);
	$(".window_awesom").offset({top:coords.top+26, left:coords.left})
}

$(document).ready(init);
