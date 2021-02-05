<?php

use yii\db\Migration;

/**
 * Class m210205_125313_alter_isbn_column_in_books_table
 */
class m210205_125313_alter_isbn_column_in_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
			$this->alterColumn('{{%books}}', 'isbn', $this->string(10));
			$this->dropIndex(
            '{{%isbn}}',
            '{{%books}}'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->alterColumn('{{%books}}', 'isbn', $this->string(10)->unique());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210205_125313_alter_isbn_column_in_books_table cannot be reverted.\n";

        return false;
    }
    */
}
