<?php

use yii\db\Migration;

/**
 * Class m201214_154714_add_field_event
 */
class m201214_154714_add_field_event extends Migration
{
    public function up()
    {
        $this->addColumn('events', 'default_area', $this->integer());
        $this->addForeignKey('fk-event-default_area', 'events', 'default_area', 'areas', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropColumn('events', 'default_area');
    }

}
