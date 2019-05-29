<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%travel_vehicle}}`.
 */
class m190528_214440_create_travel_vehicle_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%travel_vehicle}}', [
            'id' => $this->primaryKey(),
            'travel_id' => $this->integer()->notNull(),
            'vehicle_type_id' => $this->integer()->notNull(),
            'vehicle_id' => $this->integer(),
            'operator_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%travel_vehicle}}');
    }
}
