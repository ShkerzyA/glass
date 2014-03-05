<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label='$model::$modelLabelP';
echo "\$this->breadcrumbs=array(
	$label=>array('index'),
	\$model->{$nameColumn},
);\n";


$model=new $this->model;
$rel=array();

foreach ($model->metaData->relations as $relations){
	$rel['search'][]=$relations->foreignKey;
	$rel[$relations->foreignKey]['name']=$relations->name;
    $rel[$relations->foreignKey]['className']=$relations->className;
    $rel[$relations->foreignKey]['foreignKey']=$relations->foreignKey;
} 

?>

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>'Вы уверены?')),
	array('label'=>'Управление', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);
?>

<h1>Отобразить "<?php echo "<?php"; ?>  echo $model::$modelLabelS; ?>" <?php echo " #<?php echo \$model->{$this->tableSchema->primaryKey}; ?>"; ?></h1> 

<?php echo "<?php"; ?> $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column)
	$rel['search']=(!empty($rel['search']))?$rel['search']:array();
	if (in_array($column->name,$rel['search'])){
		echo "array(               
            	'label'=>'{$rel[$column->name]['className']}',
            	'type'=>'raw',
            	'value'=>CHtml::link(CHtml::encode(\$model->{$rel[$column->name]['name']}->{$rel[$column->name]['foreignKey']}),
                array('{$rel[$column->name]['className']}/view','id'=>\$model->{$rel[$column->name]['name']}->id)),
        ),";
	}else{
		echo "\t\t'".$column->name."',\n";
	}
?>
	),
)); ?>
