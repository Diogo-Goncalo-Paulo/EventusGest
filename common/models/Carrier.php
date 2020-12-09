<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "carriers".
 *
 * @property int $id
 * @property string $name
 * @property string|null $info
 * @property string|null $photo
 * @property int $idCredential
 * @property int $idCarrierType
 * @property string $createdAt
 * @property string $updatedAt
 * @property string|null $deletedAt
 *
 * @property Credential $idCredential0
 * @property Carriertype $idCarrierType0
 */
class Carrier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carriers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'idCredential', 'idCarrierType'], 'required'],
            [['idCredential', 'idCarrierType'], 'integer'],
            [['createdAt', 'updatedAt', 'deletedAt'], 'safe'],
            [['name', 'info', 'photo'], 'string', 'max' => 255],
            [['photo'], 'unique'],
            [['idCredential'], 'exist', 'skipOnError' => true, 'targetClass' => Credential::className(), 'targetAttribute' => ['idCredential' => 'id']],
            [['idCarrierType'], 'exist', 'skipOnError' => true, 'targetClass' => Carriertype::className(), 'targetAttribute' => ['idCarrierType' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'info' => 'Info',
            'photo' => 'Photo',
            'idCredential' => 'Id Credential',
            'idCarrierType' => 'Id Carrier Type',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'deletedAt' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[IdCredential0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCredential0()
    {
        return $this->hasOne(Credential::className(), ['id' => 'idCredential']);
    }

    /**
     * Gets query for [[IdCarrierType0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCarrierType0()
    {
        return $this->hasOne(Carriertype::className(), ['id' => 'idCarrierType']);
    }
}
