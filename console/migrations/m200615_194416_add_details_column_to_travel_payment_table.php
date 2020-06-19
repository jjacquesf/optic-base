<?php

use yii\db\Migration;

/**
 * Handles adding details to table `{{%travel_payment}}`.
 */
class m200615_194416_add_details_column_to_travel_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%travel_payment}}', 'details', $this->string(255)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%travel_payment}}', 'details');
    }
}
