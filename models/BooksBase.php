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
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $thumbnail
 * @property string|null $short_description
 * @property string|null $long_description
 * @property int $id_statuses
 *
 * @property Statuses $statuses
 * @property BooksAuthors[] $booksAuthors
 * @property BooksCategories[] $booksCategories
 */
class BooksBase extends \yii\db\ActiveRecord
{
	private $thumbnail;
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
            [['title', 'id_statuses'], 'required'],
            [['page_count', 'id_statuses'], 'integer'],
            [['published_date', 'created_at', 'updated_at'], 'safe'],
            [['short_description', 'long_description'], 'string'],
            [['title', 'thumbnail'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 10],
            [['id_statuses'], 'exist', 'skipOnError' => true, 'targetClass' => Statuses::className(), 'targetAttribute' => ['id_statuses' => 'id']],
        ];
    }
	public function fields(){
		return [
			'title',
			'isbn',
			'page_count',
			'shot_description',
			'long_description',
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'thumbnail' => 'Thumbnail',
            'short_description' => 'Short Description',
            'long_description' => 'Long Description',
            'id_statuses' => 'Id Statuses',
        ];
    }

    /**
     * Gets query for [[Statuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatuses()
    {
        return $this->hasOne(Statuses::className(), ['id' => 'id_statuses']);
    }

    /**
     * Gets query for [[BooksAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooksAuthors()
    {
        return $this->hasMany(BooksAuthors::className(), ['books_id' => 'id']);
    }

    /**
     * Gets query for [[BooksCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooksCategories()
    {
        return $this->hasMany(BooksCategories::className(), ['books_id' => 'id']);
    }
}
