<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vehicle_zone_rate}}`.
 */
class m190528_183612_create_vehicle_zone_rate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vehicle_zone_rate}}', [
            'id' => $this->primaryKey(),
            'vehicle_type_id' => $this->integer()->notNull(),
            'price' => $this->float()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vehicle_zone_rate}}');
    }
}
