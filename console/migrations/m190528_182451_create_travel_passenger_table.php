<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%travel_passenger}}`.
 */
class m190528_182451_create_travel_passenger_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%travel_passenger}}', [
            'id' => $this->primaryKey(),
            'travel_id' => $this->integer()->notNull(),
            'adults' => $this->integer()->notNull(),
            'children' => $this->integer()->notNull(),
            'children_ages' => $this->string(120)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%travel_passenger}}');
    }
}
