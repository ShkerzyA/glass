	<div class="row">
		<?php echo $form->labelEx($model,'id_room'); ?>

		<?php $tmp=Rooms::model()->getRooms('eventsOpPl');
echo $form->dropDownList($model,"id_room",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->idCabinet->cname);}),array('empty' => '',)); ?>
		<?php echo $form->error($model,'id_room'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>

		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'date',
   'model' => $model,
   'attribute' => 'date',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
       'style' => 'height:20px;'
   ),
	));?>



		<?php echo $form->error($model,'date'); ?>
	</div>

	<table style="width: 97%;"> 
		<tr>
			<td>
	<div class="row">
		<?php echo $form->labelEx($model,'timestamp'); ?>

		<?php echo $form->textField($model,'timestamp',array('readonly'=>true)); ?>

		<?php echo $form->error($model,'timestamp'); ?>
	</div>
			</td>
			<td>
	<div class="row">
		<?php echo $form->labelEx($model,'timestamp_end'); ?>

		<?php echo $form->textField($model,'timestamp_end',array('readonly'=>true)); ?>

		<?php echo $form->error($model,'timestamp_end'); ?>
	</div>

			</td>
		</tr>
	</table>

	
	<?php 
	$evItervals=$model->freeDay(); 
	$this->renderPartial('_indicator_slider',array('evItervals'=>$evItervals),false,false); ?>
	<div id="slider" style="width: 93%;"></div>

	<div class="row">
		<?php echo $form->labelEx($model,'fio_pac'); ?>

		<?php echo $form->textField($model,'fio_pac',array('size'=>60,'maxlength'=>250)); ?>

		<?php echo $form->error($model,'fio_pac'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_gosp'); ?>

		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'date_gosp',
   'model' => $model,
   'attribute' => 'date_gosp',
   'language' => 'ru',
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
       'style' => 'height:20px;',
       'disabled' => true
   ),
	));?>

		<?php echo $form->error($model,'date_gosp'); ?>
	</div>


<!--
	<div class="row">

		<?php echo $form->labelEx($model,'creator'); ?>
		<?php echo Customfields::searchPersonnel($model,'creator'); ?>
		<?php echo $form->error($model,'creator'); ?>
	</div> -->

	<div class="row">
		<?php echo $form->labelEx($model,'operator'); ?>
		<?php echo Customfields::searchPersonnel($model,'operator'); ?>
		<?php echo $form->error($model,'operator'); ?>
	</div>



	<div class="row">
		<?php echo $form->labelEx($model,'scrub_nurse'); ?>

		<?php echo Customfields::searchPersonnel($model,'scrub_nurse'); ?>
		<?php echo $form->error($model,'scrub_nurse'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'brigade'); ?>

		<?php echo Customfields::multiPersonnel($model,'brigade'); ?>

		<?php echo $form->error($model,'brigade'); ?>
	</div>



	
	<div class="row">
		<?php echo $form->labelEx($model,'operation'); ?>
		<?php echo $form->hiddenField($model,'operation'); ?>

<?php echo CHtml::script("
     function split(val) {
      return val.split(/,\s*/);
     }
     function extractLast(term) {
      return split(term).pop();
     }
   ")?>
 <?php 


 	$nam_op=(!empty($model->operation))?$model->operation0->name:'';

 	//$this->widget('MyCJuiAutoComplete',array('model'=>$model,'attribute'=>'operation'));


 	$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
   'name'=>'operation_name',
   'value'=>$nam_op,
//'value' => $model->id,
   'source'=>"js:function(request, response) {
      $.getJSON('".$this->createUrl('suggest')."', {
        term: extractLast(request.term)
      }, response);
      }",
   'options'=>array(
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
   ),
   'htmlOptions'=>array(
   		'placeholder'=>'Поиск по названию',
     	'size'=>'40',
   ),
  ));
  // Для подсветки набираемого куска запроса в предлагаемом списке
  Yii::app()->clientScript->registerScript('unique.script.identifier', "
 $('#Eventsoper_operation').data('autocomplete')._renderItem = function( ul, item ) {
   var re = new RegExp( '(' + $.ui.autocomplete.escapeRegex(this.term) + ')', 'gi' );
   var highlightedResult = item.label.replace( re, '<b>$1</b>' );
   return $( '<li></li>' )
     .data( 'item.autocomplete', item )
     .append( '<a>' + highlightedResult + '</a>' )
     .appendTo( ul );
 };
");  
?>

		<?php echo $form->error($model,'operation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_operation'); ?>

		<?php echo $form->dropDownList($model,'type_operation',$model->getTypeOper(),
              array('empty' =>'')); ?>

		<?php echo $form->error($model,'type_operation'); ?>
	</div>