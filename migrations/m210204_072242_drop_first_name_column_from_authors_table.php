<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%authors}}`.
 */
class m210204_072242_drop_first_name_column_from_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
			$this->dropColumn('{{%authors}}', 'first_name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
			$this->addColumn('{{%authors}}', 'first_name', $this->string(50)->notNull());
    }
}
