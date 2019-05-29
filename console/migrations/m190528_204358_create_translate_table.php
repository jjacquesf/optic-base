<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%translate}}`.
 */
class m190528_204358_create_translate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%translate}}', [
            'id' => $this->primaryKey(),
            'object_id' => $this->integer()->notNull(),
            'language' => $this->string(2)->notNull(), 
            'code' => $this->string(60)->notNull(),
            'content' => $this->string(120)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%translate}}');
    }
}
