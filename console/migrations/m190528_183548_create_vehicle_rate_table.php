<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vehicle_rate}}`.
 */
class m190528_183548_create_vehicle_rate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vehicle_rate}}', [
            'id' => $this->primaryKey(),
            'vehicle_type_id' => $this->integer()->notNull(),
            'two_way' => $this->tinyInteger()->notNull(),
            'zone_id' => $this->integer()->notNull(),
            'zone2_id' => $this->integer()->notNull(),
            'price' => $this->float()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vehicle_rate}}');
    }
}
