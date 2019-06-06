<?php

use yii\db\Migration;

/**
 * Handles adding m190604_223539_add_dropoff_column_to_travel_table to table `{{%travel}}`.
 */
class m190604_223539_add_dropoff_column_to_travel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%travel}}', 'dropoff', $this->datetime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%travel}}', 'dropoff');
    }
}
