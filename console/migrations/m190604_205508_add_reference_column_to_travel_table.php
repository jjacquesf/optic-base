<?php

use yii\db\Migration;

/**
 * Handles adding reference to table `{{%travel}}`.
 */
class m190604_205508_add_reference_column_to_travel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%travel}}', 'reference', $this->string(15)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%travel}}', 'reference');
    }
}
