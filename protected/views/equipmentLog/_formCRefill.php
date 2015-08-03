<?php
/* @var $this EquipmentLogController */
/* @var $model EquipmentLog */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'equipment-log-form',
	'enableAjaxValidation'=>false,
)); ?>
  
  
  <?php echo '<h1>'.$model->getType()['name'].'</h1>'; ?>


	<?php echo $form->errorSummary($model); ?>

	<div class="row">

		<?php echo $form->hiddenField($model,'type'); ?>

	</div>


		<div class="row">
		<?php echo CHtml::label('Картриджи',''); ?>
    <?php echo $form->textArea($model,'details',array('placeholder'=>'Инвентарные номера (след. элемент по enter)','onkeydown'=>'if(event.keyCode == 13){ return false;}')); ?>

<!--
<?php echo CHtml::script("
     function split(val) {
      return val.split(/,\s*/);
     }
     function extractLast(term) {
      return split(term).pop();
     }
   ")?>
 <?php
    Yii::import('zii.widgets.jui.CJuiAutoComplete');
    $this->widget('application.widgets.CJuiAutoCompleteTextArea', array(
   'name'=>'EquipmentLog_details',
   'value'=>'',
//'value' => $model->id,
   'source'=>"js:function(request, response) {
      $.getJSON('".$this->createUrl('Equipment/cartSearch')."', {
        term: extractLast(request.term)
      }, response);
      }",
   'options'=>array(
     'delay'=>300,
     'minLength'=>1,
     'showAnim'=>'fold',
 	'multiple'=>1,
     'select'=>"js:function(event, ui) {
      tval=$('#EquipmentLog_details').val();
      alert(tval);
     	$('#EquipmentLog_details').val(ui.item.id);
         var terms = split(this.value);
         // remove the current input
         terms.pop();
         // add the selected item
         terms.push( ui.item.value );
         // add placeholder to get the comma-and-space at the end
         terms.push('');
         this.value = terms.join(',');
         return false;
       }",
   ),
   'htmlOptions'=>array(
     'size'=>'40',
     'placeholder'=>'Поиск по инвентарному'
   ),
  ));
  // Для подсветки набираемого куска запроса в предлагаемом списке
  Yii::app()->clientScript->registerScript('unique.script.identifier', "
 $('#EquipmentLog_details').data('autocomplete')._renderItem = function( ul, item ) {
   var re = new RegExp( '(' + $.ui.autocomplete.escapeRegex(this.term) + ')', 'gi' );
   var highlightedResult = item.label.replace( re, '<b>$1</b>' );
   return $( '<li></li>' )
     .data( 'item.autocomplete', item )
     .append( '<a>' + highlightedResult + '</a>' )
     .appendTo( ul );
 };
");  
?>
<?php $this->endWidget(); ?>
-->
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>




</div><!-- form -->