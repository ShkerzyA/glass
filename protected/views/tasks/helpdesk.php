<script type="text/javascript">


function init(){
    /*setInterval(function(){
        updTasks();
    },20000);*/
}


$(document).ready(init());
function updateTasks(){
    $.get(location.href, {},
            function(data, status) {
                if (status == "success") {
                        $('#taskbody').empty();
                        $('#taskbody').append(data);
                    }else{
                    alert('Ошибка');
                }
            },"html"
    );
}

</script>
<?php
/* @var $this TasksController */
/* @var $model Tasks */
$date=(!empty($_GET['date']))?"&&date='".$_GET['date']."'":'';

if(!Yii::app()->user->isGuest)


$this->breadcrumbs=array(
);

$this->menu=array(
			array('label'=>'Персональный отчет', 'url'=>array('report?'.$date), 'linkOptions'=>array('target'=>'_blank'),'visible'=>Yii::app()->user->checkAccess('taskReport',array('mod'=>$model)),),
			array('label'=>'Отчет по отделу', 'url'=>array('reportOtd?'.$date), 'linkOptions'=>array('target'=>'_blank'),'visible'=>(Yii::app()->user->checkAccess('taskReport',array('mod'=>$model)))),
			array('label'=>'Отчет по сотрудникам отдела', 'url'=>array('reportOtd?personInfo=true'.$date), 'linkOptions'=>array('target'=>'_blank'),'visible'=>(Yii::app()->user->checkAccess('taskReport',array('mod'=>$model)))),
			);

$this->menu['all_menu']=array(
		array('title'=>'Фильтры задач','items'=>array(
			array('label'=>'Актуальные', 'url'=>array('HelpDesk?id_department='.$this->id_department.'&&group='.$this->group.'&&type=1')),
			array('label'=>'За сегодня', 'url'=>array('HelpDesk?id_department='.$this->id_department.'&&group='.$this->group.'&&type=3')),
			array('label'=>'[Мое]', 'url'=>array('HelpDesk?id_department='.$this->id_department.'&&group='.$this->group.'&&type=2')),
		)
	));
?>
<?php foreach ($this->tasks_menu as $x): ?>

	<?php if($this->mayShow($x['rule'])): ?>
	<a href=<?php echo(Yii::app()->request->baseUrl) ?>/tasks/helpDesk?id_department=<?php echo $x['id_department'] ?>&&group=<?php echo $x['group'] ?>>
		<div class="inset2 <?php echo $cl_act=($x['id_department']==$this->id_department&&$x['group']==$this->group)?'active':''; ?>"><?php echo $x['name'] ?>
			<div class=downp></div>
		</div>
	</a>
	<?php endif; ?>
<?php endforeach; ?>

<?php $this->renderPartial('addtask',array(
			'model'=>$model,
		)) ?>

<br><br><br>
<div id='taskbody'>
<?php $this->renderPartial('_helpdesk',array(
			'model'=>$model,
		)) ?>
</div>



