<?php namespace backend\tests;

use common\models\Area;
use common\models\Credential;
use common\models\Entity;
use common\models\Entitytype;
use common\models\Event;
use DateTime;
use Yii;

class credentialsTest extends \Codeception\Test\Unit
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

    // tests
    public function testCreateCredential()
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
        $credential->ucid = null;
        $this->assertFalse($credential->validate(['ucid']));
        $credential->ucid = Yii::$app->security->generateRandomString(8);
        $this->assertTrue($credential->validate(['ucid']));
        $credential->idEntity = 'id';
        $this->assertFalse($credential->validate(['idEntity']));
        $credential->idEntity = $entity->id;
        $this->assertTrue($credential->validate(['idEntity']));
        $credential->idEvent = 'id';
        $this->assertFalse($credential->validate(['idEvent']));
        $credential->idEvent = $event->id;
        $this->assertTrue($credential->validate(['idEvent']));
        $credential->createdAt = null;
        $this->assertFalse($credential->validate(['createdAt']));
        $credential->createdAt = $dateTime;
        $this->assertTrue($credential->validate(['createdAt']));
        $credential->updatedAt = null;
        $this->assertFalse($credential->validate(['updatedAt']));
        $credential->updatedAt = $dateTime;
        $this->assertTrue($credential->validate(['updatedAt']));
        $this->assertTrue($credential->save());
    }

    public function testUpdateCredential() {
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

        $credential->flagged = 'flagged';
        $this->assertFalse($credential->validate(['flagged']));
        $credential->flagged = 5;
        $this->assertTrue($credential->validate(['flagged']));
        $credential->blocked = 'blocked';
        $this->assertFalse($credential->validate(['blocked']));
        $credential->blocked = 0;
        $this->assertTrue($credential->validate(['blocked']));
        $credential->save();

    }

    public function testDeleteCredential() {
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

        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');
        $credential->deletedAt = $dateTime;
        $this->assertTrue($credential->validate(['deletedAt']));
        $this->assertTrue($credential->save());
    }
}