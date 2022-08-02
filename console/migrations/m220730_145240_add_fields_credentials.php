<?php

use yii\db\Migration;

/**
 * Class m220730_145240_add_fields_credentials
 */
class m220730_145240_add_fields_credentials extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('credentials', 'allowedStart', $this->dateTime());
        $this->addColumn('credentials', 'allowedEnd', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('credentials', 'allowedStart');
        $this->dropColumn('credentials', 'allowedEnd');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }*/

    public function down()
    {
        echo "m220730_145240_add_fields_credentials cannot be reverted.\n";

        return false;
    }

}
