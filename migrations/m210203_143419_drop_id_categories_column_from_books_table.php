<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%books}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%categories}}`
 */
class m210203_143419_drop_id_categories_column_from_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // drops foreign key for table `{{%categories}}`
        $this->dropForeignKey(
            '{{%fk-books-id_categories}}',
            '{{%books}}'
        );

        // drops index for column `id_categories`
        $this->dropIndex(
            '{{%idx-books-id_categories}}',
            '{{%books}}'
        );

        $this->dropColumn('{{%books}}', 'id_categories');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%books}}', 'id_categories', $this->integer());

        // creates index for column `id_categories`
        $this->createIndex(
            '{{%idx-books-id_categories}}',
            '{{%books}}',
            'id_categories'
        );

        // add foreign key for table `{{%categories}}`
        $this->addForeignKey(
            '{{%fk-books-id_categories}}',
            '{{%books}}',
            'id_categories',
            '{{%categories}}',
            'id',
            'CASCADE'
        );
    }
}
