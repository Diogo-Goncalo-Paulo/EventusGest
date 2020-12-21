<?php namespace backend\tests;

use common\models\Event;
use DateTime;

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
    public function testCreateEvent()
    {
        $event = new Event();
        $event->name = 'evento teste';
        $event->startDate = '2020-11-26 15:43:53';
        $event->endDate = '2020-11-26 15:43:53';
        $event->save();

        $this->tester->seeRecord('common\models\Event', ['name' => 'evento teste']);
    }

    public function testUpdateEvent() {
        $event = $this->tester->haveRecord('common\models\Event', [
           'name' => 'evento teste',
           'startDate' => '2020-11-26 15:43:53',
           'endDate' => '2020-11-26 15:43:53'
        ]);

        $eventUpdate = Event::findOne($event);
        $eventUpdate->name = 'update event';
        $eventUpdate->save();

        $this->assertEquals('update event', $eventUpdate->name);
    }

    public function testeDeleteEvent() {
        $event = $this->tester->haveRecord('common\models\Event', [
            'name' => 'evento teste',
            'startDate' => '2020-11-26 15:43:53',
            'endDate' => '2020-11-26 15:43:53'
        ]);

        $eventDelete = Event::findOne($event);
        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');
        $eventDelete->deletedAt = $dateTime;
        $eventDelete->save();

        $this->assertEquals($dateTime, $eventDelete->deletedAt);
    }
}