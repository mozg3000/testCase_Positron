<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%books}}`.
 */
class m210203_101759_add_thumbnail_column_to_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%books}}', 'thumbnail', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%books}}', 'thumbnail');
    }
}
