<?php
/* @var $this PersonnelController */
/* @var $data Personnel */
//echo '<pre>'; print_r($data); echo '</pre>';?>

<tr>
	<td><?php echo CHtml::encode($data->surname); ?> <?php echo CHtml::encode($data->name); ?> <?php echo CHtml::encode($data->patr); ?></td>
	<td><?php if(!empty($data->personnelPostsHistories[0])){ echo CHtml::encode($data->personnelPostsHistories[0]->idPost->post); }?></td>
	<td><?php if(!empty($data->personnelPostsHistories[0])){ echo CHtml::encode($data->personnelPostsHistories[0]->idPost->postSubdivRn->name); }?></td>
	<td><?php if(!empty($data->workplaces)){ echo '<a href="'.Yii::app()->request->baseUrl.'/cabinet/'.CHtml::encode($data->workplaces->idCabinet->id).'">'.CHtml::encode($data->workplaces->idCabinet->cname).' №'.CHtml::encode($data->workplaces->idCabinet->num).'</a>'; }?></td>
	<td><?php if(!empty($data->workplaces)){ echo CHtml::encode($data->workplaces->idCabinet->phone); }?></td>
</tr>
