<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\AccesspointFixture;
use common\fixtures\AreaFixture;
use common\fixtures\EventFixture;
use common\fixtures\UserFixture;
use phpDocumentor\Reflection\DocBlock\Tags\See;

/**
 * Class UserCest
 */
class UserCest
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ],
            'event' =>[
                'class' => EventFixture::className(),
                'dataFile' => codecept_data_dir() . 'event_data.php'
            ]
        ];
    }
    
    /**
     * @param FunctionalTester $I
     */
    public function CrudEvent(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage('/');
        $I->click('Utilizadores');

        $I->see('','#btnCreate');
        $I->click('#btnCreate');
        $I->fillField('Username', 'rabanete102');
        $I->fillField('Email', 'rabanete102@vegetal.com');
        $I->fillField('Password', 'alforreca7');
        $I->click('Save');

        $I->amOnPage('/user/view?id=2');
        $I->see('rabanete102');
        $I->click('#editBtn');

        $I->see('Editar rabanete102');
        $I->fillField('Nome','Roberto');
        $I->selectOption('#user-role','admin');
        $I->click('Save');

        $I->see('rabanete102');
        $I->see('Roberto');
    }
}
