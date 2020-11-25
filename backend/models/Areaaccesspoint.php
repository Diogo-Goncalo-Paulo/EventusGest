<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "areasaccesspoints".
 *
 * @property int $idArea
 * @property int $idPontoAcesso
 *
 * @property Area $idArea0
 * @property Accesspoint $idPontoAcesso0
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
            [['idArea', 'idPontoAcesso'], 'required'],
            [['idArea', 'idPontoAcesso'], 'integer'],
            [['idArea', 'idPontoAcesso'], 'unique', 'targetAttribute' => ['idArea', 'idPontoAcesso']],
            [['idArea'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['idArea' => 'id']],
            [['idPontoAcesso'], 'exist', 'skipOnError' => true, 'targetClass' => Accesspoint::className(), 'targetAttribute' => ['idPontoAcesso' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idArea' => 'Id Area',
            'idPontoAcesso' => 'Id Ponto Acesso',
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
    public function getIdPontoAcesso0()
    {
        return $this->hasOne(Accesspoint::className(), ['id' => 'idPontoAcesso']);
    }
}
