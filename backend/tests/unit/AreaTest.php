<?php namespace backend\tests;

use common\models\Area;
use common\models\Event;
use DateTime;

class AreaTest extends \Codeception\Test\Unit
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

    public function testCreateArea()
    {
        $event = new Event();
        $event->name = 'evento teste';
        $event->startDate = '2020-11-26 15:43:53';
        $event->endDate = '2020-11-26 15:43:53';
        $event->save();
        $this->assertTrue($event->validate());

        $area = new Area();
        $area->name = 1;
        $this->assertFalse($area->validate(['name']));
        $area->name = 'area teste';
        $this->assertTrue($area->validate(['name']));
        $area->idEvent = '$event->id';
        $this->assertFalse($area->validate(['idEvent']));
        $area->idEvent = $event->id;
        $this->assertTrue($area->validate(['idEvent']));
        $this->assertTrue($area->save());


        $this->assertEquals('area teste', $area->name);
    }

    public function testeUpdateArea() {
        $event = new Event();
        $event->name = 'evento teste';
        $event->startDate = '2020-11-26 15:43:53';
        $event->endDate = '2020-11-26 15:43:53';
        $event->save();

        $area = new Area();
        $area->name = 'area teste';
        $area->idEvent = $event->id;
        $area->save();

        $area->name = 1;
        $this->assertFalse($area->validate(['name']));
        $area->name = 'area atualizada';
        $this->assertTrue($area->validate(['name']));
        $this->assertTrue($area->save());


        $this->assertEquals('area atualizada', $area->name);
    }

    public function testeDeleterea() {
        $event = new Event();
        $event->name = 'evento teste';
        $event->startDate = '2020-11-26 15:43:53';
        $event->endDate = '2020-11-26 15:43:53';
        $event->save();

        $area = new Area();
        $area->name = 'area teste';
        $area->idEvent = $event->id;
        $area->save();

        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');
        $area->deletedAt = $dateTime;
        $this->assertTrue($area->validate(['deletedAt']));
        $this->assertTrue($area->save());
        
        $this->assertEquals($dateTime, $area->deletedAt);
    }
}