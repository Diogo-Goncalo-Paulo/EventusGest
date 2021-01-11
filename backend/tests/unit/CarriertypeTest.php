<?php namespace backend\tests;

use common\models\Carriertype;
use common\models\Event;
use DateTime;

class CarriertypeTest extends \Codeception\Test\Unit
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
    public function testCreateCarriertype()
    {
        $event = new Event();
        $event->name = 'evento teste';
        $event->startDate = '2020-11-26 15:43:53';
        $event->endDate = '2020-11-26 15:43:53';
        $event->save();
        $this->assertTrue($event->validate());

        $carriertype = new Carriertype();
        $carriertype->name = 1;
        $this->assertFalse($carriertype->validate(['name']));
        $carriertype->name = 'tipo de carregador teste';
        $this->assertTrue($carriertype->validate(['name']));
        $carriertype->idEvent = '$event->id';
        $this->assertFalse($carriertype->validate(['idEvent']));
        $carriertype->idEvent = $event->id;
        $this->assertTrue($carriertype->validate(['idEvent']));
        $this->assertTrue($carriertype->save());
    }

    public function testeUpdateCarriertype() {
        $event = new Event();
        $event->name = 'evento teste';
        $event->startDate = '2020-11-26 15:43:53';
        $event->endDate = '2020-11-26 15:43:53';
        $event->save();

        $carriertype = new Carriertype();
        $carriertype->name = 'tipo de carregador teste';
        $carriertype->idEvent = $event->id;
        $carriertype->save();

        $carriertype->name = 1;
        $this->assertFalse($carriertype->validate(['name']));
        $carriertype->name = 'tipo de carregador atualizado';
        $this->assertTrue($carriertype->validate(['name']));
        $this->assertTrue($carriertype->save());


        $this->assertEquals('tipo de carregador atualizado', $carriertype->name);
    }

    public function testeDeleterea() {
        $event = new Event();
        $event->name = 'evento teste';
        $event->startDate = '2020-11-26 15:43:53';
        $event->endDate = '2020-11-26 15:43:53';
        $event->save();

        $carriertype = new Carriertype();
        $carriertype->name = 'tipo de carregador teste';
        $carriertype->idEvent = $event->id;
        $carriertype->save();

        $dateTime = new DateTime('now');
        $dateTime = $dateTime->format('Y-m-d H:i:s');
        $carriertype->deletedAt = $dateTime;
        $this->assertTrue($carriertype->validate(['deletedAt']));
        $this->assertTrue($carriertype->save());

        $this->assertEquals($dateTime, $carriertype->deletedAt);
    }
}