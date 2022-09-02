<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "entities".
 *
 * @property int $id
 * @property string $ueid
 * @property string $name
 * @property string $email
 * @property int $idEntityType
 * @property int $weight
 * @property string $createdAt
 * @property string $updatedAt
 * @property string|null $deletedAt
 * @property string $allowedStart
 * @property string|null $allowedEnd
 *
 * @property Credential[] $credentials
 * @property Entitytype $idEntityType0
 * @property int $maxCredentials
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
            [['ueid', 'name', 'idEntityType','weight','email'], 'required'],
            [['idEntityType','weight'], 'integer'],
            [['createdAt', 'updatedAt', 'deletedAt'], 'safe'],
            [['ueid'], 'string', 'max' => 8],
            [['ueid'], 'unique'],
            [['email'], 'email'],
            [['name'], 'string', 'max' => 255],
            [['idEntityType'], 'exist', 'skipOnError' => true, 'targetClass' => Entitytype::className(), 'targetAttribute' => ['idEntityType' => 'id']],
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
            'name' => 'Nome',
            'email' => 'Email',
            'weight' => 'Peso',
            'idEntityType' => 'Tipo de Entidade',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'deletedAt' => 'Deleted At',
            'allowedStart' => 'Data de acesso de',
            'allowedEnd' => 'Data de acesso a',
        ];
    }

    /**
     * Gets query for [[Credentials]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCredentials()
    {
        return $this->hasMany(Credential::className(), ['idEntity' => 'id'])->where(['deletedAt' => null]);
    }

    /**
     * Gets query for [[idEntityType0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdEntityType0()
    {
        return $this->hasOne(Entitytype::className(), ['id' => 'idEntityType']);
    }

    public function getMaxCredentials(){

        return $this->idEntityType0->qtCredentials * $this->weight;
    }

    public function afterSave($insert, $changedAttributes){
        $currentEvent = Event::findOne(User::findOne(Yii::$app->user->id)->getEvent());

        if($currentEvent->sendEmails == true)   
            Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'sendEntity-html'],
                    ['entity' => $this]
                )
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                ->setTo($this->email)
                ->setSubject('Entidade registada em ' . Yii::$app->name)
                ->send();
    }
}
