<?php

use yii\db\Migration;

/**
 * Class m190530_104610_rename_points_column_to_polygon_on_zone_table
 */
class m190530_104610_rename_points_column_to_polygon_on_zone_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%zone}}', 'points', 'polygon');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%zone}}', 'polygon', 'points');
    }
}
