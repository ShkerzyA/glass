function init(){
	$('.close_this').live('click',function(){ 
		$(this).parent("div").hide();
		$('.modal_window_back').hide();
	});

	$('.act_button').live('click',function(){ 
		$('.modal_window_back#'+this.id+'').show();
		$('.modal_window#'+this.id+'').show();
	});

    $('.del_taskact').live('click',function(){ 
        if(confirm('А если подумать?')){
            var id=this.id;
            del_action('tasks',id);
        }
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

    $("#message_rep, #message_note").live('keydown',function(e){
        if(e.ctrlKey && e.keyCode==13){
            save_report();
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

function del_action(factoryObj,id){
     $.post("/glass/actions/delete", {id: id, factoryObj: factoryObj},
            function(data, status) {
                if (status == "success") {
                    $('.comment#'+id).remove();
                }else{
                    alert('Ошибка');
                }
            },"html"
    );
}


function save_report(){
    mess=$('#message_rep').val();
    note=$('#message_note').val();
    taskname=$('#taskname').val();
    taskstat=$('#taskstat').val();
    inv_cart=$('#inv_cart').val();
    inv_cart_old=$('#inv_cart_old').val();
    num_str=$('#num_str').val();
    id=$('#idmodel').val();
    factoryObj=$('#factoryObj').val();
    if (mess) {
        $.post("/glass/actions/saveReport", {id: id, factoryObj: factoryObj, mess: mess, note: note, taskstat: taskstat, taskname: taskname, inv_cart: inv_cart, inv_cart_old: inv_cart_old, num_str: num_str},
            function(data, status) {
                if (status == "success") {
                    //$('#message_rep').empty();
                    $('.modal_window_back').hide();
                    $('.modal_window').hide();
                    if(data=='cart_undefinded'){
                        alert('Устанавливаемый катрдидж с таким номером отсутствует на складе');
                    }else if(data=='old_cart_undefinded'){
                        alert('Возвращаемый катрдидж с таким номером отсутствует');
                    }else{
                        window.location.reload(); 
                    }
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
