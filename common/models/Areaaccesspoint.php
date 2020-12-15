<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "areasaccesspoints".
 *
 * @property int $idArea
 * @property int $idAcessPoint
 *
 * @property Area $idArea0
 * @property Accesspoint $idAccessPoint0
 */
class Areaaccesspoint extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'areasaccesspoints';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idArea', 'idAccessPoint'], 'required'],
            [['idArea', 'idAccessPoint'], 'integer'],
            [['idArea', 'idAccessPoint'], 'unique', 'targetAttribute' => ['idArea', 'idAccessPoint']],
            [['idArea'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['idArea' => 'id']],
            [['idAccessPoint'], 'exist', 'skipOnError' => true, 'targetClass' => Accesspoint::className(), 'targetAttribute' => ['idAccessPoint' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idArea' => 'Id Area',
            'idAcessPoint' => 'Id Ponto Acesso',
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
     * Gets query for [[IdPontoAcesso0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdAccessPoint0()
    {
        return $this->hasOne(Accesspoint::className(), ['id' => 'idAccessPoint']);
    }
}
