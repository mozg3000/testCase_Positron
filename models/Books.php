<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $title
 * @property string|null $isbn
 * @property int|null $page_count
 * @property string|null $published_date
 * @property int|null $id_categories
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $thumbnail
 *
 * @property Categories $categories
 * @property BooksAuthors[] $booksAuthors
 */
class Books extends BooksBase
{
	
    /**
     * {@inheritdoc}
     * @return BooksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BooksQuery(get_called_class());
    }
}
