<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "areas".
 *
 * @property int $id
 * @property string $name
 * @property int $idEvent
 * @property string|null $resetTime
 * @property string $createdAt
 * @property string $updatedAt
 * @property string|null $deletedAt
 *
 * @property Event $idEvent0
 * @property Areaaccesspoint[] $areaaccesspoints 
 * @property Accesspoint[] $idAcessPoints
 * @property Credential[] $credentials
 * @property Entitytypearea[] $entitytypeareas
 * @property Entitytype[] $idEntityTypes
 * @property Movement[] $movements
 * @property Movement[] $movements0
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'areas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'idEvent'], 'required'],
            [['idEvent'], 'integer'],
            [['resetTime', 'createdAt', 'updatedAt', 'deletedAt'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['idEvent'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['idEvent' => 'id']],
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
            'resetTime' => 'Tempo para reiniciar',
            'createdAt' => 'Criado a',
            'updatedAt' => 'Atualizado a',
            'deletedAt' => 'Eliminado a',
        ];
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
     * Gets query for [[Areasaccesspoints]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAreasaccesspoints()
    {
        return $this->hasMany(Areaaccesspoint::className(), ['idArea' => 'id']);
    }

    /**
     * Gets query for [[IdPontoAcessos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdAcessPoints()
    {
        return $this->hasMany(Accesspoint::className(), ['id' => 'idAccessPoint'])->viaTable('areasaccesspoints', ['idArea' => 'id']);
    }

    /**
     * Gets query for [[Credentials]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCredentials()
    {
        return $this->hasMany(Credential::className(), ['idCurrentArea' => 'id']);
    }

    /**
     * Gets query for [[Entitytypeareas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntitytypeareas()
    {
        return $this->hasMany(Entitytypeareas::className(), ['idArea' => 'id']);
    }

    /**
     * Gets query for [[IdEntityTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdEntityTypes()
    {
        return $this->hasMany(Entitytypes::className(), ['id' => 'idEntityType'])->viaTable('entitytypeareas', ['idArea' => 'id']);
    }

    /**
     * Gets query for [[Movements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovements()
    {
        return $this->hasMany(Movements::className(), ['idAreaFrom' => 'id']);
    }

    /**
     * Gets query for [[Movements0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovements0()
    {
        return $this->hasMany(Movements::className(), ['idAreaTo' => 'id']);
    }
}
