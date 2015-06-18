<?php
/* @var $this ApiController */

$this->breadcrumbs=array(
	'Api',
);
?>
<h1>API. Описание</h1>
<dl>
	<dt>messChat?message=xxx</dt>
	<dd>Служебное сообщение в чат
		message - текст сообщения
	</dd>

	<dt>saveMon?qms1=x&qms2=x&...</dt>
	<dd>
		Параметры
			'qms1' => 'QMS 172.16.45.4',
			'qms2' => 'QMS 172.16.46.4',
			'intet' => 'Интернет',
			'dns' => 'DNS сервер',
			'mos_gate' => 'Шлюз Московской',
			'mos_intro' => 'Внутренняя сеть московской',
			'fog_space' => 'Свободное место на fog. Числом, в МБ',

		Возможные значения: 
			0 - не работает
			1 - работает
			2 - не определено
	</dd>
</dl>

