<?php

$projects=Projects::myProjects();
$projectsArr=array();
foreach ($projects as $pr) {
	$projectsArr[]=array('label'=>'<nobr>'.$pr->ico(True).' '.$pr->name.'</nobr>','url'=>array('tasks/create?Tasks[type]='.$pr->getType().'&&Tasks[project]='.$pr->id.'&&Tasks[bindTasks][]='.$model->id.''));
}




$this->beginWidget('zii.widgets.CPortlet', array(
					'title'=>'Связать задачи',
				));

$this->widget('zii.widgets.CMenu', array(
        'items'=>$projectsArr,
        'encodeLabel'=>false,
        'htmlOptions'=>array('class'=>'operations'),
      ));

$this->widget('zii.widgets.jui.CJuiAccordion',array(
    'panels'=>array(
        'Связать задачи'=>'sdfsdfsdfsdf',
        'Связать задачи1'=>'sdfsdfsdfsdf',
        'Связать задачи2'=>'sdfsdfsdfsdf',
        'Связать задачи3'=>'sdfsdfsdfsdf'
    ),
    // additional javascript options for the accordion plugin
    'options'=>array(
        'animate'=>'bounceslide',
    ),
));

echo CHtml::script("
     function split(val) {
      return val.split(/,\s*/);
     }
     function extractLast(term) {
      return split(term).pop();
     }
   ");

    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
   'name'=>'bindExTask',
   'value'=>'',
   'source'=>"js:function(request, response) {
      $.getJSON('".$this->createUrl('/actions/tasksBind')."', {
        term: extractLast(request.term)
      }, response);
      }",
   'options'=>array(
     'delay'=>100,
     'minLength'=>0,
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
     'placeholder'=>'Поиск существующих'
   ),
  ));



  // Для подсветки набираемого куска запроса в предлагаемом списке
  Yii::app()->clientScript->registerScript('unique.script.identifier3', "
 $('#bindExTask').data('ui-autocomplete')._renderItem = function( ul, item ) {
   var re = new RegExp( '(' + $.ui.autocomplete.escapeRegex(this.term) + ')', 'gi' );
   var highlightedResult = item.label.replace( re, '<b>$1</b>' );
   return $( '<li></li>' )
     .data( 'ui-autocomplete-item', item )
     .append( '<a>' + highlightedResult + '</a>' )
     .appendTo( ul );
 };
");  



$this->endWidget();






?>
