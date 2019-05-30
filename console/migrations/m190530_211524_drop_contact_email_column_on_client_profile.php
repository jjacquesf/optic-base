<?php

use yii\db\Migration;

/**
 * Class m190530_211524_drop_contact_email_column_on_client_profile
 */
class m190530_211524_drop_contact_email_column_on_client_profile extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%client_profile}}', 'contact_email');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%client_profile}}', 'contact_email');
    }

}
