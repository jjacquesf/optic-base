<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sequence}}`.
 */
class m190604_204507_create_sequence_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sequence}}', [
            'id' => $this->primaryKey(),
            'prefix' => $this->string(3)->notNull(),
            'current' => $this->integer()->notNull(),
        ]);

        $this->batchInsert('{{%sequence}}', ['prefix', 'current'], [
            ['L', 0],
            ['S', 0],
            ['LC', 0],
            ['SC', 0],
            ['E', 0],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sequence}}');
    }
}
