<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vehicle_type_rate}}`.
 */
class m190528_183612_create_vehicle_type_rate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vehicle_type_rate}}', [
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
        $this->dropTable('{{%vehicle_type_rate}}');
    }
}
