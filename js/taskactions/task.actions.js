function init(){
	$('.close_this').live('click',function(){ 
		$(this).parent("div").hide();
		$('.modal_window_back').hide();
	});

	$('#add_task_act').live('click',function(){ 
		$('.modal_window_back').show();
		$('.modal_window').show();
	});

    $('#put_message').live('click',function(){ 
        save_comment();
    });
}
document.ready(init());



function save_comment(){
	mess=$('#message').val();
    if (mess) {
        $.post("/glass/tasks/saveMessage", {mess: mess},
            function(data, status) {
                if (status == "success") {
                    alert(data);
                }else{
                	alert('Ошибка');
                }
            },"html"
        );
    }

}
