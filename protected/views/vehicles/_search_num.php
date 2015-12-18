<?php
/* @var $this VehiclesController */
/* @var $model Vehicles */
/* @var $form CActiveForm */
?>

<div style="text-align: center;">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'post',
  'id'=>'searchNum',
)); ?>



 <?php echo CHtml::script("
     function split(val) {
      return val.split(/,\s*/);
     }
     function extractLast(term) {
      return split(term).pop();
     }
   ")?>
 <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
   'model'=>$model,
   'attribute'=>'number',
//'value' => $model->id,
   'source'=>"js:function(request, response) {
      $.getJSON('".$this->createUrl('searchNumber')."', {
        term: extractLast(request.term)
      }, response);
      }",
   'options'=>array(
     'delay'=>300,
     'minLength'=>2,
     'showAnim'=>'fold',
 'multiple'=>false,
     'select'=>"js:function(event, ui) {
         var terms = split(this.value);
         // remove the current input
         terms.pop();
         // add the selected item
         terms.push( ui.item.value );
         // add placeholder to get the comma-and-space at the end
         terms.push('');
         this.value = terms.join('');
         //vehiclesAccess(ui.item.value);
         $('#searchNum').submit();
         return false;
       }",
   ),
   'htmlOptions'=>array(
     'size'=>'8',
     'style'=>'font-size: 32px',
     'placeholder'=>'Номер авто.'

    ),

  ));
  // Для подсветки набираемого куска запроса в предлагаемом списке
  Yii::app()->clientScript->registerScript('unique.script.identifier', "
 $('#Vehicles_number').data('autocomplete')._renderItem = function( ul, item ) {
   var re = new RegExp( '(' + $.ui.autocomplete.escapeRegex(this.term) + ')', 'gi' );
   var highlightedResult = item.label.replace( re, '<b>$1</b>' );
   return $( '<li></li>' )
     .data( 'item.autocomplete', item )
     .append( '<a>' + highlightedResult + '</a>' )
     .appendTo( ul );
 };
");  
?>
<?php //echo CHtml::submitButton('Запрос',array('name'=>'find')); ?></td>
<?php $this->endWidget(); ?>

</div>

<div style="clear: both; height: 10px;"></div>