<?php

use yii\db\Migration;

/**
 * Class m220901_204708_new_field_credential_check_printed
 */
class m220901_204708_new_field_credential_check_printed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('credentials', 'printed', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220901_204708_new_field_credential_check_printed cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220901_204708_new_field_credential_check_printed cannot be reverted.\n";

        return false;
    }
    */
}
