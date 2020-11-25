<?php

use yii\db\Migration;

/**
 * Class m201125_164042_change_columns_names
 */
class m201125_164042_change_columns_names extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('accesspoints','nome','name');

        $this->renameColumn('areas','nome','name');

        $this->renameColumn('areasaccesspoints','idPontoAcesso','idAccessPoint');

        $this->renameColumn('carrierstypes','nome','name');

        $this->renameColumn('entities','nome','name');
        $this->renameColumn('entities','idTipoEntidade','idEntityType');

        $this->renameColumn('entitytypes','nome','name');
        $this->renameColumn('entitytypes','qtCredenciais','qtCredentials');

        $this->renameColumn('movements','idCredencial','idCredential');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201125_164042_change_columns_names cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201125_164042_change_columns_names cannot be reverted.\n";

        return false;
    }
    */
}
