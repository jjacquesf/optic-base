<?php

use yii\db\Migration;

/**
 * Handles adding rate_id to table `{{%config}}`.
 */
class m190530_204344_add_rate_id_column_to_config_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%config}}', 'rate_id', $this->integer()->notNull());
        $this->dropColumn('{{%config}}', 'public_vehicle_rate_id');
        $this->dropColumn('{{%config}}', 'public_vehicle_zone_rate_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%config}}', 'rate_id');
        $this->addColumn('{{%config}}', 'public_vehicle_rate_id', $this->integer()->notNull());
        $this->addColumn('{{%config}}', 'public_vehicle_zone_rate_id', $this->integer()->notNull());
    }
}
