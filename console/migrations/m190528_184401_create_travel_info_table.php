<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%travel_info}}`.
 */
class m190528_184401_create_travel_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%travel_info}}', [
            'id' => $this->primaryKey(),
            'travel_id' => $this->integer()->notNull(),
            'code' => $this->string(60)->notNull(),
            'content' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%travel_info}}');
    }
}
