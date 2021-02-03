<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books_authors}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%books}}`
 * - `{{%authors}}`
 */
class m210203_100646_create_junction_table_for_books_and_authors_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books_authors}}', [
						'id' => $this->primaryKey(),
            'books_id' => $this->integer(),
            'authors_id' => $this->integer(),
        ]);

        // creates index for column `books_id`
        $this->createIndex(
            '{{%idx-books_authors-books_id}}',
            '{{%books_authors}}',
            'books_id'
        );

        // add foreign key for table `{{%books}}`
        $this->addForeignKey(
            '{{%fk-books_authors-books_id}}',
            '{{%books_authors}}',
            'books_id',
            '{{%books}}',
            'id',
            'CASCADE'
        );

        // creates index for column `authors_id`
        $this->createIndex(
            '{{%idx-books_authors-authors_id}}',
            '{{%books_authors}}',
            'authors_id'
        );

        // add foreign key for table `{{%authors}}`
        $this->addForeignKey(
            '{{%fk-books_authors-authors_id}}',
            '{{%books_authors}}',
            'authors_id',
            '{{%authors}}',
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
            '{{%fk-books_authors-books_id}}',
            '{{%books_authors}}'
        );

        // drops index for column `books_id`
        $this->dropIndex(
            '{{%idx-books_authors-books_id}}',
            '{{%books_authors}}'
        );

        // drops foreign key for table `{{%authors}}`
        $this->dropForeignKey(
            '{{%fk-books_authors-authors_id}}',
            '{{%books_authors}}'
        );

        // drops index for column `authors_id`
        $this->dropIndex(
            '{{%idx-books_authors-authors_id}}',
            '{{%books_authors}}'
        );

        $this->dropTable('{{%books_authors}}');
    }
}
