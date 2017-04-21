<?php


			switch ($data->type) {
				case '0':
					$mess='<br><b>"'.$data->idTask->getStatus()[$data->ttext].'"</b> Статус задачи изменен';
					break;
				case '2':
						$rep=explode('\/',$data->ttext);
						$del=($data->creator==Yii::app()->user->id_pers)?'<div class="delete_this del_taskact" id='.$data->id.' style="float: right; z-index: 59; "></div>':'';
						$mess=$del.'<h3 style="text-align: right; margin: 2px;">Отчет по задаче</h3>'.$rep[0].' ('.$rep[2].') <br>'.$rep[1].' ';
					break;
				case '1':
				default:
					$mess='<pre style="overflov: none;">'.$data->ttext.'</pre>';	
					break;
			}

			if(!empty($mess)){
				echo'<div style="position: relative; clear: both;"></div>';
				echo'<div class="comment" id='.$data->id.'>';
				$creator=(!empty($data->creator0))?$data->creator0->wrapFio('fio_full'):'';
				echo'<div class="comment-topline"><i>'.$creator.'</i> &nbsp;&nbsp;&nbsp; '.$data->timestamp.'</div>';
				echo'<div class="sign"></div>';

				echo'<div style="position: relative; float: left; height: 60px; margin: 5px;"> <img height=100% src="';
				if (!empty($data->creator0->photo)){
					echo (Yii::app()->request->baseUrl.'/media'.DIRECTORY_SEPARATOR.CHtml::encode($data->creator0->photo)); 
				}else{
					echo (Yii::app()->request->baseUrl.'/images/no_avatar.jpg');
				}
				echo'"></div>';
				echo CHtml::link('<div style="position: relative; float: left;">'.$data->idTask->id.' '.$data->idTask->tname.'</div>', array('view', 'id'=>$data->idTask->id));
				echo $mess;
				echo'</div>';
			}

?>