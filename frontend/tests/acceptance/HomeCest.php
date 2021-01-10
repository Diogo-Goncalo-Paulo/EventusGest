<?php
namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class HomeCest
{
    public function checkHome(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/'));
        $I->see('Congratulations!');

        $I->seeLink('Entidades');
        $I->click('Entidades');

        $I->see('Entrar');
        $I->click('Entrar');
    }
}
