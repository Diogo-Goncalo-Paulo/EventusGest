<?php

use yii\db\Migration;

/**
 * Class m201124_163037_init_rbac
 */
class m201124_163037_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function up()
    {
        $auth = Yii::$app->authManager;

        //Access Point Permissions
        $createAccessPoint = $auth->createPermission('createAccessPoint');
        $createAccessPoint->description = 'create a Access Point for a event';
        $auth->add($createAccessPoint);

        $deleteAccessPoint = $auth->createPermission('deleteAccessPoint');
        $deleteAccessPoint->description = 'delete a Access Point for a event';
        $auth->add($deleteAccessPoint);

        $updateAccessPoint = $auth->createPermission('updateAccessPoint');
        $updateAccessPoint->description = 'update a Access Point for a event';
        $auth->add($updateAccessPoint);

        $viewAccessPoint = $auth->createPermission('viewAccessPoint');
        $viewAccessPoint->description = 'view a Access Point for a event';
        $auth->add($viewAccessPoint);

        $admin = $auth->getRole("admin");

        $auth->addChild($admin, $createAccessPoint);
        $auth->addChild($admin, $deleteAccessPoint);
        $auth->addChild($admin, $updateAccessPoint);
        $auth->addChild($admin, $viewAccessPoint);
    }

    public function down()
    {
        echo "m201124_163037_init_rbac cannot be reverted.\n";

        return false;
    }

}
