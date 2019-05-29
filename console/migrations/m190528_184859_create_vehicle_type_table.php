<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vehicle_type}}`.
 */
class m190528_184859_create_vehicle_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vehicle_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(60)->notNull(),
            'max_passangers' => $this->integer()->notNull(),
            'max_bags' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vehicle_type}}');
    }
}
