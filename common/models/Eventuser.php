<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "eventsusers".
 *
 * @property int $idEvent
 * @property int $idUsers
 *
 * @property Event $idEvent0
 * @property User $idUsers0
 */
class Eventuser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'eventsusers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idEvent', 'idUsers'], 'required'],
            [['idEvent', 'idUsers'], 'integer'],
            [['idEvent'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['idEvent' => 'id']],
            [['idUsers'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['idUsers' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idEvent' => 'Id Event',
            'idUsers' => 'Id Users',
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
     * Gets query for [[IdUsers0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsers0()
    {
        return $this->hasOne(User::className(), ['id' => 'idUsers']);
    }
}
