<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "credentials".
 *
 * @property int $id
 * @property string $ucid
 * @property int $idEntity
 * @property int|null $idCurrentArea
 * @property int $idEvent
 * @property int $flagged
 * @property int $blocked
 * @property string $createdAt
 * @property string $updatedAt
 * @property string|null $deletedAt
 *
 * @property Carrier[] $carriers
 * @property Event $idEvent0
 * @property Area $idCurrentArea0
 * @property Entity $idEntity0
 * @property Movement[] $movements
 */
class Credential extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'credentials';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ucid', 'idEntity', 'idEvent', 'createdAt', 'updatedAt'], 'required'],
            [['idEntity', 'idCurrentArea', 'idEvent', 'flagged', 'blocked'], 'integer'],
            [['createdAt', 'updatedAt', 'deletedAt'], 'safe'],
            [['ucid'], 'string', 'max' => 8],
            [['idEvent'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['idEvent' => 'id']],
            [['idCurrentArea'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['idCurrentArea' => 'id']],
            [['idEntity'], 'exist', 'skipOnError' => true, 'targetClass' => Entity::className(), 'targetAttribute' => ['idEntity' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ucid' => 'Ucid',
            'idEntity' => 'Id Entity',
            'idCurrentArea' => 'Id Current Area',
            'idEvent' => 'Id Event',
            'flagged' => 'Flagged',
            'blocked' => 'Blocked',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'deletedAt' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Carriers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarriers()
    {
        return $this->hasMany(Carrier::className(), ['idCredential' => 'id']);
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

    /**
     * Gets query for [[IdCurrentArea0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCurrentArea0()
    {
        return $this->hasOne(Area::className(), ['id' => 'idCurrentArea']);
    }

    /**
     * Gets query for [[IdEntity0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdEntity0()
    {
        return $this->hasOne(Entity::className(), ['id' => 'idEntity']);
    }

    /**
     * Gets query for [[Movements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovements()
    {
        return $this->hasMany(Movement::className(), ['idCredencial' => 'id']);
    }
}
