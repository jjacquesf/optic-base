<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%config}}`.
 */
class m190528_224159_create_config_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%config}}', [
            'id' => $this->primaryKey(),
            'status' => $this->tinyInteger()->notNull(),
            'public_vehicle_rate_id' => $this->integer()->notNull(),
            'public_vehicle_zone_rate_id' => $this->integer()->notNull(), 
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%config}}');
    }
}
