<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadPhoto extends Model
{
    /**
     * @var UploadedFile
     */
    public $photoFile;

    public function rules()
    {
        return [
            [['photoFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    public function upload($photo,$folder)
    {

        if ($this->validate()) {
            $this->photoFile->saveAs(\Yii::getAlias('@backend').'/web/uploads/'.$folder.'/'. $photo,false);
            $this->photoFile->saveAs(\Yii::getAlias('@frontend').'/web/uploads/'.$folder.'/'. $photo);
            return true;
        } else {
            return false;
        }
    }
}
