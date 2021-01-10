<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use phpDocumentor\Reflection\DocBlock\Tags\See;

/**
 * Class EventCest
 */
class EventCest
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
        $I->click('Eventos');

        $I->see('','#btnCreate');
        $I->click('#btnCreate');
        $I->fillField('Nome', 'CircuFest');
        $I->fillField('Data de Começo', '2021-01-09 23:42:10');
        $I->fillField('Data de Finalização', '2021-12-09 23:42:10');
        $I->selectOption('#event-users',1);
        $I->click('Guardar');

        $I->see('CircuFest');
        $I->see('Rua');
        $I->see('2021-01-09 23:42:10');
        $I->see('2021-12-09 23:42:10');
        $I->click('Update');

        $I->see('Atualizar Evento: CircuFest');
        $I->fillField('Nome','Betterfest');
        $I->click('Guardar');

        $I->see('Betterfest');
        $I->see('Rua');
        $I->see('2021-01-09 23:42:10');
        $I->see('2021-12-09 23:42:10');
    }
}
