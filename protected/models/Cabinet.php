<?php

/**
 * This is the model class for table "cabinet".
 *
 * The followings are the available columns in table 'cabinet':
 * @property integer $id
 * @property integer $id_floor
 * @property string $cname
 * @property string $num
 * @property string $phone
 *		 * The followings are the available model relations:


 * @property Floor $idFloor


 * @property Workplace[] $workplaces
 */
class Cabinet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cabinet the static model class
	 */
	public static $modelLabelS='Кабинет';
	public static $modelLabelP='Кабинеты';
	

	public static $tree=array(
		'parent_id'=>'id_floor',
		'query'=>"SELECT m1.id, m1.num||' '||m1.cname AS text, m1.id as parent_id, count(m2.id) AS \"hasChildren\" FROM cabinet AS m1 LEFT JOIN workplace AS m2 ON m1.id=m2.id_cabinet",
		'group'=>'GROUP BY m1.id  ORDER BY m1.num ASC',
		'child'=>'Workplace',
		'where'=>'AND (m1.deactive is null or m1.deactive<>1)',
	);
	
	public $idFloorid_floor;
	public $workplacesid_cabinet;
	public $allfields;
	public $place;
	public $id_building;

	public function behaviors(){
		return array(
			'PreFill'=>array(
				'class'=>'application.behaviors.PreFillBehavior',
				),
			 'Log'=>array(
                'class'=>'application.behaviors.LogBehavior',
                ),

			);
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cabinet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_floor', 'required'),
			array('id_floor,deactive', 'numerical', 'integerOnly'=>true),
			array('cname', 'length', 'max'=>200),
			array('num', 'length', 'max'=>10),
			array('phone', 'length', 'max'=>100),
			array('id, id_floor, cname, num, allfields, phone,idFloorid_floor,deactive,workplacesid_cabinet,place,id_building', 'safe', 'on'=>'search_phones'),
			array('id, id_floor, cname, num, allfields, phone,idFloorid_floor,deactive,workplacesid_cabinet,place,id_building', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idFloor' => array(self::BELONGS_TO, 'Floor', 'id_floor'),
			'workplaces' => array(self::HAS_MANY, 'Workplace', 'id_cabinet'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_floor' => 'Здание/Этаж',
			'cname' => 'Название',
			'num' => 'Номер',
			'phone' => 'Телефон',
			'idFloorid_floor' => 'Этаж',
			'workplacesid_cabinet' => 'Рабочие места',
			'id_building' => 'Здание',
			'deactive'=>'Деактивация',
		);
	}

	public function cabName(){
		return $this->num." ".$this->cname;
	}

	public function cabNameFull($short=false,$withphone=false){
		if($short){
			$result=$this->idFloor->idBuilding->short.'/ '.$this->idFloor->fnum.' эт./ '.$this->num;	
		}else{
			$result=$this->idFloor->idBuilding->bname."/ ".$this->idFloor->fname."/ ".$this->cabName();	
		}	
		if($withphone)
			$result.='('.$this->phone.')';

		return $result;
	}

	public function cabNameFullArray($short=false){
		if($short){
			$result=array($this->idFloor->idBuilding->short,$this->idFloor->fnum.' эт.',$this->num);	
		}else{
			$result=array($this->idFloor->idBuilding->bname,$this->idFloor->fname,$this->cabName());	
		}	
		return $result;
	}

	 public function nameL(){
        return $this->cabNameFull();
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with=array('idFloor' => array('alias' => 'floor'),'workplaces' => array('alias' => 'workplace'),);
		if(!empty($_GET['id_cabinet']))
			$criteria->compare('t.id',$_GET['id_cabinet']);
		else
			$criteria->compare('t.id',$this->id);
		if(!empty($_GET['id_floor']))
				$criteria->compare('id_floor',$_GET['id_floor']);
		else
				$criteria->compare('id_floor',$this->id_floor);
		$criteria->compare('deactive',$this->deactive);
		$criteria->compare('cname',$this->cname,true);
		$criteria->compare('num',$this->num,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('floor.fname',$this->idFloorid_floor,true);
		$criteria->compare('workplace.id_cabinet',$this->workplacesid_cabinet,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function split_phones($phone){
		$res=array('old'=>array(),'int'=>array(),'out'=>array());
		$ph=explode(',', $phone);
		foreach ($ph as &$f) {
			$f=trim($f);
		}
		$ph=array_filter($ph);
		foreach ($ph as $v) {
			$x=trim($v);
			if(mb_strlen($x)<4){
				$res['old'][]=$v;
			}else if(mb_strlen($x)<5){
				$res['int'][]=$v;
			}else{
				$res['out'][]=$v;
			}
		}
		return $res;
	}

	public static function search_phones_export(){
		$criteria=new CDbCriteria;
		 $criteria->with=array(
            'idFloor.idBuilding',
            'workplaces' => array('alias' => 'workplace','together'=>True),
            'workplaces.idPersonnel' => array('alias' => 'personnel'),
            'workplaces.idPersonnel.personnelPostsHistories:working' => array('order'=>'"personnelPostsHistories".date_end DESC','alias' => 'personnelPostsHistories','together'=>True),
            'workplaces.idPersonnel.personnelPostsHistories.idPost'=>array('alias'=>'department_posts'),
            'workplaces.idPersonnel.personnelPostsHistories.idPost.postSubdivRn'=>array('alias'=>'departments'),);

        $criteria->addCondition(array('condition'=>'t.phone is not NULL or "workplace".phone is not NULL'));
       	$criteria->order='workplace.phone||"t".phone ASC';
		//$criteria->compare('personnel.creator',$this->creator0creator,true);
		$models=self::model()->findAll($criteria);
		$result=array();

		foreach ($models as $cab) {
		
			$ph_cab=self::split_phones($cab->phone);
			$name_cab=$cab->cabNameFullArray();
			$wp_count=0;

			if(!empty($cab->workplaces)){
				foreach ($cab->workplaces as $wp) {

					$res=array();
					if(!empty($wp->id_personnel) and (!empty($wp->phone))){
						$ph_wp=self::split_phones($wp->phone);
						$res['fio']=$wp->idPersonnel->wrapFio('fio');
						$post=$wp->idPersonnel->posts();
						$res['post']=(!empty($post))?$post[0]:'';
						$res['cabinet']=$name_cab;
						$res['phone_old']=implode(',',array_unique(array_merge($ph_wp['old'],$ph_cab['old'])));
						$res['phone_int']=implode(',',array_unique(array_merge($ph_wp['int'],$ph_cab['int'])));
						$res['phone_out']=implode(',',array_unique(array_merge($ph_wp['out'],$ph_cab['out'])));
						$result[]=$res;
						$wp_count++;
					}else if(!empty($wp->phone)){
						$ph_wp=self::split_phones($wp->phone);
						$res['fio']=$wp->wpName();
						$res['post']='';
						$res['cabinet']=$name_cab;
						$res['phone_old']=implode(',',array_unique(array_merge($ph_wp['old'],$ph_cab['old'])));
						$res['phone_int']=implode(',',array_unique(array_merge($ph_wp['int'],$ph_cab['int'])));
						$res['phone_out']=implode(',',array_unique(array_merge($ph_wp['out'],$ph_cab['out'])));
						$result[]=$res;
						$wp_count++;
					}
				
				}
			}
			if($wp_count==0 and (!empty($cab->phone))){
				$cb=array();
				$cb['fio']='';
				$cb['post']='';
				$cb['cabinet']=$name_cab;
				$cb['phone_old']=implode(',',$ph_cab['old']);
				$cb['phone_int']=implode(',',$ph_cab['int']);
				$cb['phone_out']=implode(',',$ph_cab['out']);
				$result[]=$cb;
			}

		}

		return $result;



	}


	public function suggestTag($keyword){
		$keyword=mb_strtolower($keyword,'UTF-8');
 		$tags=$this->with('workplaces.idPersonnel','idFloor.idBuilding')->findAll(array(
   			'condition'=>'(t.phone LIKE :keyword OR "workplaces".phone LIKE :keyword OR LOWER("idPersonnel".surname) LIKE :keyword OR LOWER("idBuilding".bname) LIKE :keyword OR LOWER(t.num) LIKE :keyword OR LOWER(t.cname) LIKE :keyword OR LOWER("workplaces".wname) LIKE :keyword) AND ("workplaces".deactive is null or "workplaces".deactive<>1)',
   			'params'=>array(
     		':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',

   		)
   		,'order'=>'"idBuilding".bname asc, "idFloor".fnum asc, t.num||t.cname asc, "workplaces".wname asc'
 		));
 		return $tags;
	}


	
	public function search_phones()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        $criteria->together=True;
        $criteria->with=array(
            'idFloor.idBuilding',
            'workplaces' => array('alias' => 'workplace'),
            'workplaces.idPersonnel' => array('alias' => 'personnel'),
            'workplaces.idPersonnel.zempleavs'=>array('scopes'=>array('is_today')),
            'workplaces.idPersonnel.personnelPostsHistories:working' => array('order'=>'"personnelPostsHistories".date_end DESC','alias' => 'personnelPostsHistories','limit'=>1),
            'workplaces.idPersonnel.personnelPostsHistories.idPost'=>array('alias'=>'department_posts'),
            'workplaces.idPersonnel.personnelPostsHistories.idPost.postSubdivRn'=>array('alias'=>'departments'),);

        $criteria->compare('id',$this->id);
        $criteria->addCondition(array('condition'=>'t.phone<>\'\' or "workplace".phone<>\'\''));

        /*
        if(!empty($this->place)){
			$place=explode('_',$this->place);
			switch ($place[0]) {
				case 'b':
					$criteria->compare('"idBuilding".id',$place[1]);
					break;
				case 'f':
					$criteria->compare('"idFloor".id',$place[1]);
					break;
				default:
					# code...
					break;
			}
		}*/

		$criteria->compare('"idBuilding".id',$this->id_building);

        $words=explode(" ",$this->allfields);


        foreach ($words as $v) {
        $criteria2=new CDbCriteria;
            $criteria2->compare('LOWER(personnel.surname)',mb_strtolower($v,'UTF-8'),true, 'OR');
            $criteria2->compare('LOWER(personnel.name)',mb_strtolower($v,'UTF-8'),true, 'OR');
            $criteria2->compare('LOWER(personnel.patr)',mb_strtolower($v,'UTF-8'),true, 'OR');
            $criteria2->compare('LOWER(department_posts.post)',mb_strtolower($v,'UTF-8'),true, 'OR');
            $criteria2->compare('LOWER(departments.name)',mb_strtolower($v,'UTF-8'),true, 'OR' );
            $criteria2->compare('LOWER(t.cname)',mb_strtolower($v,'UTF-8'),true, 'OR' );
            $criteria2->compare('LOWER(t.num)',mb_strtolower($v,'UTF-8'),true, 'OR' );
            $criteria2->compare('LOWER(t.phone)',mb_strtolower($v,'UTF-8'),true, 'OR' );
            $criteria2->compare('LOWER(workplace.phone)',mb_strtolower($v,'UTF-8'),true, 'OR' );
            $criteria2->compare('LOWER(workplace.wname)',mb_strtolower($v,'UTF-8'),true, 'OR' );
        $criteria->mergeWith($criteria2);
        }

        
        $criteria->order='workplace.phone||"t".phone ASC';
      

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>False,
        ));
    }

	public function search_phones2()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        $criteria->with=array(
            'idFloor.idBuilding',
            'workplaces' => array('alias' => 'workplace','together'=>True),
            'workplaces.idPersonnel' => array('alias' => 'personnel'),
            'workplaces.idPersonnel.personnelPostsHistories:working' => array('order'=>'"personnelPostsHistories".date_end DESC','alias' => 'personnelPostsHistories','together'=>True),
            'workplaces.idPersonnel.personnelPostsHistories.idPost'=>array('alias'=>'department_posts'),
            'workplaces.idPersonnel.personnelPostsHistories.idPost.postSubdivRn'=>array('alias'=>'departments'),);

        $criteria->compare('id',$this->id);
        $criteria->addCondition(array('condition'=>'t.phone is not NULL or "workplace".phone is not NULL'));

        if(!empty($this->place)){
			$place=explode('_',$this->place);
			switch ($place[0]) {
				case 'b':
					$criteria->compare('"idBuilding".id',$place[1]);
					break;
				case 'f':
					$criteria->compare('"idFloor".id',$place[1]);
					break;
				default:
					# code...
					break;
			}
		}

        $words=explode(" ",$this->allfields);


        foreach ($words as $v) {
        $criteria2=new CDbCriteria;
            $criteria2->compare('LOWER(personnel.surname)',mb_strtolower($v,'UTF-8'),true, 'OR');
            $criteria2->compare('LOWER(personnel.name)',mb_strtolower($v,'UTF-8'),true, 'OR');
            $criteria2->compare('LOWER(personnel.patr)',mb_strtolower($v,'UTF-8'),true, 'OR');
            $criteria2->compare('LOWER(department_posts.post)',mb_strtolower($v,'UTF-8'),true, 'OR');
            $criteria2->compare('LOWER(departments.name)',mb_strtolower($v,'UTF-8'),true, 'OR' );
            $criteria2->compare('LOWER(t.cname)',mb_strtolower($v,'UTF-8'),true, 'OR' );
            $criteria2->compare('LOWER(t.num)',mb_strtolower($v,'UTF-8'),true, 'OR' );
            $criteria2->compare('LOWER(t.phone)',mb_strtolower($v,'UTF-8'),true, 'OR' );
            $criteria2->compare('LOWER(workplace.phone)',mb_strtolower($v,'UTF-8'),true, 'OR' );
            $criteria2->compare('LOWER(workplace.wname)',mb_strtolower($v,'UTF-8'),true, 'OR' );
        $criteria->mergeWith($criteria2);
        }

        
        $criteria->order='"t".num ASC, "t".phone ASC';

        $pag=49;
        foreach ($this->attributes as $x) {
            if(!empty($x)){
                $pag=100;
                break;
            }
        }
      

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
            	'pageSize'=>$pag
            ),
        ));
    }
}
