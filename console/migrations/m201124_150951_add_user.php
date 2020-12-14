<?php

use yii\db\Migration;

/**
 * Class m201124_150951_add_user
 */
class m201124_150951_add_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       /* $this->insert('user',[
           'username' => 'admin',
           'auth_key' => 'zUEZ7wXr4WPuSe707hhCKZo2z-Etl5av',
           'password_hash' => '$2y$13$GU3M0fRAY0SoNhWXp9kok.JSgD8EiwARoy.s.YHsABzcgjsRsllsW',
           'email' => 'admin@admin.com',
           'status' => 10,
           'created_at' => 1606230744,
           'updated_at' => 1606230744,
           'verification_token' => 'nOZ6B9wHjX78tqOAPYW14msLVxLOgcDp_1606230744'
        ]);

        $this->insert('auth_assignment', [
            'item_name' => 'admin',
            'user_id' => 1,
            'created_at' => 1606230745
        ]);*/

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201124_150951_add_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201124_150951_add_user cannot be reverted.\n";

        return false;
    }
    */
}
