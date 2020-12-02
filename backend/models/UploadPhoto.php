<?php
namespace app\models;

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
            [['photoFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    public function upload($photo)
    {
        if ($this->validate()) {
            $this->photoFile->saveAs('../uploads/carriers/'. $photo);
            return true;
        } else {
            return false;
        }
    }
}
