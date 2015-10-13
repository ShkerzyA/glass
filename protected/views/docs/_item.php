<?php

		
		if(!empty($doc->link)){
			$file='<a target="_blank" href='.Yii::app()->request->baseUrl.'/media/docs/'.$doc->link.'><img class=s16 src="'.$doc->getIco().'"></a>';
		}else{
			$file='нет вложений';
		}


		echo '<div style="border-radius: 3px; min-height: 46px; margin: 3px; background: url(\'../images/doc.png\') no-repeat; padding-left: 40px;">
		<a href=/glass/docs/'.$doc->id.'><h4 style="margin: 3px;">'.$doc->doc_name.'</h4></a>';
		echo'<div style="position: relative; float: right; text-align: right"><i>'.$doc->date_begin.'<br>'.$doc->creator0->fio().'</i></div>';

		echo $file.
		//'<br>'.substr($doc->text_docs,0,300).'...'.
		'</div><hr>';

?>