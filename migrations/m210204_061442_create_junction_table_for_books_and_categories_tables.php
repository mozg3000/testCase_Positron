<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books_categories}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%books}}`
 * - `{{%categories}}`
 */
class m210204_061442_create_junction_table_for_books_and_categories_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books_categories}}', [
						'id' => $this->primaryKey(),
            'books_id' => $this->integer(),
            'categories_id' => $this->integer(),
        ]);

        // creates index for column `books_id`
        $this->createIndex(
            '{{%idx-books_categories-books_id}}',
            '{{%books_categories}}',
            'books_id'
        );

        // add foreign key for table `{{%books}}`
        $this->addForeignKey(
            '{{%fk-books_categories-books_id}}',
            '{{%books_categories}}',
            'books_id',
            '{{%books}}',
            'id',
            'CASCADE'
        );

        // creates index for column `categories_id`
        $this->createIndex(
            '{{%idx-books_categories-categories_id}}',
            '{{%books_categories}}',
            'categories_id'
        );

        // add foreign key for table `{{%categories}}`
        $this->addForeignKey(
            '{{%fk-books_categories-categories_id}}',
            '{{%books_categories}}',
            'categories_id',
            '{{%categories}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%books}}`
        $this->dropForeignKey(
            '{{%fk-books_categories-books_id}}',
            '{{%books_categories}}'
        );

        // drops index for column `books_id`
        $this->dropIndex(
            '{{%idx-books_categories-books_id}}',
            '{{%books_categories}}'
        );

        // drops foreign key for table `{{%categories}}`
        $this->dropForeignKey(
            '{{%fk-books_categories-categories_id}}',
            '{{%books_categories}}'
        );

        // drops index for column `categories_id`
        $this->dropIndex(
            '{{%idx-books_categories-categories_id}}',
            '{{%books_categories}}'
        );

        $this->dropTable('{{%books_categories}}');
    }
}
