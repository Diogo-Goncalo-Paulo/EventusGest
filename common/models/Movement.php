<?php

namespace common\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "movements".
 *
 * @property int $id
 * @property string $time
 * @property int $idCredential
 * @property int $idAccessPoint
 * @property int $idAreaFrom
 * @property int $idAreaTo
 * @property int $idUser
 *
 * @property Area $idAreaFrom0
 * @property Area $idAreaTo0
 * @property User $idUser0
 * @property Credential $idCredential0
 * @property Accesspoint $idAccessPoint0
 */
class Movement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'movements';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time'], 'safe'],
            [['idCredential', 'idAccessPoint', 'idAreaFrom', 'idAreaTo', 'idUser'], 'required'],
            [['idCredential', 'idAccessPoint', 'idAreaFrom', 'idAreaTo', 'idUser'], 'integer'],
            [['idAreaFrom'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['idAreaFrom' => 'id']],
            [['idAreaTo'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['idAreaTo' => 'id']],
            [['idUser'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['idUser' => 'id']],
            [['idCredential'], 'exist', 'skipOnError' => true, 'targetClass' => Credential::className(), 'targetAttribute' => ['idCredential' => 'id']],
            [['idAccessPoint'], 'exist', 'skipOnError' => true, 'targetClass' => Accesspoint::className(), 'targetAttribute' => ['idAccessPoint' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time' => 'Data',
            'idCredential' => 'Credencial',
            'idAccessPoint' => 'Ponto de acesso',
            'idAreaFrom' => 'De',
            'idAreaTo' => 'Para',
            'idUser' => 'Utilizador',
        ];
    }

    /**
     * Gets query for [[IdAreaFrom0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdAreaFrom0()
    {
        return $this->hasOne(Area::className(), ['id' => 'idAreaFrom']);
    }

    /**
     * Gets query for [[IdAreaTo0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdAreaTo0()
    {
        return $this->hasOne(Area::className(), ['id' => 'idAreaTo']);
    }

    /**
     * Gets query for [[IdUser0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'idUser']);
    }

    /**
     * Gets query for [[idCredential0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCredential0()
    {
        return $this->hasOne(Credential::className(), ['id' => 'idCredential']);
    }

    /**
     * Gets query for [[IdAccessPoint0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdAccessPoint0()
    {
        return $this->hasOne(Accesspoint::className(), ['id' => 'idAccessPoint']);
    }
}
