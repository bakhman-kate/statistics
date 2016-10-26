<?php

use yii\db\Migration;

/**
 * Handles the creation of table `client`.
 */
class m161025_145716_create_client_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('client', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'surname' => $this->string(50)->notNull(),
            'phone' => $this->string(20)->notNull(),
            'created' => $this->datetime(),
            'status' => 'ENUM("new", "registered", "refused", "unavailable") NOT NULL DEFAULT "new"', //$this->enum(['new', 'registered', 'refused', 'unavailable'])->notNull()->defaultValue('new')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('client');
    }
}
