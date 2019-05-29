<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%travel_additional}}`.
 */
class m190528_182458_create_travel_additional_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%travel_additional}}', [
            'id' => $this->primaryKey(),
            'travel_id' => $this->integer()->notNull(),
            'additional_id' => $this->integer()->notNull(),
            'qty' => $this->integer()->notNull(),
            'price' => $this->float()->notNull(),
            'total' => $this->float()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%travel_additional}}');
    }
}
