<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $data <?php echo $this->getModelClass(); ?> */
?>

<div class="view">

<?php
echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('{$this->tableSchema->primaryKey}')); ?>:</b>\n";
echo "\t<?php echo CHtml::link(CHtml::encode(\$data->{$this->tableSchema->primaryKey}), array('view', 'id'=>\$data->{$this->tableSchema->primaryKey})); ?>\n\t<br />\n\n";
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
	if($column->isPrimaryKey)
		continue;
	if(++$count==7)
		echo "\t<?php /*\n";
	echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('{$column->name}')); ?>:</b>\n";

	$rel['search']=(!empty($rel['search']))?$rel['search']:array();

	if (in_array($column->name,$rel['search'])){
		echo "\t<?php echo CHtml::encode(\$data->{$rel[$column->name]['name']}->{$column->name}); ?>\n\t<br />\n\n";
	}else{
		echo "\t<?php echo CHtml::encode(\$data->{$column->name}); ?>\n\t<br />\n\n";
	}
}
if($count>=7)
	echo "\t*/ ?>\n";
?>

</div>