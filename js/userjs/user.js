

function init(){
	$('#userEd').live('click',function(){ 
		load_modalForm();
	});

	$('.close_this').live('click',function(){ 
		$('.'+this.id).remove();
	});

	$("#EquipmentLog_details").live('keydown',function(e){
        if(e.keyCode==13){
        	tmp=$("#EquipmentLog_details").val();
        	$("#EquipmentLog_details").val(tmp+',');
        }
    });


	$('.mess_head').live('click',function(){
		$('.mess_body').toggle();
	});

	$('.showlog').live('click',function(){
		showLog(this.id);
	});
}


$(document).ready(init());

function showLog(id){
    if (id) {
        $.post("/glass/EquipmentLog/showLog", {id: id},
            function(data, status) {
                if (status == "success") {
                    $('html').append('<div class="back"><div class="window_awesom" style="position: fixed; width: 60%; min-height: 50px; top: 30%; margin-left: 20%; font-size: 9pt"><div id="back" class="close_this"></div>'+ data + '</div>');
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
			$('html').append('<div class="back"><div class="window_awesom" style="right: 5px; top: 5px;"><div id="back" class="close_this"></div>'+ data + '</div>');
		}
	},'html');
}
