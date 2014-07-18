function init(){
	$('.close_this').live('click',function(){ 
		$(this).parent("div").hide();
		$('.modal_window_back').hide();
	});

	$('.act_button').live('click',function(){ 
		$('.modal_window_back#'+this.id+'').show();
		$('.modal_window#'+this.id+'').show();
	});

    $('#put_message').live('click',function(){ 
        save_comment();
    });

    $('#put_report').live('click',function(){ 
        save_report();
    });

    $("#message").live('keydown',function(e){
        if(e.ctrlKey && e.keyCode==13){
            save_comment();
        }
    });

    $('#status').live('change',function(){
        change_status();
    });
}
document.ready(init());



function save_comment(){
	mess=$('#message').val();
    id=$('#idmodel').val();
    factoryObj=$('#factoryObj').val();
    if (mess) {
        $.post("/glass/actions/saveMessage", {id: id, factoryObj: factoryObj, mess: mess},
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


function save_report(){
    mess=$('#message_rep').val();
    note=$('#message_note').val();
    taskname=$('#taskname').val();
    taskstat=$('#taskstat').val();
    id=$('#idmodel').val();
    factoryObj=$('#factoryObj').val();
    if (mess) {
        $.post("/glass/actions/saveReport", {id: id, factoryObj: factoryObj, mess: mess, note: note, taskstat: taskstat, taskname: taskname},
            function(data, status) {
                if (status == "success") {
                    $('#message_rep').empty();
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
    stat=$('#status').val();
    id=$('#idmodel').val();
    factoryObj=$('#factoryObj').val();

    if (stat) {
        $.post("/glass/actions/saveStatus", {id: id, factoryObj: factoryObj ,stat: stat},
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
