<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vehicle}}`.
 */
class m190528_183538_create_vehicle_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vehicle}}', [
            'id' => $this->primaryKey(),
            'status' => $this->tinyInteger()->notNull(),
            'vehicle_type_id' => $this->integer()->notNull(),
            'plate' => $this->string(10)->notNull(),
            'model' => $this->integer()->notNull(),
            'color' => $this->string(60)->notNull(),
            'default_operator_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vehicle}}');
    }
}
