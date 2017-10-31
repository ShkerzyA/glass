<?php

	
		if(!empty($model->link) and is_array($model->link)){
			foreach ($model->link as $l) {
				echo'<input id="Docs_dellink" type="checkbox" name="Docs[dellink][]" value="'.$l.'">';
				echo '<a target="_blank" href='.Yii::app()->request->baseUrl.'/media/docs/'.$l.'><img class=s16 src="'.$model->getIco($l).'"></a>';
			}
		}else{
			echo 'нет вложений';
		}


?>