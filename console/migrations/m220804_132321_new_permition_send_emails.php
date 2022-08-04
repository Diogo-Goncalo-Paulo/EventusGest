<?php

use yii\db\Migration;

/**
 * Class m220804_132321_new_permition_send_emails
 */
class m220804_132321_new_permition_send_emails extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $massMove = $auth->createPermission('sendEmails');
        $massMove->description = 'Send emails with credentials to entities';
        $auth->add($massMove);

        $admin = $auth->getRole("admin");

        $auth->addChild($admin, $massMove);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220804_132321_new_permition_send_emails cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220804_132321_new_permition_send_emails cannot be reverted.\n";

        return false;
    }
    */
}
