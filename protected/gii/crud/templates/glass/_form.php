<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
/* @var $form CActiveForm */
?>

<div class="form">

<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>false,
)); ?>\n"; ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php 
$model=new $this->model;
$fk=array();
$searchfk=array();
if(!empty($model->metaData->relations)){
	foreach ($model->metaData->relations as $relations){
		//print_r($relations);
		if (get_class($relations)=='CBelongsToRelation' or get_class($relations)=='CHasOneRelation'){
			$tmp['className']=$relations->className;
			$tmp['foreignKey']=$relations->foreignKey;
			$fk[$relations->foreignKey]=$tmp;
			$searchfk[]=$tmp['foreignKey'];
		}
	}
} 
	?>

<?php
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement)
		continue;


?>
	<div class="row">
		<?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>\n"; ?>

		<?php 

			if (in_array($column->name, $searchfk)){
				echo '<?php $tmp='.$fk[$column->name]['className'].'::model()->findall();'."\n";
		 		echo 'echo $form->dropDownList($model,"'.$fk[$column->name]['foreignKey'].'",CHtml::listData($tmp,"id",function($tmp) {
				return CHtml::encode($tmp->'.$fk[$column->name]['foreignKey'].')}); ?>';
			}else{
				echo "<?php echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; 
			}
			?>

		<?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
	</div>

<?php
}
?>
	<div class="row buttons">
		<?php echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? 'Создать' : 'Сохранить'); ?>\n"; ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- form -->