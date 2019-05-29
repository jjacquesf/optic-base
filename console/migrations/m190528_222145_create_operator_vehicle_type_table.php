<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%operator_vehicle_type}}`.
 */
class m190528_222145_create_operator_vehicle_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%operator_vehicle_type}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'vehicle_type_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%operator_vehicle_type}}');
    }
}
