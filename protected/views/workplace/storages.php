<?php
/* @var $this WorkplaceController */
/* @var $data Workplace */

$storage=Workplace::storageCabs();
$this->menu['all_menu']=array('storage'=>
		array('title'=>'Склады оборудования','items'=>array(
			)
		)
);

foreach ($storage as $v) {
	$this->menu['all_menu']['storage']['items'][]=array('label'=>$v['label'], 'url'=>array('/Cabinet/'.$v['url']));
}

?>