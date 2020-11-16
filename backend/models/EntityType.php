<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "entitytypes".
 *
 * @property int $id
 * @property string $nome
 * @property int $qtCredenciais
 * @property int $idEvent
 * @property string $createdAt
 * @property string $updatedAt
 * @property string|null $deletedAt
 *
 * @property Entity[] $entities
 * @property Entitytypeareas[] $entitytypeareas
 * @property Area[] $idAreas
 * @property Event $idEvent0
 */
class EntityType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'entitytypes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'qtCredenciais', 'idEvent'], 'required'],
            [['qtCredenciais', 'idEvent'], 'integer'],
            [['createdAt', 'updatedAt', 'deletedAt'], 'safe'],
            [['nome'], 'string', 'max' => 255],
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
            'nome' => 'Nome',
            'qtCredenciais' => 'Qt Credenciais',
            'idEvent' => 'Id Event',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'deletedAt' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Entities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntities()
    {
        return $this->hasMany(Entity::className(), ['idTipoEntidade' => 'id']);
    }

    /**
     * Gets query for [[Entitytypeareas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntitytypeareas()
    {
        return $this->hasMany(Entitytypeareas::className(), ['idEntityType' => 'id']);
    }

    /**
     * Gets query for [[IdAreas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdAreas()
    {
        return $this->hasMany(Area::className(), ['id' => 'idArea'])->viaTable('entitytypeareas', ['idEntityType' => 'id']);
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
