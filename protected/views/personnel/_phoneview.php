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
		$phone=$data->allPhones();
		foreach ($data->workplaces as $wp) {
			$cabn=CHtml::encode($wp->idCabinet->idFloor->idBuilding->bname).'/'.CHtml::encode($wp->idCabinet->idFloor->fname).'/'.CHtml::encode($wp->idCabinet->cname).' №'.CHtml::encode($wp->idCabinet->num);
			$link=(Yii::app()->user->checkAccess('inGroup',array('group'=>'it')))?CHtml::link($cabn,array('/cabinet/view/','id'=>$wp->idCabinet->id)):$cabn;

			$cabinet[]=$link;
		}
	?>
	<td><?php echo implode('<br>', array_unique($cabinet))?></td>
	<td><?php echo 'каб. '.implode(',',$phone['cab']).'<br> личн. '.implode(',',$phone['pers']) ?></td>

</tr>
