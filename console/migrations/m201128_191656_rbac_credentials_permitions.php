<?php

use yii\db\Migration;

/**
 * Class m201128_191656_rbac_credentials_permitions
 */
class m201128_191656_rbac_credentials_permitions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        //Access Point Permissions
        $blockCredential = $auth->createPermission('blockCredential');
        $blockCredential->description = 'Block or unblock a credential a credential';
        $auth->add($blockCredential);

        $flagCredential = $auth->createPermission('flagCredential');
        $flagCredential->description = 'Flag a credential';
        $auth->add($flagCredential);

        $porteiro = $auth->getRole("porteiro");
        $admin = $auth->getRole("admin");

        $auth->addChild($porteiro, $flagCredential);
        $auth->addChild($admin, $blockCredential);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201128_191656_rbac_credentials_permitions cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201128_191656_rbac_credentials_permitions cannot be reverted.\n";

        return false;
    }
    */
}
