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
$label='$model::$modelLabelP';
echo "\$this->breadcrumbs=array(
	$label=>array('index'),
	'Управление',
);\n";
?>

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#<?php echo $this->class2id($this->modelClass); ?>-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление  "<?php echo "<?php"; ?>  echo $model::$modelLabelP; ?>"</h1>


<?php echo "<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>"; ?>

<div class="search-form" style="display:none">
<?php echo "<?php \$this->renderPartial('_search',array(
	'model'=>\$model,
)); ?>\n"; ?>
</div><!-- search-form -->

<?php echo "<?php"; ?> $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
<?php
$count=0;
$model=new $this->model;
$rel=array();

foreach ($model->metaData->relations as $relations){
	$rel['search'][]=$relations->foreignKey;
	$rel[$relations->foreignKey]['name']=$relations->name;
    $rel[$relations->foreignKey]['className']=$relations->className;
    $rel[$relations->foreignKey]['foreignKey']=$relations->foreignKey;
} 


foreach($this->tableSchema->columns as $column)
{

	if(++$count==7)
		echo "\t\t/*\n";
	$rel['search']=(!empty($rel['search']))?$rel['search']:array();
	if (in_array($column->name,$rel['search'])){
		echo "\t\tarray( 'name'=>'{$rel[$column->name]['name']}{$rel[$column->name]['foreignKey']}', 'value'=>'\$data->{$rel[$column->name]['name']}->{$rel[$column->name]['foreignKey']}' ),\n";
	}else{
		echo "\t\t'".$column->name."',\n";	
	}
	
}
if($count>=7)
	echo "\t\t*/\n";
?>
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
