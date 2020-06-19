<?php

use yii\db\Migration;

/**
 * Handles adding airline to table `{{%optic_travel}}`.
 */
class m200618_164115_add_airline_column_to_optic_travel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%travel}}', 'airline', $this->string(255));
        $this->addColumn('{{%travel}}', 'flight', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%travel}}', 'airline');
        $this->dropColumn('{{%travel}}', 'flight');
    }
}
