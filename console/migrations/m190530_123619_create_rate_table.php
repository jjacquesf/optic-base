<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rate}}`.
 */
class m190530_123619_create_rate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rate}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(60)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rate}}');
    }
}
