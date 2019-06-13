<?php

use yii\db\Migration;

/**
 * Handles adding bag to table `{{%travel_vehicle}}`.
 */
class m190611_230712_add_bag_column_to_travel_vehicle_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%travel_vehicle}}', 'bags', $this->tinyInteger()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%travel_vehicle}}', 'bags');
    }
}
