<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%categories}}`
 */
class m210203_095045_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'isbn' => $this->string(10)->unique(),
            'page_count' => $this->integer(),
            'published_date' => $this->datetime()->defaultValue(null),
            'id_categories' => $this->integer(),
            'created_at' => $this->datetime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->datetime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

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

    /**
     * {@inheritdoc}
     */
    public function safeDown()
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

        $this->dropTable('{{%books}}');
    }
}
