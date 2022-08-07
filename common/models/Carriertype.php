<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carrierstypes".
 *
 * @property int $id
 * @property string $name
 * @property int $idEvent
 * @property string $createdAt
 * @property string $updatedAt
 * @property string|null $deletedAt
 * @property boolean $isCar
 *
 * @property Carrier[] $carrier
 * @property Event $idEvent0
 */
class Carriertype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrierstypes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'idEvent'], 'required'],
            [['idEvent'], 'integer'],
            [['createdAt', 'updatedAt', 'deletedAt'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['idEvent'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['idEvent' => 'id']],
            [['isCar'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nome',
            'idEvent' => 'Evento',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'deletedAt' => 'Deleted At',
            'isCar' => 'É veículo',
        ];
    }

    /**
     * Gets query for [[Carriers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarriers()
    {
        return $this->hasMany(Carrier::className(), ['idCarrierType' => 'id']);
    }

    /**
     * Gets query for [[IdEvent0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdEvent0()
    {
        return $this->hasOne(Event::className(), ['id' => 'idEvent']);
    }
}
