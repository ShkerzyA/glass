<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
$model=new $this->model;

?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label='$model::$modelLabelP';
echo "\$this->breadcrumbs=array(
	$label=>array('index'),
	\$model->{$nameColumn}=>array('view','id'=>\$model->{$this->tableSchema->primaryKey}),
	'Изменить',
);\n";
?>

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Отобразить', 'url'=>array('view', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('label'=>'Управление ', 'url'=>array('admin'),'visible'=>(Yii::app()->user->role=='administrator')),
);
	<?php 
	if(!empty($model->metaData->relations)){
		echo '$this->menu["details"]=array(';
		foreach ($model->metaData->relations as $relations){
			echo "array('label'=>'$relations->className', 'url'=>array('$relations->className/admin', '$relations->foreignKey'=>\$model->id)),\n";
		}
		echo ');';

	}

	?>

?>

<h1>Изменить <?php echo "<?php"; ?>  echo $model::$modelLabelS; ?> <?php echo " <?php echo \$model->{$this->tableSchema->primaryKey}; ?>"; ?></h1>

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>