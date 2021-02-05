<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%authors}}`.
 */
class m210204_072312_drop_middle_name_column_from_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
			$this->dropColumn('{{%authors}}', 'middle_name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
			$this->addColumn('{{%authors}}', 'middle_name', $this->string(50)->notNull());
    }
}
