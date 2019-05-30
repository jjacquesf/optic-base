<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client_profile}}`.
 */
class m190530_205409_create_client_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client_profile}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'file_id' => $this->integer(),
            'name' => $this->string(60)->notNull(),
            'contact_name' => $this->string(60)->notNull(),
            'contact_phone' => $this->string(25)->notNull(),
            'contact_email' => $this->string(60)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%client_profile}}');
    }
}
