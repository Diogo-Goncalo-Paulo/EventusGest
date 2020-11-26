<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "events".
 *
 * @property int $id
 * @property string $name
 * @property string $startDate
 * @property string $endDate
 * @property string $createdAt
 * @property string $updateAt
 * @property string|null $deletedAt
 *
 * @property Area[] $areas
 * @property Carriertype[] $carrierstypes
 * @property Credential[] $credentials
 * @property Entitytype[] $entitytypes
 * @property Eventsuser[] $eventsusers
 * @property User[] $users
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'startDate', 'endDate'], 'required'],
            [['startDate', 'endDate', 'createdAt', 'updateAt', 'deletedAt'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'name' => 'Nome do Evento',
            'startDate' => 'Data de Começo',
            'endDate' => 'Data de Finalização',
            'createdAt' => 'Criado a',
            'updateAt' => 'Atualizado a',
            'deletedAt' => 'Eliminado a',
        ];
    }

    /**
     * Gets query for [[Areas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAreas()
    {
        return $this->hasMany(Area::className(), ['idEvent' => 'id']);
    }

    /**
     * Gets query for [[Carrierstypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrierstypes()
    {
        return $this->hasMany(Carriertype::className(), ['idEvent' => 'id']);
    }

    /**
     * Gets query for [[Credentials]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCredentials()
    {
        return $this->hasMany(Credential::className(), ['idEvent' => 'id']);
    }

    /**
     * Gets query for [[Entitytypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntitytypes()
    {
        return $this->hasMany(Entitytype::className(), ['idEvent' => 'id']);
    }

    /**
     * Gets query for [[Eventsusers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventsusers()
    {
        return $this->hasMany(Eventsuser::className(), ['idEvent' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['currentEvent' => 'id']);
    }
}
