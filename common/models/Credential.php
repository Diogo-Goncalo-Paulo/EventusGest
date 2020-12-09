<?php

namespace common\models;

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
 * @property Carrier $idCarrier0
 * @property Event $idEvent0
 * @property Area $idCurrentArea0
 * @property Entity $idEntity0
 * @property Movement[] $movement
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
            [['ucid'], 'unique'],
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
            'ucid' => 'UCID',
            'idEntity' => 'Entidade',
            'idCurrentArea' => 'Area atual',
            'idEvent' => 'Evento',
            'flagged' => 'Marcado',
            'blocked' => 'Bloqueado',
            'createdAt' => 'Criado a',
            'updatedAt' => 'Atualizado a',
            'deletedAt' => 'Eliminado a',
        ];
    }

    /**
     * Gets query for [[Carriers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCarrier0()
    {
        return $this->hasOne(Carrier::className(), ['idCredential' => 'id']);
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
        return $this->hasMany(Movement::className(), ['idCredential' => 'id']);
    }
}
