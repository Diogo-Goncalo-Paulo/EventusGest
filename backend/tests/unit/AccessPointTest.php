<?php namespace backend\tests;

use common\models\Accesspoint;

class AccessPointTest extends \Codeception\Test\Unit
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
    public function testCreateAccessPoint()
    {
        $accesspoint = new Accesspoint();
    }
}