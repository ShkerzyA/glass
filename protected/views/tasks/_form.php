<?php
/* @var $this TasksController */
/* @var $model Tasks */
/* @var $form CActiveForm */
?>
<?php
/* @var $this EventsoperController */
/* @var $model Eventsoper */
/* @var $form CActiveForm */
Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
Yii::app()->getClientScript()->registerCssFile(Yii::app()
    ->getClientScript()
    ->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css' );

?>
<script type="text/javascript">

function init(){
  $("#tasks-form > *").live('keydown',function(e){
        if(e.ctrlKey && e.keyCode==13){
            $("#tasks-form").submit();

        }
    });
}
document.ready(init());

</script>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tasks-form',
	'enableAjaxValidation'=>false,
)); 
?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить',array('id'=>'Taskssubmit')); ?>
	</div>

	<?php if(Yii::app()->user->isGuest): ?>

		<script>
		function init(){
			$('#Taskssubmit').attr('disabled','disabled');
			$('#phone, #fio').live('change', function(){
				var fio=$('#fio').val();
				var phone=$('#phone').val();
				if((fio.length>0) && (phone.length>0)){
					$('#Taskssubmit').removeAttr('disabled');
				}else{
					$('#Taskssubmit').attr('disabled','disabled');
				}
			});
		}

		$(document).ready(init);

		</script>
<?php echo CHtml::script("
     function split(val) {
      return val.split(/,\s*/);
     }
     function extractLast(term) {
      return split(term).pop();
     }
   ")?>

   <div style="clear: both; width: 94%;">
		<div style="width: 50%; float: left;"> 
 <?php 
 	$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
   'name'=>'fio',
   'value'=>NULL,
//'value' => $model->id,
   'source'=>"js:function(request, response) {
      $.getJSON('".$this->createUrl('/Personnel/suggest')."', {
        term: extractLast(request.term)
      }, response);
      }",
   'options'=>array(
     'delay'=>300,
     'minLength'=>2,
     'showAnim'=>'fold',
 	'multiple'=>false,
     'select'=>"js:function(event, ui) {
     	$('#fio').val(ui.item.id);
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
     'size'=>'40',
     'placeholder'=>'ФИО'
   ),
  ));
  // Для подсветки набираемого куска запроса в предлагаемом списке
  Yii::app()->clientScript->registerScript('unique.script.identifier', "
 $('#fio').data('autocomplete')._renderItem = function( ul, item ) {
   var re = new RegExp( '(' + $.ui.autocomplete.escapeRegex(this.term) + ')', 'gi' );
   var highlightedResult = item.label.replace( re, '<b>$1</b>' );
   return $( '<li></li>' )
     .data( 'item.autocomplete', item )
     .append( '<a>' + highlightedResult + '</a>' )
     .appendTo( ul );
 };
");  
?>
		</div>
		<div style="width: 50%; float: left;"> <?php echo CHtml::textField('phone',NULL,array('placeholder'=>'Номер телефона')); ?></div>
	</div>

	<?php endif ?>

	

	<input type=hidden name=id_dep id=id_dep value="<?php echo $model->id_department ?>">
	<div class="row">
		<?php echo $form->labelEx($model,'tname'); ?>

		<?php echo $form->textField($model,'tname',array('size'=>60,'maxlength'=>60)); ?>

		<?php echo $form->error($model,'tname'); ?>
	</div>

<?php switch($model->type): ?>
<?php case '1': ?>
	<div class="row">
		<?php echo CHtml::label('Принтер',''); ?>
		<?php echo $form->hiddenField($model,'details'); ?>

<?php echo CHtml::script("
     function split(val) {
      return val.split(/,\s*/);
     }
     function extractLast(term) {
      return split(term).pop();
     }
   ")?>
 <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
   'name'=>'Printer_details',
   'value'=>'',
//'value' => $model->id,
   'source'=>"js:function(request, response) {
      $.getJSON('".$this->createUrl('suggest')."', {
        term: extractLast(request.term)
      }, response);
      }",
   'options'=>array(
     'delay'=>300,
     'minLength'=>1,
     'showAnim'=>'fold',
 	'multiple'=>false,
     'select'=>"js:function(event, ui) {
     	$('#Tasks_details').val(ui.item.id);
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
     'size'=>'40',
   ),
  ));
  // Для подсветки набираемого куска запроса в предлагаемом списке
  Yii::app()->clientScript->registerScript('unique.script.identifier', "
 $('#Printer_details').data('autocomplete')._renderItem = function( ul, item ) {
   var re = new RegExp( '(' + $.ui.autocomplete.escapeRegex(this.term) + ')', 'gi' );
   var highlightedResult = item.label.replace( re, '<b>$1</b>' );
   return $( '<li></li>' )
     .data( 'item.autocomplete', item )
     .append( '<a>' + highlightedResult + '</a>' )
     .appendTo( ul );
 };
");  
?>

		<?php echo $form->error($model,'details'); ?>
	</div>
<?php break;?>
<?php endswitch;?>



	<div class="row">
		<?php echo $form->labelEx($model,'ttext'); ?>

		<?php echo $form->textArea($model,'ttext',array('rows'=>6, 'cols'=>50)); ?>

		<?php echo $form->error($model,'ttext'); ?>
	</div>


<?php if((Yii::app()->user->role=='administrator') and ($model->scenario!='insert')): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'timestamp'); ?>

		<?php echo $form->textField($model,'timestamp'); ?>

		<?php echo $form->error($model,'timestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timestamp_end'); ?>

		<?php echo $form->textField($model,'timestamp_end'); ?>

		<?php echo $form->error($model,'timestamp_end'); ?>
	</div>





	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>

		<?php //echo $form->textField($model,'status'); ?>


		<?php echo $form->dropDownList($model,'status',$model->getStatus(),
              array('empty' => '')); ?>

		<?php echo $form->error($model,'status'); ?>
	</div>

<?php endif; ?>

<?php if($model->scenario!='insert'):?>
	<div class="row">
		<?php echo $form->labelEx($model,'id_department'); ?>

		<?php $tmp=Department::model()->working()->findall();
		echo $form->dropDownList($model,"id_department",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->name);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'id_department'); ?>
	</div>
<?php endif; ?>

<?php if($model->scenario!='insert'):?>
	<div class="row">
		<?php echo $form->labelEx($model,'creator'); ?>

		<?php $tmp=Personnel::model()->working()->findall();
echo $form->dropDownList($model,"creator",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->surname.' '.$tmp->name);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'creator'); ?>
	</div>
<?php endif; ?>
<?php if($model->scenario!='insert'):?>
	<div class="row">
		<?php echo $form->labelEx($model,'group'); ?>

		<?php $tmp=PostsGroups::model()->findall();
echo $form->dropDownList($model,"group",CHtml::listData($tmp,"group_key",function($tmp) {
				return CHtml::encode($tmp->group_name);}),array('empty' => '')); ?>
		<?php echo $form->error($model,'group'); ?>
	</div>
<?php else: ?>
	<?php echo $form->hiddenField($model,'group'); ?>
<?php endif; ?>

 <!--
	<div class="row">
		<?php //echo $form->labelEx($model,'executor'); ?>

		<?php
		//$tmp=DepartmentPosts::model()->working()->with("postSubdivRn")->findall(array('condition'=>'"postSubdivRn".id='.$model->id_department));
//echo $form->dropDownList($model,"executor",CHtml::listData($tmp,"id",function($tmp) {
				//return CHtml::encode($tmp->personnelPostsHistories[0]->idPersonnel->surname.' '.$tmp->personnelPostsHistories[0]->idPersonnel->name);}),array('empty' => '')); ?>
		<?php //echo $form->error($model,'executor'); ?>
	</div> -->

	<div class="row">
		<?php echo $form->labelEx($model,'executors'); ?>
		<?php echo Customfields::multiPersonnel($model,'executors'); ?>
		<?php echo $form->error($model,'executors'); ?>
	</div>

	

<?php $this->endWidget(); ?>

</div><!-- form -->