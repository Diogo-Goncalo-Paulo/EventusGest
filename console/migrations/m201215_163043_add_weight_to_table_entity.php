<?php

use yii\db\Migration;

/**
 * Class m201215_163043_add_weight_to_table_entity
 */
class m201215_163043_add_weight_to_table_entity extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('entities','weight','int');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201215_163043_add_weight_to_table_entity cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201215_163043_add_weight_to_table_entity cannot be reverted.\n";

        return false;
    }
    */
}
