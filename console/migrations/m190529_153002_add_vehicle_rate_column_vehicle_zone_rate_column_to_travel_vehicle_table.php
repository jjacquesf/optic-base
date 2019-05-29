<?php

use yii\db\Migration;

/**
 * Handles adding vehicle_rate_column_vehicle_zone_rate to table `{{%travel_vehicle}}`.
 */
class m190529_153002_add_vehicle_rate_column_vehicle_zone_rate_column_to_travel_vehicle_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%travel_vehicle}}', 'vehicle_rate', $this->float()->notNull());
        $this->addColumn('{{%travel_vehicle}}', 'vehicle_zone_rate', $this->float()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%travel_vehicle}}', 'vehicle_rate');
        $this->dropColumn('{{%travel_vehicle}}', 'vehicle_zone_rate');
    }
}
