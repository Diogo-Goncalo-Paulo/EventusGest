<?php

namespace common\models;

use Da\QrCode\Label;
use Da\QrCode\QrCode;
use Yii;

/**
 * This is the model class for table "credentials".
 *
 * @property int $id
 * @property string $ucid
 * @property int $idEntity
 * @property int|null $idCurrentArea
 * @property int $idEvent
 * @property int $flagged
 * @property int $blocked
 * @property string $createdAt
 * @property string $updatedAt
 * @property string|null $deletedAt
 * @property string $allowedStart
 * @property string|null $allowedEnd
 *
 * @property Carrier $idCarrier0
 * @property Event $idEvent0
 * @property Area $idCurrentArea0
 * @property Entity $idEntity0
 * @property Movement[] $movements
 */
class Credential extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'credentials';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ucid', 'idEntity', 'idEvent', 'createdAt', 'updatedAt'], 'required'],
            [['idEntity', 'idCurrentArea', 'idEvent', 'flagged', 'blocked'], 'integer'],
            [['createdAt', 'updatedAt', 'deletedAt', 'allowedStart', 'allowedEnd'], 'safe'],
            [['ucid'], 'string', 'max' => 8],
            [['ucid'], 'unique'],
            [['idEvent'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['idEvent' => 'id']],
            [['idCurrentArea'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['idCurrentArea' => 'id']],
            [['idEntity'], 'exist', 'skipOnError' => true, 'targetClass' => Entity::className(), 'targetAttribute' => ['idEntity' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ucid' => 'UCID',
            'idEntity' => 'Entidade',
            'idCurrentArea' => 'Area atual',
            'idEvent' => 'Evento',
            'flagged' => 'Marcado',
            'blocked' => 'Bloqueado',
            'createdAt' => 'Criado a',
            'updatedAt' => 'Atualizado a',
            'deletedAt' => 'Eliminado a',
            'allowedStart' => 'Data de acesso de',
            'allowedEnd' => 'Data de acesso a',
        ];
    }

    /**
     * Gets query for [[Carriers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCarrier0()
    {
        return $this->hasOne(Carrier::className(), ['idCredential' => 'id']);
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
     * Gets query for [[IdCurrentArea0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCurrentArea0()
    {
        return $this->hasOne(Area::className(), ['id' => 'idCurrentArea']);
    }

    /**
     * Gets query for [[IdEntity0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdEntity0()
    {
        return $this->hasOne(Entity::className(), ['id' => 'idEntity']);
    }

    /**
     * Gets query for [[Movements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovements()
    {
        return $this->hasMany(Movement::className(), ['idCredential' => 'id']);
    }

    public function createQrCode($size, $margin)
    {
        $label = (new Label($this->ucid))
            ->updateFontSize(25);
        $qrCode = (new QrCode($this->ucid))
            ->setSize($size)
            ->setMargin($margin)
            ->useForegroundColor(0, 0, 0)
            ->setLabel($label);

        $qrCode->writeFile(Yii::getAlias('@backend') . '/web/qrcodes/' . $this->ucid . '.png');
        $qrCode->writeFile(Yii::getAlias('@frontend') . '/web/qrcodes/' . $this->ucid . '.png');

        $this->mergeQrCodeWithLayout();
    }


    public function mergeQrCodeWithLayout()
    {
        $qrCode = imagecreatefrompng(Yii::getAlias('@backend') . '/web/qrcodes/' . $this->ucid . '.png');
        $layout = imagecreatefrompng(Yii::getAlias('@backend') . '/web/qrcodes/credential_layout.png');
        imagecopy($layout, $qrCode, 360, 828, 0, 0, imagesx($qrCode), imagesy($qrCode));

        $white = imagecolorallocate($layout, 255, 255, 255);
        $dark = imagecolorallocate($layout, 19, 19, 19);
        $arialBlack = Yii::getAlias('@backend') . '/web/fonts/ariblk.ttf';
        $arialBold = Yii::getAlias('@backend') . '/web/fonts/aribld.ttf';
        $center = 540;

        $entity = Entity::findOne($this->idEntity);
        $entityName = $entity->name;
        if (strlen($entityName) > 43) {
            $entityName = substr($entityName, 0, 40) . '...';
        }

        $entityType = Entitytype::findOne($entity->idEntityType);
        $entityTypeName = mb_strtoupper($entityType->name);

        $fontSize = 60;
        $forFontWidth = imagettfbbox($fontSize, 0, $arialBlack, $entityTypeName);
        imagettftext($layout, $fontSize, 0, $center - ($forFontWidth[4] / 2), 693, $white, $arialBlack, $entityTypeName);

        $fontSize = 31;
        $forFontWidth = imagettfbbox($fontSize, 0, $arialBold, $entityName);
        imagettftext($layout, $fontSize, 0, $center - ($forFontWidth[4] / 2), 775, $dark, $arialBold, $entityName);

        imagepng($layout, Yii::getAlias('@backend') . '/web/qrcodes/' . $this->ucid . '.png');
    }

}
