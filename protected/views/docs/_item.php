<?php

		
		if(!empty($doc->link)){
			
			$file='<a target="_blank" href='.Yii::app()->request->baseUrl.'/media/docs/'.$doc->link.'><img class=s16 src="'.$doc->getIco().'"></a>';
		}else{
			$file='нет вложений';
		}


		echo '<div style="border-radius: 3px; min-height: 46px; margin: 3px; background: url(\'../images/doc.png\') no-repeat; padding-left: 40px;">
		<a href=/glass/docs/'.$doc->id.'><h4 style="margin: 3px;">'.$doc->doc_name.'</h4></a>
		<div style="position: relative; float: right; text-align: right"><i>'.$doc->date_begin.'<br>'.$doc->creator0->personnelPostsHistories[0]->idPersonnel->surname.' '.mb_substr($doc->creator0->personnelPostsHistories[0]->idPersonnel->name,0,1,'utf-8').'. '.mb_substr($doc->creator0->personnelPostsHistories[0]->idPersonnel->patr,0,1,'utf-8').'.</i></div>'.
		$file.
		//'<br>'.substr($doc->text_docs,0,300).'...'.
		'</div><hr>';

?>