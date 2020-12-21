<?php namespace backend\tests;

use common\models\Area;
use common\models\Event;

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

        $area = new Area();
        $area->name = 'area teste';
        $area->idEvent = $event->id;
        $area->save();

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

        $areaUpdate = $area;
        $areaUpdate->name = 'area atualizada';
        $areaUpdate->save();

        $this->assertEquals('area atualizada', $areaUpdate->name);
    }
}