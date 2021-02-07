<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "books".
 *
 */
class Books extends BooksBase
{
	const SCENARIO_CREATE = 'create book';
	const SCENARIO_UPDATE = 'update book';
	public $image;
	public $statusName;
    /**
     * {@inheritdoc}
     * @return BooksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BooksQuery(get_called_class());
    }
	public function getStatus(){
		return $this->statusName?$this->statusName:$this->statuses->name;
	}
	public function getAuthors(){
		return $this->hasMany(\app\models\Authors::className(),['id' => 'authors_id'])->via('booksAuthors');
	}
	public function getAuthorsList(){
		return implode(', ', $this->authors);
	}
	public function getCategories(){
		return $this->hasMany(\app\models\Categories::class, ['id' => 'categories_id'])->via('booksCategories');
	}
	public function getCategoriesList(){
		return implode(', ', $this->categories);
	}
	public function getPublishedDate(){
		return $this->published_date?(new \DateTime($this->published_date))->format('d.m.Y'):'';
	}
}
