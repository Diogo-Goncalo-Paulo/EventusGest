<?php namespace backend\tests;

use app\models\Event;

class EventTest extends \Codeception\Test\Unit
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
    public function testEventCreate()
    {
        $event = new Event();

        $event->name = 'evento teste';
        $event->startDate = '2020-11-26 15:43:53';
        $event->endDate = '2020-11-26 15:43:53';

        $event->save();

        $this->assertTrue($event->save());
    }
}