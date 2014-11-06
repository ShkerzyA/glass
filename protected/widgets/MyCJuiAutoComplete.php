<?php

class MyCJuiAutoComplete extends CJuiAutoComplete{
   public $source= "js:function(request, response) { $.getJSON('Eventsoper/suggest', { term: extractLast(request.term)  }, response);  }";

   public $options=array(
     'delay'=>300,
     'minLength'=>2,
     'showAnim'=>'fold',
 	'multiple'=>false,
     'select'=>"js:function(event, ui) {
     	$('#operation_name').add
     	$('#Eventsoper_operation').val(ui.item.id);
         var terms = split(this.value);
         // remove the current input
         terms.pop();
         // add the selected item
         terms.push( ui.item.value );
         // add placeholder to get the comma-and-space at the end
         terms.push('');
         this.value = terms.join(' ');
         return false;
       }",
   );
   public $htmlOptions=array(
   		'placeholder'=>'Поиск по названию',
     	'size'=>'40',
   );

}
	?>