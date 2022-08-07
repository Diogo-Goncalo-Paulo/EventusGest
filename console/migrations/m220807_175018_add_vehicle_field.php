<?php

use yii\db\Migration;

/**
 * Class m220807_175018_add_vehicle_field
 */
class m220807_175018_add_vehicle_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('carriersTypes', 'isCar', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('carriersTypes', 'isCar');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220807_175018_add_vehicle_field cannot be reverted.\n";

        return false;
    }
    */
}
