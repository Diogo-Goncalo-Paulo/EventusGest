<?php

use yii\db\Migration;

/**
 * Class m220802_195619_add_field_send_email_events
 */
class m220802_195619_add_field_send_email_events extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('events', 'sendEmails', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('events', 'sendEmails');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220802_195619_add_field_send_email_events cannot be reverted.\n";

        return false;
    }
    */
}
