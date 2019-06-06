<?php

use yii\db\Migration;

/**
 * Class m190606_155006_alter_length_travel_columns
 */
class m190606_155006_alter_length_travel_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%travel}}', 'from_location', $this->string(255)->notNull());
        $this->alterColumn('{{%travel}}', 'from_address', $this->string(255)->notNull());
        $this->alterColumn('{{%travel}}', 'to_location', $this->string(255)->notNull());
        $this->alterColumn('{{%travel}}', 'to_address', $this->string(255)->notNull());
        $this->alterColumn('{{%travel}}', 'passanger_name', $this->string(255)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%travel}}', 'from_location', $this->string(120)->notNull());
        $this->alterColumn('{{%travel}}', 'from_address', $this->string(120)->notNull());
        $this->alterColumn('{{%travel}}', 'to_location', $this->string(120)->notNull());
        $this->alterColumn('{{%travel}}', 'to_address', $this->string(120)->notNull());
        $this->alterColumn('{{%travel}}', 'passanger_name', $this->string(120)->notNull());
    }

}
