<?php
/**
 * CButtonColumn class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

Yii::import('zii.widgets.grid.CButtonColumn');

/**
 * CButtonColumn represents a grid view column that renders one or several buttons.
 *
 * By default, it will display three buttons, "view", "update" and "delete", which triggers the corresponding
 * actions on the model of the row.
 *
 * By configuring {@link buttons} and {@link template} properties, the column can display other buttons
 * and customize the display order of the buttons.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package zii.widgets.grid
 * @since 1.1
 */
class MyButtonColumn extends CButtonColumn
{

	public $buttons=array(
		'delete' => array
		(  //A JS function to be invoked when the button is clicked.
    	'visible'=>'Yii::app()->user->role=="administrator"',   //A PHP expression for determining whether the button is visible.
		)
	);
}