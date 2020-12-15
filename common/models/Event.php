<?php

namespace common\models;

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
 * @property int|null $default_area
 *
 * @property Area[] $areas
 * @property Carrierstypes[] $carrierstypes
 * @property Credentials[] $credentials
 * @property Entitytypes[] $entitytypes
 * @property Area $defaultArea
 * @property Eventsusers[] $eventsusers
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
            [['default_area'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['default_area'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['default_area' => 'id']],
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
            'startDate' => 'Data de Começo',
            'endDate' => 'Data de Finalização',
            'createdAt' => 'Criado a',
            'updateAt' => 'Atualizado a',
            'deletedAt' => 'Apagado a',
            'default_area' => 'Área',
        ];
    }

    /**
     * Gets query for [[Areas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAreas()
    {
        return $this->hasMany(Areas::className(), ['idEvent' => 'id']);
    }

    /**
     * Gets query for [[Carrierstypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrierstypes()
    {
        return $this->hasMany(Carrierstypes::className(), ['idEvent' => 'id']);
    }

    /**
     * Gets query for [[Credentials]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCredentials()
    {
        return $this->hasMany(Credentials::className(), ['idEvent' => 'id']);
    }

    /**
     * Gets query for [[Entitytypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntitytypes()
    {
        return $this->hasMany(Entitytypes::className(), ['idEvent' => 'id']);
    }

    /**
     * Gets query for [[DefaultArea]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultArea()
    {
        return $this->hasOne(Area::className(), ['id' => 'default_area']);
    }

    /**
     * Gets query for [[Eventsusers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventsusers()
    {
        return $this->hasMany(Eventsusers::className(), ['idEvent' => 'id']);
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
