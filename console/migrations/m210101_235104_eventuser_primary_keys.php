<?php

use yii\db\Migration;

/**
 * Class m210101_235104_eventuser_primary_keys
 */
class m210101_235104_eventuser_primary_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addPrimaryKey("pk_ids", "eventsusers", ["idEvent", "idUsers"]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropPrimaryKey("pk_ids", "eventsusers");
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210101_235104_eventuser_primary_keys cannot be reverted.\n";

        return false;
    }
    */
}
