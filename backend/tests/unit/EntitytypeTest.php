<?php namespace backend\tests;

use common\models\Area;
use common\models\Entitytype;
use common\models\Entitytypeareas;
use common\models\Event;
use DateTime;

class EntitytypeTest extends \Codeception\Test\Unit
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
    public function testCreateEntitytype()
    {
        $event = new Event();
        $event->name = 'evento teste';
        $event->startDate = '2020-11-26 15:43:53';
        $event->endDate = '2020-11-26 15:43:53';
        $event->save();
        $this->assertTrue($event->validate());

        $area = new Area();
        $area->name = 'area teste';
        $area->idEvent = $event->id;
        $area->save();
        $this->assertTrue($area->validate());

        $entitytype = new Entitytype();
        $entitytype->name = 1;
        $this->assertFalse($entitytype->validate(['name']));
        $entitytype->name = 'tipo de entidade teste';
        $this->assertTrue($entitytype->validate(['name']));
        $entitytype->qtCredentials = "teste";
        $this->assertFalse($entitytype->validate(['qtCredentials']));
        $entitytype->qtCredentials = 20;
        $this->assertTrue($entitytype->validate(['qtCredentials']));
        $entitytype->idEvent = "aaa";
        $this->assertFalse($entitytype->validate(['idEvent']));
        $entitytype->idEvent = $event->id;
        $this->assertTrue($entitytype->validate(['idEvent']));
        $this->assertTrue($entitytype->save());

        $entitytypearea = new Entitytypeareas();
        $entitytypearea->idEntityType = $entitytype->id;
        $entitytypearea->idArea = $area->id;
        $entitytypearea->save();
    }

    public function testUpdateEntitytype()
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

        $entitytype->name = 1;
        $this->assertFalse($entitytype->validate(['name']));
        $entitytype->name = 'tipo de entidade atualizado';
        $this->assertTrue($entitytype->validate(['name']));
        $this->assertTrue($entitytype->save());

        $entitytypearea = new Entitytypeareas();
        $entitytypearea->idEntityType = $entitytype->id;
        $entitytypearea->idArea = $area->id;
        $entitytypearea->save();

        $this->assertEquals('tipo de entidade atualizado', $entitytype->name);
    }

    public function testDeleteEntitytype() {
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

        $entitytypearea = new Entitytypeareas();
        $entitytypearea->idEntityType = $entitytype->id;
        $entitytypearea->idArea = $area->id;
        $entitytypearea->save();

        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');
        $entitytype->deletedAt = $dateTime;
        $this->assertTrue($entitytype->validate(['deletedAt']));
        $this->assertTrue($entitytype->save());
    }
}