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
 * @property Carriers[] $carriers
 * @property Events $idEvent0
 * @property Areas $idCurrentArea0
 * @property Entities $idEntity0
 * @property Movements[] $movements
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
            [['idEntity'], 'exist', 'skipOnError' => true, 'targetClass' => Entitie::className(), 'targetAttribute' => ['idEntity' => 'id']],
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
        return $this->hasMany(Carriers::className(), ['idCredential' => 'id']);
    }

    /**
     * Gets query for [[IdEvent0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdEvent0()
    {
        return $this->hasOne(Events::className(), ['id' => 'idEvent']);
    }

    /**
     * Gets query for [[IdCurrentArea0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCurrentArea0()
    {
        return $this->hasOne(Areas::className(), ['id' => 'idCurrentArea']);
    }

    /**
     * Gets query for [[IdEntity0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdEntity0()
    {
        return $this->hasOne(Entities::className(), ['id' => 'idEntity']);
    }

    /**
     * Gets query for [[Movements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovements()
    {
        return $this->hasMany(Movements::className(), ['idCredencial' => 'id']);
    }
}
