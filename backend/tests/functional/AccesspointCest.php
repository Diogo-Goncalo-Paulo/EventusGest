<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\AreaFixture;
use common\fixtures\EventFixture;
use common\fixtures\UserFixture;
use common\models\Area;
use phpDocumentor\Reflection\DocBlock\Tags\See;

/**
 * Class AreaCest
 */
class AccesspointCest
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
            ],
            'area' =>[
                'class' => AreaFixture::className(),
                'dataFile' => codecept_data_dir() . 'area_data.php'
            ],

        ];
    }
    
    /**
     * @param FunctionalTester $I
     */
    public function CrudAccesspoint(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage('/');
        $I->click('Pontos de Acesso');

        $I->see('','#btnCreate');
        $I->click('#btnCreate');
        $I->fillField('Nome', 'Ponto de Acesso 1');
        $I->selectOption('#area-1',1);
        $I->selectOption('#area-2',2);
        $I->click('Guardar');

        $I->see('Ponto de Acesso 1');
        $I->see('Rua');
        $I->see('Recinto');
        $I->click('Atualizar');

        $I->fillField('Nome', 'Ponto de Acesso 2');
        $I->selectOption('#area-1',1);
        $I->selectOption('#area-2',2);
        $I->click('Guardar');

        $I->see('Ponto de Acesso 2');
        $I->see('Rua');
        $I->see('Recinto');
        $I->click('Apagar');

        $I->dontSee('Ponto de Acesso 2');
        $I->dontSee('Rua');
        $I->dontSee('Recinto');
    }
}
