<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%authors}}`.
 */
class m210204_072212_drop_last_name_column_from_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
			$this->dropColumn('{{%authors}}', 'last_name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
			$this->addColumn('{{%authors}}', 'last_name', $this->string(50)->notNull());
    }
}
