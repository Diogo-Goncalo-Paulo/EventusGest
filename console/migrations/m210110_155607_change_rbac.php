<?php

use yii\db\Migration;

/**
 * Class m210110_155607_change_rbac
 */
class m210110_155607_change_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $admin = $auth->getRole("admin");
        $porteiro = $auth->getRole("porteiro");

        $createImpossibleMovement = $auth->createPermission('createImpossibleMovement');
        $createImpossibleMovement->description = 'Create an impossible movement';
        $auth->add($createImpossibleMovement);

        $auth->addChild($admin, $createImpossibleMovement);

        $viewCredential = $auth->getPermission('viewCredential');
        $viewCarrier = $auth->getPermission('viewCarrier');
        $auth->removeChild($admin, $viewCredential);
        $auth->removeChild($admin, $viewCarrier);

        $auth->addChild($porteiro,$viewCredential);
        $auth->addChild($porteiro,$viewCarrier);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210110_155607_change_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210110_155607_change_rbac cannot be reverted.\n";

        return false;
    }
    */
}
