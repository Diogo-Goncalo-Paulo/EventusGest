<?php namespace backend\tests;

use common\models\Area;
use common\models\Carrier;
use common\models\Carriertype;
use common\models\Credential;
use common\models\Entity;
use common\models\Entitytype;
use common\models\Event;
use DateTime;
use Yii;

class CarrierTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testCreateCarrier()
    {
        $event = new Event();
        $event->name = 'evento teste';
        $event->startDate = '2020-11-26 15:43:53';
        $event->endDate = '2020-11-26 15:43:53';
        $event->save();

        $area = new Area();
        $area->name = 'area teste';
        $area->idEvent = $event->id;
        $area->save();

        $entitytype = new Entitytype();
        $entitytype->name = 'tipo de entidade teste';
        $entitytype->qtCredentials = 20;
        $entitytype->idEvent = $event->id;
        $entitytype->save();

        $entity = new Entity();
        $entity->ueid = Yii::$app->security->generateRandomString(8);
        $entity->name = 'entidade teste';
        $entity->weight = 20;
        $entity->email = "email@email.com";
        $entity->idEntityType = $entitytype->id;
        $entity->save();

        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');

        $credential = new Credential();
        $credential->ucid = Yii::$app->security->generateRandomString(8);
        $credential->idEntity = $entity->id;
        $credential->idEvent = $event->id;
        $credential->createdAt = $dateTime;
        $credential->updatedAt = $dateTime;
        $credential->save();

        $carriertype = new Carriertype();
        $carriertype->name = 'tipo de portador teste';
        $carriertype->idEvent = $event->id;
        $carriertype->save();

        $carrier = new Carrier();
        $carrier->name = null;
        $this->assertFalse($carrier->validate(['name']));
        $carrier->name = 'Nome Teste';
        $this->assertTrue($carrier->validate(['name']));
        $carrier->info = 'Teste de info';
        $this->assertTrue($carrier->validate(['info']));
        $carrier->photo = 'namephoto.png';
        $this->assertTrue($carrier->validate(['photo']));
        $carrier->idCredential = 'Falha Se faz favor';
        $this->assertFalse($carrier->validate(['idCredential']));
        $carrier->idCredential = $credential->id;
        $this->assertTrue($carrier->validate(['idCredential']));
        $carrier->idCarrierType = 'Falha Se faz favor';
        $this->assertFalse($carrier->validate(['idCarrierType']));
        $carrier->idCarrierType = $carriertype->id;
        $this->assertTrue($carrier->validate(['idCredential']));
        $carrier->createdAt = null;
        $this->assertTrue($carrier->validate(['createdAt']));
        $carrier->createdAt = $dateTime;
        $this->assertTrue($carrier->validate(['createdAt']));
        $carrier->updatedAt = null;
        $this->assertTrue($carrier->validate(['updatedAt']));
        $carrier->updatedAt = $dateTime;
        $this->assertTrue($carrier->validate(['updatedAt']));
        $this->assertTrue($credential->save());
    }

    public function testeUpdateCarrier() {
        $event = new Event();
        $event->name = 'evento teste';
        $event->startDate = '2020-11-26 15:43:53';
        $event->endDate = '2020-11-26 15:43:53';
        $event->save();

        $area = new Area();
        $area->name = 'area teste';
        $area->idEvent = $event->id;
        $area->save();

        $entitytype = new Entitytype();
        $entitytype->name = 'tipo de entidade teste';
        $entitytype->qtCredentials = 20;
        $entitytype->idEvent = $event->id;
        $entitytype->save();

        $entity = new Entity();
        $entity->ueid = Yii::$app->security->generateRandomString(8);
        $entity->name = 'entidade teste';
        $entity->weight = 20;
        $entity->email = "email@email.com";
        $entity->idEntityType = $entitytype->id;
        $entity->save();

        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');

        $credential = new Credential();
        $credential->ucid = Yii::$app->security->generateRandomString(8);
        $credential->idEntity = $entity->id;
        $credential->idEvent = $event->id;
        $credential->createdAt = $dateTime;
        $credential->updatedAt = $dateTime;
        $credential->save();

        $carriertype = new Carriertype();
        $carriertype->name = 'tipo de portador teste';
        $carriertype->idEvent = $event->id;
        $carriertype->save();

        $carrier = new Carrier();
        $carrier->name = 'Nome Teste';
        $carrier->info = 'Teste de info';
        $carrier->photo = 'namephoto.png';
        $carrier->idCredential = $credential->id;
        $carrier->idCarrierType = $carriertype->id;
        $carrier->createdAt = $dateTime;
        $carrier->updatedAt = $dateTime;
        $carrier->save();

        $carrier->name = 1;
        $this->assertFalse($carrier->validate(['name']));
        $carrier->name = 'Novo Nome';
        $this->assertTrue($carrier->validate(['name']));
        $this->assertTrue($carrier->save());

        $this->assertEquals('Novo Nome', $carrier->name);
    }

    public function testeDeleteCarrier() {
        $event = new Event();
        $event->name = 'evento teste';
        $event->startDate = '2020-11-26 15:43:53';
        $event->endDate = '2020-11-26 15:43:53';
        $event->save();

        $area = new Area();
        $area->name = 'area teste';
        $area->idEvent = $event->id;
        $area->save();

        $entitytype = new Entitytype();
        $entitytype->name = 'tipo de entidade teste';
        $entitytype->qtCredentials = 20;
        $entitytype->idEvent = $event->id;
        $entitytype->save();

        $entity = new Entity();
        $entity->ueid = Yii::$app->security->generateRandomString(8);
        $entity->name = 'entidade teste';
        $entity->weight = 20;
        $entity->email = "email@email.com";
        $entity->idEntityType = $entitytype->id;
        $entity->save();

        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');

        $credential = new Credential();
        $credential->ucid = Yii::$app->security->generateRandomString(8);
        $credential->idEntity = $entity->id;
        $credential->idEvent = $event->id;
        $credential->createdAt = $dateTime;
        $credential->updatedAt = $dateTime;
        $credential->save();

        $carriertype = new Carriertype();
        $carriertype->name = 'tipo de portador teste';
        $carriertype->idEvent = $event->id;
        $carriertype->save();

        $carrier = new Carrier();
        $carrier->name = 'Nome Teste';
        $carrier->info = 'Teste de info';
        $carrier->photo = 'namephoto.png';
        $carrier->idCredential = $credential->id;
        $carrier->idCarrierType = $carriertype->id;
        $carrier->createdAt = $dateTime;
        $carrier->updatedAt = $dateTime;
        $carrier->save();

        $carrier->deletedAt = $dateTime;
        $this->assertTrue($carrier->validate(['deletedAt']));
        $this->assertTrue($carrier->save());

        $this->assertEquals($dateTime, $carrier->deletedAt);
    }
}