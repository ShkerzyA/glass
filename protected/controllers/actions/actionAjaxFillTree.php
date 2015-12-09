<?php class actionAjaxFillTree extends CAction
{
    public function run()
    {
    	//echo Gear::getModelname();
           // если пробуют получить прямой доступ к экшину (не через ajax)
        // тогда обрубаем "крылья")) т.е. возвращаем белую страницу
        if (!Yii::app()->request->isAjaxRequest) {
            exit();
        }

        $modelName=Gear::getModelname();
        $m=new $modelName;
        $tree=$m::$tree;

        // с какого узла начинаем вывод дерева? 0 - с первого
        $where = '';
        $idP=NULL;
        if (isset($_GET['root']) && $_GET['root'] !== 'source') {
            $idP=(int)$_GET['root'];
            $parent_id=(!empty($tree['parent_id'])?$tree['parent_id']:'id');
            $where = 'WHERE m1.'.$parent_id.'='.$idP.' ';
        }

        
        // сам запрос на получение данных детей (через обычный LEFT JOIN)
        $treeWhere=(!empty($tree['where']))?$tree['where']:'';
        $req = Yii::app()->db->createCommand(
            //"SELECT m1.id, m1.name AS text, m1.id_parent as parent_id, count(m2.id) AS \"hasChildren\" FROM department AS m1 LEFT JOIN department AS m2 ON m1.id=m2.id_parent WHERE m1.id_parent $parentId and (m1.date_end is null  or m1.date_end>current_date) GROUP BY m1.id  ORDER BY m1.name ASC"
            $tree['query'].' '.$where.' '.$treeWhere. ' '.$tree['group']
        );

        $children = $req->queryAll();


       	$change=Yii::app()->user->checkAccess('changeObjects');
        foreach ($children as &$v) {
            if($change){
                $v['action']="<a href=/glass/".$modelName."/update/".$v['id']."><img align=right src=/glass/images/update.png></a>";
                $v['hasChildren']=1;      
            } 
            $v['contr']=$tree['child'];
            $v['selfname']=$modelName; 
            if($modelName=='Workplace'){
                $v['hasChildren']=0;
            }
        }
        

        $attr='';
        if(!empty($tree['parent_id']) and !empty($idP)){
            $attr='?'.$modelName.'['.$tree['parent_id'].']='.$idP;
        }
        if($change){
            $children[]=array('id'=>'create'.$attr,'text'=>'<img src="/glass/images/add.png">Добавить','selfname'=>$modelName,'hasChildren'=>0);
        }

        //print_r($children);
        // возвращаем данные
        echo str_replace(
            '"hasChildren":"0"',
            '"hasChildren":false',
            MyTreeView::saveDataAsJson($children)
        ); 
        exit();
    }
}

?>