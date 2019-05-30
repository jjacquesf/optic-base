<?php

use yii\db\Migration;

/**
 * Handles adding rate_id to table `{{%vehicle_type_zone_rate}}`.
 */
class m190530_132429_add_rate_id_column_to_vehicle_type_zone_rate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%vehicle_type_zone_rate}}', 'rate_id', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%vehicle_type_zone_rate}}', 'rate_id');
    }
}
