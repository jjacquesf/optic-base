<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%travel_payment}}`.
 */
class m190528_223052_create_travel_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%travel_payment}}', [
            'id' => $this->primaryKey(),
            'status' => $this->tinyInteger()->notNull(),
            'file_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'travel_id' => $this->integer()->notNull(),
            'type' => $this->tinyInteger()->notNull(),
            'amount' => $this->float()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%travel_payment}}');
    }
}
