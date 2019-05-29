<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%additional}}`.
 */
class m190528_182613_create_additional_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%additional}}', [
            'id' => $this->primaryKey(),
            'price' => $this->float()->notNull(),
            'qty' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%additional}}');
    }
}
