<?php
/* @var $this PersonnelController */
/* @var $data Personnel */
//echo '<pre>'; print_r($data); echo '</pre>';?>

<tr>
	<td><?php echo CHtml::encode($data->surname); ?> <?php echo CHtml::encode($data->name); ?> <?php echo CHtml::encode($data->patr); ?></td>
	<td><?php if(!empty($data->personnelPostsHistories[0])){ echo CHtml::encode($data->personnelPostsHistories[0]->idPost->post); }?></td>
	<td><?php if(!empty($data->personnelPostsHistories[0])){ echo CHtml::encode($data->personnelPostsHistories[0]->idPost->postSubdivRn->name); }?></td>
	<td><?php if(!empty($data->workplaces)){ echo CHtml::encode($data->workplaces->idCabinet->idFloor->idBuilding->bname).'/'.CHtml::encode($data->workplaces->idCabinet->idFloor->fname).'/'.CHtml::encode($data->workplaces->idCabinet->cname).' №'.CHtml::encode($data->workplaces->idCabinet->num); }?></td>
	<td><?php if(!empty($data->workplaces)){ echo 'каб. '.CHtml::encode($data->workplaces->idCabinet->phone).' <br>личн.'.CHtml::encode($data->workplaces->phone); }?></td>
</tr>
