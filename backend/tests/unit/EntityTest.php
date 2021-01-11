<?php namespace backend\tests;

use common\models\Area;
use common\models\Entity;
use common\models\Entitytype;
use common\models\Event;
use DateTime;
use Yii;

class EntityTest extends \Codeception\Test\Unit
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
    public function testCreateEntity()
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
        $entity->ueid = null;
        $this->assertFalse($entity->validate(['ueid']));
        $entity->ueid = Yii::$app->security->generateRandomString(8);
        $this->assertTrue($entity->validate(['ueid']));
        $entity->name = 1;
        $this->assertFalse($entity->validate(['name']));
        $entity->name = 'entidade teste';
        $this->assertTrue($entity->validate(['name']));
        $entity->weight = 'ads';
        $this->assertFalse($entity->validate(['weight']));
        $entity->weight = 20;
        $this->assertTrue($entity->validate(['weight']));
        $entity->email = 123321;
        $this->assertFalse($entity->validate(['email']));
        $entity->email = "email@email.com";
        $this->assertTrue($entity->validate(['email']));
        $entity->idEntityType = 'das';
        $this->assertFalse($entity->validate(['idEntityType']));
        $entity->idEntityType = $entitytype->id;
        $this->assertTrue($entity->validate(['idEntityType']));
        $this->assertTrue($entity->save());
    }

    public function testUpdateEntity() {
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

        $entity->name = 1;
        $this->assertFalse($entity->validate(['name']));
        $entity->name = 'entidade teste';
        $this->assertTrue($entity->validate(['name']));
        $this->assertTrue($entity->save());
    }

    public function testDeleteEntity () {
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
        $entity->deletedAt = $dateTime;
        $this->assertTrue($entity->validate(['deletedAt']));
        $this->assertTrue($entity->save());
    }
}