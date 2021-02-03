<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%statuses}}`.
 */
class m210203_104435_add_name_column_to_statuses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%statuses}}', 'name', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%statuses}}', 'name');
    }
}
