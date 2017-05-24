
<div style="position: fixed; left: 3px; top: 55px; z-index: 99">

<?php echo CHtml::script("
     function split(val) {
      return val.split(/,\s*/);
     }
     function extractLast(term) {
      return split(term).pop();
     }
   ")?>
 <?php 

    $val=(!empty($model->details[0]))?$model->detailsShow():'';

    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
   'name'=>'global_search',
   'value'=>$val,
   'source'=>"js:function(request, response) {
      $.getJSON('".$this->controller->createUrl('/actions/globalSearch')."', {
        term: extractLast(request.term)
      }, response);
      }",
   'options'=>array(
     'delay'=>300,
     'minLength'=>1,
     'showAnim'=>'fold',
 	'multiple'=>false,
     'select'=>"js:function(event, ui) {
         var terms = split(this.value);
         // remove the current input
         terms.pop();
         // add the selected item
         //terms.push( ui.item.value );
         //$('#global_search').attr('placeholder',ui.item.value);
         // add placeholder to get the comma-and-space at the end
         terms.push('');
         this.value = terms.join(' ');
         return false;
       }",
   ),
   'htmlOptions'=>array(
     'size'=>'13',
     'placeholder'=>'Быстрый переход'
   ),
  ));



  // Для подсветки набираемого куска запроса в предлагаемом списке
  Yii::app()->clientScript->registerScript('unique.script.identifier2', "
 $('#global_search').data('ui-autocomplete')._renderItem = function( ul, item ) {
   var re = new RegExp( '(' + $.ui.autocomplete.escapeRegex(this.term) + ')', 'gi' );
   var highlightedResult = item.label.replace( re, '<b>$1</b>' );
   return $( '<li></li>' )
     .data( 'ui-autocomplete-item', item )
     .append( '<a>' + highlightedResult + '</a>' )
     .appendTo( ul );
 };
");  
?>


	</div>
