<?php
/* @var $this PersonnelController */
/* @var $data Personnel */
//echo '<pre>'; print_r($data); echo '</pre>';?>

<tr>
	<td><?php echo CHtml::encode($data->surname); ?> <?php echo CHtml::encode($data->name); ?> <?php echo CHtml::encode($data->patr); ?></td>
	<td><?php if(!empty($data->personnelPostsHistories[0])){ echo CHtml::encode($data->personnelPostsHistories[0]->idPost->post); }?></td>
	<td><?php if(!empty($data->personnelPostsHistories[0])){ echo CHtml::encode($data->personnelPostsHistories[0]->idPost->postSubdivRn->name); }?></td>
	<?php 	
		$cabinet=array();
		$phone=array();
		foreach ($data->workplaces as $wp) {
			$cabinet[]=CHtml::encode($wp->idCabinet->idFloor->idBuilding->bname).'/'.CHtml::encode($wp->idCabinet->idFloor->fname).'/'.CHtml::encode($wp->idCabinet->cname).' №'.CHtml::encode($wp->idCabinet->num);
			$phone['cab'][]=CHtml::encode($wp->idCabinet->phone);
			$phone['pers'][]=CHtml::encode($wp->phone);
		}
	?>
	<td><?php echo implode('<br>', $cabinet)?></td>
	<td><?php echo 'каб. '.implode(',',array_unique($phone['cab'])).'<br> личн. '.implode(',',array_unique($phone['pers'])) ?></td>

</tr>
