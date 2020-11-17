<?php

namespace app\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "movements".
 *
 * @property int $id
 * @property string $time
 * @property int $idCredencial
 * @property int $idAccessPoint
 * @property int $idAreaFrom
 * @property int $idAreaTo
 * @property int $idUser
 *
 * @property Area $idAreaFrom0
 * @property Area $idAreaTo0
 * @property User $idUser0
 * @property Credential $idCredencial0
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
            [['idCredencial', 'idAccessPoint', 'idAreaFrom', 'idAreaTo', 'idUser'], 'required'],
            [['idCredencial', 'idAccessPoint', 'idAreaFrom', 'idAreaTo', 'idUser'], 'integer'],
            [['idAreaFrom'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['idAreaFrom' => 'id']],
            [['idAreaTo'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['idAreaTo' => 'id']],
            [['idUser'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['idUser' => 'id']],
            [['idCredencial'], 'exist', 'skipOnError' => true, 'targetClass' => Credential::className(), 'targetAttribute' => ['idCredencial' => 'id']],
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
            'time' => 'Time',
            'idCredencial' => 'Id Credencial',
            'idAccessPoint' => 'Id Access Point',
            'idAreaFrom' => 'Id Area From',
            'idAreaTo' => 'Id Area To',
            'idUser' => 'Id User',
        ];
    }

    /**
     * Gets query for [[IdAreaFrom0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdAreaFrom0()
    {
        return $this->hasOne(Areas::className(), ['id' => 'idAreaFrom']);
    }

    /**
     * Gets query for [[IdAreaTo0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdAreaTo0()
    {
        return $this->hasOne(Areas::className(), ['id' => 'idAreaTo']);
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
     * Gets query for [[IdCredencial0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCredencial0()
    {
        return $this->hasOne(Credential::className(), ['id' => 'idCredencial']);
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
