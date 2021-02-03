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
class BooksBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['page_count', 'id_categories'], 'integer'],
            [['published_date', 'created_at', 'updated_at'], 'safe'],
            [['title', 'thumbnail'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 10],
            [['isbn'], 'unique'],
            [['id_categories'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['id_categories' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'isbn' => 'Isbn',
            'page_count' => 'Page Count',
            'published_date' => 'Published Date',
            'id_categories' => 'Id Categories',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'thumbnail' => 'Thumbnail',
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery|CategoriesQuery
     */
    public function getCategories()
    {
        return $this->hasOne(Categories::className(), ['id' => 'id_categories']);
    }

    /**
     * Gets query for [[BooksAuthors]].
     *
     * @return \yii\db\ActiveQuery|BooksAuthorsQuery
     */
    public function getBooksAuthors()
    {
        return $this->hasMany(BooksAuthors::className(), ['books_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return BooksBaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BooksBaseQuery(get_called_class());
    }
}
