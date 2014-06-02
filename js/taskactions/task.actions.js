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

    $("#message").live('keydown',function(e){
        if(e.ctrlKey && e.keyCode==13){
            save_comment();
        }
    });

    $('#status_task').live('change',function(){
        change_status();
    });
}
document.ready(init());



function save_comment(){
	mess=$('#message').val();
    id=$('#idmodel').val();
    if (mess) {
        $.post("/glass/tasks/saveMessage/"+id, {mess: mess},
            function(data, status) {
                if (status == "success") {
                    $('#message').empty();
                    $('.modal_window_back').hide();
                    $('.modal_window').hide();
                    window.location.reload();
                }else{
                	alert('Ошибка');
                }
            },"html"
        );
    }

}


function change_status(){
    stat=$('#status_task').val();
    id=$('#idmodel').val();
    if (stat) {
        $.post("/glass/tasks/saveStatus/"+id, {stat: stat},
            function(data, status) {
                if (status == "success") {
                    window.location.reload();
                }else{
                    alert('Ошибка');
                }
            },"html"
        );
    }

}
