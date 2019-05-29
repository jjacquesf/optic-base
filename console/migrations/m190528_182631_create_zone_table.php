<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%zone}}`.
 */
class m190528_182631_create_zone_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%zone}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(60)->notNull(),
            'points' => $this->text()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%zone}}');
    }
}
