<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%authors}}`.
 */
class m210204_072402_add_name_column_to_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
			$this->addColumn('{{%authors}}', 'name', $this->string(100)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
			$this->dropColumn('{{%authors}}', 'name');
    }
}
