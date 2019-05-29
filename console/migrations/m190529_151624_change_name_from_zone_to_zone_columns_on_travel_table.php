<?php

use yii\db\Migration;

/**
 * Class m190529_151624_change_name_from_zone_to_zone_columns_on_travel_table
 */
class m190529_151624_change_name_from_zone_to_zone_columns_on_travel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%travel}}', 'from_zone', 'from_zone_id');
        $this->renameColumn('{{%travel}}', 'to_zone', 'to_zone_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%travel}}', 'from_zone_id', 'from_zone');
        $this->renameColumn('{{%travel}}', 'to_zone_id', 'to_zone');
    }
}
