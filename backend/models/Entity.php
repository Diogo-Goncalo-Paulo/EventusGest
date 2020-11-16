<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "entities".
 *
 * @property int $id
 * @property string $ueid
 * @property string $nome
 * @property int $idTipoEntidade
 * @property string $createdAt
 * @property string $updatedAt
 * @property string|null $deletedAt
 *
 * @property Credential[] $credentials
 * @property Entitytype $idTipoEntidade0
 */
class Entity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'entities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ueid', 'nome', 'idTipoEntidade'], 'required'],
            [['idTipoEntidade'], 'integer'],
            [['createdAt', 'updatedAt', 'deletedAt'], 'safe'],
            [['ueid'], 'string', 'max' => 8],
            [['nome'], 'string', 'max' => 255],
            [['idTipoEntidade'], 'exist', 'skipOnError' => true, 'targetClass' => Entitytype::className(), 'targetAttribute' => ['idTipoEntidade' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ueid' => 'Ueid',
            'nome' => 'Nome',
            'idTipoEntidade' => 'Id Tipo Entidade',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'deletedAt' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Credentials]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCredentials()
    {
        return $this->hasMany(Credential::className(), ['idEntity' => 'id']);
    }

    /**
     * Gets query for [[IdTipoEntidade0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoEntidade0()
    {
        return $this->hasOne(Entitytype::className(), ['id' => 'idTipoEntidade']);
    }
}
