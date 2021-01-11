<?php namespace backend\tests;

use common\models\Accesspoint;
use common\models\Area;
use common\models\Event;
use DateTime;

class AccesspointTest extends \Codeception\Test\Unit
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

    public function testCreateAccesspoint()
    {
        $event = new Event();
        $event->name = 'evento teste';
        $event->startDate = '2020-11-26 15:43:53';
        $event->endDate = '2020-11-26 15:43:53';
        $event->save();
        $this->assertTrue($event->validate());

        $area1 = new Area();
        $area1->name = 'area teste';
        $area1->idEvent = $event->id;
        $area1->save();
        $this->assertTrue($area1->validate());

        $area2 = new Area();
        $area2->name = 'area teste';
        $area2->idEvent = $event->id;
        $area2->save();
        $this->assertTrue($area2->validate());

        $accesspoint = new Accesspoint();
        $accesspoint->name = 1;
        $this->assertFalse($accesspoint->validate(['name']));
        $accesspoint->name = 'Ponto de Acesso 1';
        $this->assertTrue($accesspoint->validate(['name']));
        $this->assertTrue($accesspoint->save());

        $this->assertEquals('Ponto de Acesso 1', $accesspoint->name);
    }

    public function testeUpdateAccesspoint() {
        $event = new Event();
        $event->name = 'evento teste';
        $event->startDate = '2020-11-26 15:43:53';
        $event->endDate = '2020-11-26 15:43:53';
        $event->save();

        $area1 = new Area();
        $area1->name = 'area teste';
        $area1->idEvent = $event->id;
        $area1->save();
        $this->assertTrue($area1->validate());

        $area2 = new Area();
        $area2->name = 'area teste';
        $area2->idEvent = $event->id;
        $area2->save();
        $this->assertTrue($area2->validate());

        $accesspoint = new Accesspoint();
        $accesspoint->name = 'Ponto de Acesso 1';
        $accesspoint->save();

        $accesspoint->name = 1;
        $this->assertFalse($accesspoint->validate(['name']));
        $accesspoint->name = 'PA atualizado';
        $this->assertTrue($accesspoint->validate(['name']));
        $this->assertTrue($accesspoint->save());


        $this->assertEquals('PA atualizado', $accesspoint->name);
    }

    public function testeDeleteAccesspoint() {
        $event = new Event();
        $event->name = 'evento teste';
        $event->startDate = '2020-11-26 15:43:53';
        $event->endDate = '2020-11-26 15:43:53';
        $event->save();

        $area1 = new Area();
        $area1->name = 'area teste';
        $area1->idEvent = $event->id;
        $area1->save();
        $this->assertTrue($area1->validate());

        $area2 = new Area();
        $area2->name = 'area teste';
        $area2->idEvent = $event->id;
        $area2->save();
        $this->assertTrue($area2->validate());

        $accesspoint = new Accesspoint();
        $accesspoint->name = 'Ponto de Acesso 1';
        $accesspoint->save();

        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');
        $accesspoint->deletedAt = $dateTime;
        $this->assertTrue($accesspoint->validate(['deletedAt']));
        $this->assertTrue($accesspoint->save());

        $this->assertEquals($dateTime, $accesspoint->deletedAt);
    }
}