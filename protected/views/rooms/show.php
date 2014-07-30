<div class=hide_p>
<?php
/* @var $this RoomsController */
/* @var $dataProvider CActiveDataProvider */
/*
$this->breadcrumbs=array(
	''.$modelLabelP,
); */
/*
$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create'),'visible'=>(Yii::app()->user->role=='administrator')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);*/


/*$rooms_list=array();
foreach ($models as $v){
	$rooms_list[]=array('label'=>$v->idCabinet->cname.' '.$v->idCabinet->num, 'url'=>array('Rooms/show/'.$v->id));
}*/

/*$this->menu['all_menu']=array(
	array('title'=>'Местоположение','items'=>$rooms_list),
)*/

?>
<script>
$(document).ready(init());

function init(){
	$('#date').live('change', function go(){
		location="?date="+$('#date').val();
	});

	$('#Room_id').live('change', function go(){
		location="?id="+$('#Room_id').val();
	});

	$('#Show_type').live('change', function go(){
		location="?Show_type="+$('#Show_type').val();
	});
}

</script>

<?php foreach ($this->events_menu as $x): ?>
	
	<?php if($this->mayShow($x['rule'])): ?>
	<a href=<?php echo(Yii::app()->request->baseUrl) ?>/rooms/show?Event_type=<?php echo $x['type'] ?>>
		<div class="inset2 <?php echo $cl_act=($x['type']==Yii::app()->session['Event_type'])?'active':''; ?>"><?php echo $x['name'] ?>
			<div class=downp></div>
		</div>
	</a>
	<?php endif; ?>
<?php endforeach; ?>
<br><br>
<br>
<div style="clear: both"></div>

<?php

switch (Yii::app()->session['Event_type']) {
		case 'events':
			$m='Events';
			break;
		case 'eventsOpPl':
		case 'eventsOpMon':
			$m='Eventsoper';
			break;
		
		default:
			$m='Events';
			break;
	}

if(!empty(Yii::app()->session['Rooms_date']) && !empty(Yii::app()->session['Rooms_id']) && Yii::app()->session['Event_type']!='eventsOpMon'){
	
	echo '<a href="/glass/'.$m.'/create?'.$m.'[date]='.Yii::app()->session['Rooms_date']->format('d.m.Y').' && '.$m.'[id_room]='.Yii::app()->session['Rooms_id'].'">
		<div id="add_task" class="add_unit fl_right">запланировать событие</div>
	</a>';
}



//if(!empty($roomsM))
if(!empty($roomsM)){
	foreach ($roomsM as $r) {
		$rooms[$r->id]=$r->idCabinet->cname.' '.$r->idCabinet->num;
	}
}else{
	$rooms=array();
}




echo'<div class="trinity_left">';
echo(CHtml::dropDownList('Room_id',$model->id,$rooms,array('empty'=>'Выберите помещение'))); 
echo'</div>';

echo'<div class="trinity_left">';
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'date',
   'attribute' => 'date_begin',
   'language' => 'ru',
   'value' => $val=(!empty(Yii::app()->session['Rooms_date'])?Yii::app()->session['Rooms_date']->format('d.m.Y'):''),
   'options' => array(
       'showAnim' => 'fold',
       'zIndex' => 50,
   ),
   'htmlOptions' => array(
       	'style' => 'height:20px;',
   		'placeholder'=>'дата события'
   ),
));
echo'</div>';

$type=array(
	'day'=>'День',
	'week'=>'Неделя'
	);



echo'<div class="trinity_left">';
echo(CHtml::dropDownList('Show_type',$val=(!empty(Yii::app()->session['Show_type'])?Yii::app()->session['Show_type']:''),$type,array('empty'=>''))); 
echo'</div>';



?>

<?php //echo ('<span style="font-size: 14pt">'.$model->idCabinet->cname.' '.$model->idCabinet->num.'</span>'); ?>

</div>
<br>
<br>
<div class="cornice">&nbsp;</div>

<?php
switch (Yii::app()->session['Show_type']) {
	case 'day':
		echo $this->renderPartial('/'.strtolower($m).'/_day', array('model'=>$model,'events'=>$events,'week'=>$week)); 
		break;
	case 'week':
		echo $this->renderPartial('/'.strtolower($m).'/_week', array('model'=>$model,'events'=>$events,'week'=>$week)); 
		break;

	default:
		# code...
		break;
}

?>

