<?php
/* @var $this EventsoperController */
/* @var $model Eventsoper */
/* @var $form CActiveForm */
Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
Yii::app()->getClientScript()->registerCssFile(Yii::app()
    ->getClientScript()
    ->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css' );

?>
<script>

$(document).ready(init);

function init(){

	//$('#Events_timestamp').val()
	//$('#Events_timestamp_end').val()
	var x=$('#Eventsoper_timestamp').val();
	var y=$('#Eventsoper_timestamp_end').val();

	if(x){
		x=x.split(":");
		var begin=(x[0]*60)+(x[1]*1);
	}else{
		var begin=600;
	}
	if(y){
		y=y.split(":");
		var end=(y[0]*60)+(y[1]*1);
	}else{
		var end=800;
	}
	

	$("#slider").slider({values:[begin,end],
   min:480,
   max:1020,
   range:true,
   step:15,
   slide:function(event,ui){
   		var z0 = ui.values[0]/60;
		var x0 = parseInt(z0); //Целая часть
		if(x0<10)
			x0='0'+x0;
		var y0 = (z0 - x0)*60;
		if(y0<10)
			y0='0'+y0;
		var z1 = ui.values[1]/60;
		var x1 = parseInt(z1); //Целая часть
		if(x1<10){
			x1='0'+x1;
		}
		var y1 = (z1 - x1)*60;
		if(y1<10){
			y1='0'+y1;
		}
			

      $("#Eventsoper_timestamp").val(x0+':'+y0);
      $("#Eventsoper_timestamp_end").val(x1+':'+y1);
   }});
}

</script>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'eventsoper-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>


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
       'style' => 'height:20px;'
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
		<?php echo $form->labelEx($model,'anesthesiologist'); ?>

		<?php echo Customfields::searchPersonnel($model,'anesthesiologist'); ?>
		<?php echo $form->error($model,'anesthesiologist'); ?>
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

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->