<?php

use yii\db\Migration;

/**
 * Class m220729_202436_new_permition
 */
class m220729_202436_new_permition extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $massMove = $auth->createPermission('massMove');
        $massMove->description = 'Move every credential to default area';
        $auth->add($massMove);

        $admin = $auth->getRole("admin");

        $auth->addChild($admin, $massMove);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220729_202436_new_permition cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220729_202436_new_permition cannot be reverted.\n";

        return false;
    }
    */
}
