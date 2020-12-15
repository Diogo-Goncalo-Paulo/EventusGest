<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "entitytypeareas".
 *
 * @property int $idEntityType
 * @property int $idArea
 *
 * @property Area $idArea0
 * @property Entitytype $idEntityType0
 */
class Entitytypeareas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'entitytypeareas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idEntityType', 'idArea'], 'required'],
            [['idEntityType', 'idArea'], 'integer'],
            [['idEntityType', 'idArea'], 'unique', 'targetAttribute' => ['idEntityType', 'idArea']],
            [['idArea'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['idArea' => 'id']],
            [['idEntityType'], 'exist', 'skipOnError' => true, 'targetClass' => Entitytype::className(), 'targetAttribute' => ['idEntityType' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idEntityType' => 'Id Entity Type',
            'idArea' => 'Id Area',
        ];
    }

    /**
     * Gets query for [[IdArea0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdArea0()
    {
        return $this->hasOne(Area::className(), ['id' => 'idArea']);
    }

    /**
     * Gets query for [[IdEntityType0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdEntityType0()
    {
        return $this->hasOne(Entitytype::className(), ['id' => 'idEntityType']);
    }
}
