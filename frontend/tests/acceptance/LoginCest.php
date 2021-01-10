<?php
namespace frontend\tests\acceptance;

use common\fixtures\UserFixture;
use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class LoginCest
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

    public function LoginHome(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/'));
        $I->see('Eventus Gest');
        $I->seeLink('Login');
        $I->click('Login');

        $I->fillField('Username','admin');
        $I->fillField('Password','adminadmin');
        $I->click('Login','form');

        $I->wait(5);
        $I->see('Logout');
    }
}
