<?php namespace backend\tests;

use common\models\Event;
use common\models\User;
use DateTime;

class UserTest extends \Codeception\Test\Unit
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
    public function testCreateUser()
    {
        $user = new User();
        $user->username = 'username';
        $this->assertTrue($user->validate(['username']));
        $user->generateAuthKey();
        $this->assertTrue($user->validate(['auth_key']));
        $user->setPassword('password');
        $this->assertTrue($user->validate(['password_hash']));
        $user->email = 312;
        $this->assertFalse($user->validate(['email']));
        $user->email = 'legit@gmail.com';
        $this->assertTrue($user->validate(['email']));
        $user->status = 10;
        $this->assertTrue($user->validate(['status']));
        $user->created_at = 1606230744;
        $this->assertTrue($user->validate(['created_at']));
        $user->updated_at = 1606230744;
        $this->assertTrue($user->validate(['updated_at']));
        $this->assertTrue($user->save());

        $this->assertEquals('username', $user->username);
    }

    public function testUpdateUser() {
        $user = new User();
        $user->username = 'username';
        $user->generateAuthKey();
        $user->setPassword('password');
        $user->email = 'legit@gmail.com';
        $user->status = 10;
        $user->created_at = 1606230744;
        $user->updated_at = 1606230744;
        $this->assertTrue($user->save());

        $user->username = 'updatedusername';
        $this->assertTrue($user->validate(['username']));
        $this->assertTrue($user->save());

        $this->assertEquals('updatedusername', $user->username);
    }
}