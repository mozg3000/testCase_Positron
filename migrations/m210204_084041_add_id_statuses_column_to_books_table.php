<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%books}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%statuses}}`
 */
class m210204_084041_add_id_statuses_column_to_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%books}}', 'id_statuses', $this->integer()->notNull());

        // creates index for column `id_statuses`
        $this->createIndex(
            '{{%idx-books-id_statuses}}',
            '{{%books}}',
            'id_statuses'
        );

        // add foreign key for table `{{%statuses}}`
        $this->addForeignKey(
            '{{%fk-books-id_statuses}}',
            '{{%books}}',
            'id_statuses',
            '{{%statuses}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%statuses}}`
        $this->dropForeignKey(
            '{{%fk-books-id_statuses}}',
            '{{%books}}'
        );

        // drops index for column `id_statuses`
        $this->dropIndex(
            '{{%idx-books-id_statuses}}',
            '{{%books}}'
        );

        $this->dropColumn('{{%books}}', 'id_statuses');
    }
}
