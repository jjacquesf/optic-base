<?php

use yii\db\Migration;

/**
 * Handles adding public to table `{{%rate}}`.
 */
class m190926_172346_add_public_column_to_rate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%rate}}', 'public', $this->tinyInteger()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%rate}}', 'public');
    }
}
