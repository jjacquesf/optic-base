<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%travel}}`.
 */
class m190528_181503_create_travel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%travel}}', [
            'id' => $this->primaryKey(),
            'status' => $this->integer()->notNull(),
            'type' => $this->tinyInteger()->notNull(),
            'payed_status' => $this->integer()->notNull(),
            'client_id' => $this->integer()->notNull(),
            
            'user_id' => $this->integer(),
            'created_at' => $this->dateTime()->notNull(),

            'previous_travel_id' => $this->integer(),
            'service_id' => $this->integer()->notNull(),
            
            'from_zone' => $this->integer()->notNull(),
            'from_location' => $this->string(120)->notNull(),
            'from_address' => $this->string(120)->notNull(),
            
            'to_zone' => $this->integer()->notNull(),
            'to_location' => $this->string(120)->notNull(),
            'to_address' => $this->string(120)->notNull(),
            
            'passanger_name' => $this->string(120)->notNull(),
            'pickup' => $this->dateTime()->notNull(),

            'total' => $this->float()->notNull(),
            'payed' => $this->float()->notNull(),
            'balance' => $this->float()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%travel}}');
    }
}
