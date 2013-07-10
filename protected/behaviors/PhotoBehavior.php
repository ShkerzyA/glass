<?php 
class PhotoBehavior extends CActiveRecordBehavior{
    
    public function beforeSave($event){
       if(($this->owner->scenario=='insert' || $this->owner->scenario=='update') &&
            ($document=CUploadedFile::getInstance($this->owner,'photo'))){
                $sourcePath = pathinfo($document->getName());
                $fileName = date('YmdHsi') .'.'. $sourcePath['extension'];  // имя будущего файла в базе и ФС
                $this->deletePhoto(); // старый документ удалим, потому что загружаем новый
                $this->owner->photo=$document;
                $this->owner->photo->saveAs(
                    Yii::getPathOfAlias('webroot.media').DIRECTORY_SEPARATOR.$fileName);
                $this->owner->photo=$fileName;
            
        }else{
                unset($this->owner->photo);
        }
        return true;
    }


    public function beforeDelete($event){
        $this->deletePhoto(); // удалили модель? удаляем и файл
        return true;
    }
 
    public function deletePhoto(){
        $photoPath=Yii::getPathOfAlias('webroot.media').DIRECTORY_SEPARATOR.$this->owner->photo;
        if(is_file($photoPath))
            unlink($photoPath);
        return true;
    }
} 
?>