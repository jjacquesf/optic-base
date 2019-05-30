<?php

use yii\db\Migration;

/**
 * Handles adding description to table `{{%zone}}`.
 */
class m190529_211640_add_description_column_to_zone_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%zone}}', 'description', $this->string(60));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%zone}}', 'description');
    }
}
