<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\EventFixture;
use common\fixtures\UserFixture;
use phpDocumentor\Reflection\DocBlock\Tags\See;

/**
 * Class AreaCest
 */
class AreaCest
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
    public function CrudArea(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage('/');
        $I->click('Áreas');

        $I->see('','#btnCreate');
        $I->click('#btnCreate');
        $I->fillField('Nome', 'Restaurante');
        $I->fillField('Tempo para reiniciar', '00:00:00');
        $I->click('Guardar');

        $I->see('Restaurante');
        $I->see('00:00:00');
        $I->click('Atualizar');

        $I->see('Atualizar Área: Restaurante');
        $I->fillField('Nome', 'Bar');
        $I->fillField('Tempo para reiniciar', '01:00:00');
        $I->click('Guardar');

        $I->see('Bar');
        $I->see('01:00:00');
        $I->click('Apagar');

        $I->dontSee('Bar');
        $I->dontSee('01:00:00');
    }
}
