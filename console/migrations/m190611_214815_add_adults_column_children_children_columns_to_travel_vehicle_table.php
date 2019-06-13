<?php

use yii\db\Migration;

/**
 * Handles adding adults_column_children_children to table `{{%travel_vehicle}}`.
 */
class m190611_214815_add_adults_column_children_children_columns_to_travel_vehicle_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%travel_vehicle}}', 'adults', $this->tinyInteger()->notNull());
        $this->addColumn('{{%travel_vehicle}}', 'children', $this->tinyInteger()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%travel_vehicle}}', 'adults');
        $this->dropColumn('{{%travel_vehicle}}', 'children');
    }
}
