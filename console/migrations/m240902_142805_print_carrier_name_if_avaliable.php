<?php

use yii\db\Migration;

/**
 * Class m240902_142805_print_carrier_name_if_avaliable
 */
class m240902_142805_print_carrier_name_if_avaliable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // add printCarrier column to entities table, its a boolean column, allow null
        $this->addColumn('{{%entities}}', 'printCarrier', $this->boolean()->null());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drop printCarrier column from entities table
        $this->dropColumn('{{%entities}}', 'printCarrier');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240902_142805_print_carrier_name_if_avaliable cannot be reverted.\n";

        return false;
    }
    */
}
