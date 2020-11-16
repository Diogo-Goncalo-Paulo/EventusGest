<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accesspoints".
 *
 * @property int $id
 * @property string $nome
 * @property string $createdAt
 * @property string $updatedAt
 * @property string|null $deletedAt
 *
 * @property Areasaccesspoint[] $areasaccesspoint
 * @property Areas[] $idArea
 * @property Movements[] $movement
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
            [['nome'], 'required'],
            [['createdAt', 'updatedAt', 'deletedAt'], 'safe'],
            [['nome'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'deletedAt' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Areasaccesspoints]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAreasaccesspoints()
    {
        return $this->hasMany(Areasaccesspoint::className(), ['idPontoAcesso' => 'id']);
    }

    /**
     * Gets query for [[IdAreas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdAreas()
    {
        return $this->hasMany(Area::className(), ['id' => 'idArea'])->viaTable('areasaccesspoints', ['idPontoAcesso' => 'id']);
    }

    /**
     * Gets query for [[Movements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovements()
    {
        return $this->hasMany(Movements::className(), ['idAccessPoint' => 'id']);
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
