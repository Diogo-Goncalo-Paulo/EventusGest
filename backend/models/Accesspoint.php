<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accesspoints".
 *
 * @property int $id
 * @property string $name
 * @property string $createdAt
 * @property string $updatedAt
 * @property string|null $deletedAt
 *
 * @property Areaaccesspoint[] $areaaccesspoint
 * @property Area[] $idArea
 * @property Movement[] $movement
 * @property User[] $user
 */

class Accesspoint extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accesspoints';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['createdAt', 'updatedAt', 'deletedAt'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'createdAt' => 'Criado a ',
            'updatedAt' => 'Atualizado a',
            'deletedAt' => 'Eliminado a',
        ];
    }

    /**
     * Gets query for [[Areasaccesspoints]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAreaaccesspoints()
    {
        return $this->hasMany(Areaaccesspoint::className(), ['idAccessPoint' => 'id']);
    }

    /**
     * Gets query for [[IdAreas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdAreas()
    {
        return $this->hasMany(Area::className(), ['id' => 'idArea'])->viaTable('areasaccesspoints', ['idAccessPoint' => 'id']);
    }

    /**
     * Gets query for [[Movements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovements()
    {
        return $this->hasMany(Movement::className(), ['idAccessPoint' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['idAccessPoint' => 'id']);
    }
}
