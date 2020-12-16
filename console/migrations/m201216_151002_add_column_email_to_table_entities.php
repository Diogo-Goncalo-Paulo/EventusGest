<?php

use yii\db\Migration;

/**
 * Class m201216_151002_add_column_email_to_table_entities
 */
class m201216_151002_add_column_email_to_table_entities extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('entities','email','string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201216_151002_add_column_email_to_table_entities cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201216_151002_add_column_email_to_table_entities cannot be reverted.\n";

        return false;
    }
    */
}
