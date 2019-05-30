<?php

use yii\db\Migration;

/**
 * Handles adding rate_id to table `{{%client}}`.
 */
class m190530_134545_add_rate_id_column_to_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%client}}', 'rate_id', $this->integer()->notNull());
        $this->dropColumn('{{%client}}', 'vehicle_rate_id');
        $this->dropColumn('{{%client}}', 'vehicle_zone_rate_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%client}}', 'rate_id');
        $this->addColumn('{{%client}}', 'vehicle_rate_id', $this->integer()->notNull());
        $this->addColumn('{{%client}}', 'vehicle_zone_rate_id', $this->integer()->notNull());
    }
}
