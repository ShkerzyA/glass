<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	''.$model::$modelLabelP,
);

$this->menu=array(
	array('label'=>'Главная', 'url'=>array('tree')),
	array('label'=>'Отделы из MU.dbf', 'url'=>array('mudbf')),
);
?>

<h1>Структура из MU.fdb</h1>

<?php 

/*	
$x=1;
 foreach ($result as $v) {
 	echo '<br>'.$x.' '.$v['MU'];
 	$x++;
 } */

 $result['mu'];
 $result['mu0'];

$root=array('ID_MU0'=>'1712','IDMU'=>'60','IDPARENT'=>'');

$lvl='';
 function getTree($item,$result){
 		echo '<div style="border-left: 2px solid black; border-bottom: 2px solid black; margin: 10px; margin-left: 30px;">'.$result['mu'][$item['IDMU']]['MU'].'<br>';
 		$child=array_filter($result['mu0'], function($var) use ($item){return ($var['IDPARENT']==$item['ID_MU0']);});
 		//print_r($child);
 		if(!empty($child)){
 			foreach ($child as $v) {
 				getTree($v,$result);
 			}
 		}
 		echo'</div>';
 }

 getTree($root,$result);



?>
