<?php
/* @var $this RoomsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	''.$modelLabelP,
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create'),'visible'=>(Yii::app()->user->role=='administrator')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);


$rooms_list=array();
foreach ($models as $v){
	$rooms_list[]=array('label'=>$v->idCabinet->cname, 'url'=>array('Rooms/show/'.$v->id));
}

$this->menu['all_menu']=array(
	array('title'=>'Местоположение','items'=>$rooms_list),
)

?>
<script>
$(document).ready(init());

function init(){
	$('#date').live('change', function go(){
		location="?date="+$('#date').val();
	});
}

</script>

<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   'name' => 'date',
   'model' => $event,
   'attribute' => 'date_begin',
   'language' => 'ru',
   'value' => $val=(!empty(Yii::app()->session['Rooms_date'])?Yii::app()->session['Rooms_date']->format('d.m.Y'):''),
   'options' => array(
       'showAnim' => 'fold',
   ),
   'htmlOptions' => array(
       'style' => 'height:20px;',
   		'placeholder'=>'дата события'
   ),
));?>

<?php
if(!empty(Yii::app()->session['Rooms_date']) && !empty(Yii::app()->session['Rooms_id'])){
	echo '<a href="/glass/events/create?Events[date]='.Yii::app()->session['Rooms_date']->format('d.m.Y').' && Events[id_room]='.Yii::app()->session['Rooms_id'].'">
		<div id="add_task" class="add_unit fl_right">запланировать событие</div>
	</a>';
}


?>

<?php echo ('<span style="font-size: 14pt">'.$model->idCabinet->cname.' '.$model->idCabinet->num.'</span>'); ?>



<div class=day>
 <div>08:00</div>
 <div>09:00</div>
 <div>10:00</div>
 <div>11:00</div>
 <div>12:00</div>
 <div>13:00</div>
 <div>14:00</div>
 <div>15:00</div>
 <div>16:00</div>
 <div>17:00</div>



</div>

<div class=day_event>
	<?php
		foreach ($events as $v){

			$time1=explode(':', $v->timestamp);
			$time2=explode(':', $v->timestamp_end);

			$x1=($time1[0]*60+$time1[1]);
			$x2=($time2[0]*60+$time2[1]);

			$top=($x1-480)*1.5;
			$height=($x2-$x1)*1.5;

			$status=$v->gimmeStatus();
			echo'<a href='.Yii::app()->request->baseUrl.'/events/'.$v->id.'>';
			echo '<div class="event '.$status['css_class'].'" style="top: '.$top.'px; height: '.$height.'px">';
				echo '<p>'.$v->name.'</p>';
				//echo '<div class=corps>'.$v->description.'</div>';
				echo '<div class=status>'.$status['label'].'</div>';
				echo '<div class=time>'.$v->timestamp.' - '.$v->timestamp_end.'</div>';
				echo '<div class=creator>'.$v->creator0->personnelPostsHistories[0]->idPersonnel->surname.' '.$v->creator0->personnelPostsHistories[0]->idPersonnel->name.' '.$v->creator0->personnelPostsHistories[0]->idPersonnel->patr.'</div>';
			echo '</div></a>';
		}
	?>
</div>

