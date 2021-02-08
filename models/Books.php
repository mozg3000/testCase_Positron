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
class Books extends BooksBase
{
	const SCENARIO_CREATE = 'create book';
	const SCENARIO_UPDATE = 'update book';
	public $image;
	public $statusName;
	public function rules(){
		return array_merge([
			 ['title', 'unique', 'on' => \app\models\Books::SCENARIO_CREATE],
			 ['title', 'exist', 'on' => \app\models\Books::SCENARIO_UPDATE],
			 ['isbn', 'match', 'pattern' => '/^\d{10}|\s$/', 'message' => 'isbn, должен быть десятизначным числом или пустой строкой'],
			 ['isbn', 'unique', 'on' => \app\models\Books::SCENARIO_CREATE],
			 ['isbn', 'exist', 'on' => \app\models\Books::SCENARIO_UPDATE],
			],
			parent::rules()
		);
	}
	public function scenarios(){
		return array_merge([
			self::SCENARIO_CREATE => ['title'],
			self::SCENARIO_UPDATE => ['title'],
	], parent::scenarios());
	}
	public function validateISBN($attribute, $param){
		if($this->isbn !== ''){
			$ISBN = \app\models\Books::find()->byISBN($this->$attribute)->one();
			//var_dump($ISBN);
			if($ISBN){
				$this->addError($attribute, 'Книга с таким ISBN уже добавлена');
			}
		}
	}
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
	public function setPublishedDate(string $value){
		$this->published_date = $value;
	}
}
