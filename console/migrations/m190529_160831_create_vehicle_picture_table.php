<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vehicle_picture}}`.
 */
class m190529_160831_create_vehicle_picture_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vehicle_picture}}', [
            'id' => $this->primaryKey(),
            'vehicle_id' => $this->integer()->notNull(),
            'file_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vehicle_picture}}');
    }
}
