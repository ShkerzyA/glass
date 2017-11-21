
  <div class="row">
		<?php echo CHtml::label('Рабочее место',''); ?>
		<?php echo $form->hiddenField($model,'details[0]'); ?>

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
   'name'=>'Wp_details',
   'id'=>'Wpdetail',
   'value'=>$val,
//'value' => $model->id,
   'source'=>"js:function(request, response) {
      $.getJSON('".$this->createUrl('/workplace/suggest')."', {
        term: extractLast(request.term)
      }, response);
      }",
   'options'=>array(
     'delay'=>300,
     'minLength'=>1,
     'showAnim'=>'fold',
 	'multiple'=>false,
     'select'=>"js:function(event, ui) {
     	$('#Tasks_details_0').val(ui.item.id);
        sameTasks(ui.item.id,'wp');
         var terms = split(this.value);
         // remove the current input
         terms.pop();
         // add the selected item
         terms.push( ui.item.value );
         $('#Wp_details').attr('placeholder',ui.item.value);
         // add placeholder to get the comma-and-space at the end
         terms.push('');
         this.value = terms.join(' ');
         return false;
       }",
   ),
   'htmlOptions'=>array(
     'size'=>'40',
     'placeholder'=>$val
   ),
  ));
  // Для подсветки набираемого куска запроса в предлагаемом списке

/*
    Yii::app()->clientScript->registerScript('unique.script.identifier42', "
 $('#Wp_details').data('ui-autocomplete')._renderItem = function( ul, item ) {
   var re = new RegExp( '(' + $.ui.autocomplete.escapeRegex(this.term) + ')', 'gi' );
   var highlightedResult = item.label.replace( re, '<b>$1</b>' );
   return $( '<li></li>' )
     .data( 'ui-autocomplete-item', item )
     .append( '<a>' + highlightedResult + '</a>' )
     .appendTo( ul );
 };
");  */
?>

		<?php echo $form->error($model,'details'); ?>
	</div>
