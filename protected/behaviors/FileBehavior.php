<?php 
class FileBehavior extends CActiveRecordBehavior{
    
    /*
    public function attach($owner) {
        parent::attach($owner);
                
        $owner = $this->getOwner();

        $validators = $owner->getValidatorList();
        $params = array('types'=>'jpg,jpeg,doc,docx,rar,zip,xls,xlsx,png,gif,pdf,djvu,txt,tif','allowEmpty'=>true); // etc
        $validator = CValidator::createValidator('file', $owner, 'link',$params );
        $validators->add($validator);
    }   */

    public function beforeSave($event){

        if(!empty($this->owner->dellink)){
            foreach ($this->owner->dellink as $x) {
                $this->deleteFile($x);
            }
        }
        if(($this->owner->scenario=='insert' || $this->owner->scenario=='update') && ($documents=CUploadedFile::getInstances($this->owner,'link')) && !empty($documents)){
                $i=0;
                $files_arr=$this->owner->link;
                foreach ($documents as $document) {
                    $i++;
                    $sourcePath = pathinfo($document->getName());  
                    $fileName = date('YmdHsi').$i.'.'. $sourcePath['extension'];  // имя будущего файла в базе и ФС
                    //$this->deleteFile(); // старый документ удалим, потому что загружаем новый
                    $document->saveAs(
                    Yii::getPathOfAlias('webroot.media').DIRECTORY_SEPARATOR.'docs'.DIRECTORY_SEPARATOR.$fileName);
                    $files_arr[]=$fileName;
                }
                $this->owner->link=$files_arr;
            
        }
        return true;
    }


    public function beforeDelete($event){
        $this->deleteAllFile(); // удалили модель? удаляем и файл
        return true;
    }
 
    public function deleteFile($link){
        if(empty($link))
            return false;
        $key=array_search($link,$this->owner->link);
        $links=$this->owner->link;
        unset($links[$key]);
        $filePath=Yii::getPathOfAlias('webroot.media').DIRECTORY_SEPARATOR.'docs'.DIRECTORY_SEPARATOR.$link;
        if(is_file($filePath))
            unlink($filePath);            
        $this->owner->link=$links;
        return true;
    }

    public function deleteAllFile(){
        foreach ($this->owner->link as $v) {
           $filePath=Yii::getPathOfAlias('webroot.media').DIRECTORY_SEPARATOR.'docs'.DIRECTORY_SEPARATOR.$v;
            if(is_file($filePath))
                unlink($filePath);
        }
        return true;
    }
} 
?>