<?php
namespace app\models;
class BookInfo extends \yii\db\ActiveRecord	{
	#############
	# Данные из файла
	public $title = '';
	public $isbn = '';
	public $pageCount = 0;
	public $publishedDate = ['\$date' => ''];
	public $thumbnailUrl = '';
	public $shortDescription = '';
	public $longDescription = '';
	public $status = '';
	public $authors = [];
	public $categories = [];
	#############
	# Данные из БД
	public $id_statuses = 0;
	private $id_books = 0;
	public $id_authors = [];
	private $id_categories = [];
	public $book = null;
	#############
	# Данные для картинки
	private $thumbnailFilePath = '';
	#############
	private $infoFields = [
			'title',
			'isbn',
			'pageCount',
			'publishedDate',
			'thumbnailUrl',
			'shortDescription',
			'longDescription',
			'status',
			'authors',
			'categories'
		];
	public function rules(){
		return [
			[['title', 'id_statuses'], 'required'],
			[['title'], 'validateTitle'],
      [['page_count', 'id_statuses'], 'integer'],
			[$this->infoFields, 'safe'],
			[['short_description', 'long_description'], 'string'],
			[['title', 'thumbnail'], 'string', 'max' => 255],
			[['isbn'], 'string', 'max' => 10],
			['isbn', 'match', 'pattern' => '/^\d{10}|\s$/', 'message' => 'isbn, должен быть десятизначным числом или пустой строкой'],
			[['isbn'], 'validateISBN'],
			[['id_statuses'], 'exist', 'skipOnError' => true, 'targetClass' => Statuses::className(), 'targetAttribute' => ['id_statuses' => 'id']],
		];
	}
	public function validateTitle($attribute, $params){
		if(!$this->isbn){
			$book = \app\models\Books::find()->byTitle($this->$attribute)->one();
			if($book){
				$this->addError($attribute, 'Книга с таким названием уже добавлена');
			}
		}
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
	public function beforeValidate(){
		//echo 'bv'.PHP_EOL;
		$this->id_statuses = $this->getStatusId();
		//var_dump($this->id_statuses);
		return true;
	}
	public function bookExists():bool{
		/* В базе я сделал isbn с возмжностью нуля
		 * Здесь же я полагаю, что он всегда существует, в общем такая вот не связуха...
		 */
		$book = \app\models\Books::find()->byISBN($this->isbn)->one();
		return $book? true: false;
	}
	public function saveBook(\GuzzleHttp\Client $client, string $pathToDownLoadFolder):bool{
		$book = new \app\models\Books();
		$book->title = $this->title;
		$book->isbn = $this->isbn;
		$book->page_count = $this->pageCount;
		$publishedDate = null;
		if(isset($this->publishedDate['$date'])){
			try{
				$publishedDate = (new \DateTime($this->publishedDate['$date']))->format('Y-m-d');
			}catch(\Trowable $e){
				
			}
		}
		$book->published_date = $publishedDate;
		$book->short_description = $this->shortDescription;
		$book->long_description = $this->longDescription;
		$book->id_statuses = $this->getStatusId();
		if($this->thumbnailUrl){
			$this->downLoadThumbnail($client, $pathToDownLoadFolder);
			$book->thumbnail = $this->thumbnailFilePath;
		}
		if($book->save()){
			$this->book = $book;
			return true;
		}
		return false;
	}
	public function saveAuthors():void{
		$this->id_authors = [];
		foreach($this->authors as $authorName){
			if(!$this->authorExists($authorName)){
				$author = new \app\models\Authors();
				$author->name = $authorName;
				if($author->save()){
					$this->id_authors[] = $author->id;
				}
			}
		}
	}
	public function authorExists($name):bool{
		$author = \app\models\Authors::find()->byName($name)->one();
		if($author){
			$this->id_authors[] = $author->id;
			return true;
		}
		return false;
	}
	public function linkBookAndAuthors():void{
		foreach($this->id_authors as $idAuthor){
			$bookAuthor = new \app\models\BooksAuthors();
			$bookAuthor->books_id = $this->book->id;
			$bookAuthor->authors_id = $idAuthor;
			if($bookAuthor->save()){
				
			}
		}
	}
	public function saveStatus():void{
		$status = new \app\models\Statuses();
		$status->name = $this->status;
		if($status->save()){
			$this->id_statuses = $status->id;
		}
	}
	public function statusExists():bool{
		$status = \app\models\Statuses::find()->byName($this->status)->one();
		if($status){
			$this->id_statuses = $status->id;
			return true;
		}
		return false;
	}
	public function getStatusId():int{
		if($this->id_statuses){
			return $this->id_statuses;
		}
		if(!$this->statusExists()){
			$this->saveStatus();
		}
		return $this->id_statuses;
	}
	public function saveCategories():void{
		foreach($this->categories as $categoryName){
			if(!$this->categoryExists($categoryName)){
				$category = new \app\models\Categories();
				$category->name = $categoryName;
				if($category->save()){
					$this->id_categories[] = $category->id;
				}
			}
		}
	}
	public function categoryExists(string $name):bool{
		$category = \app\models\Categories::find()->byName($name)->one();
		if($category){
			$this->id_categories[] = $category->id;
			return true;
		}
		return false;
	}
	public function linkBookAndCategories():void{
		foreach($this->id_categories as $id_categories){
			$booksCategories = new \app\models\BooksCategories();
			$booksCategories->books_id = $this->book->id;
			$booksCategories->categories_id = $id_categories;
			$booksCategories->save();
		}
	}
	public function downLoadThumbnail(\GuzzleHttp\Client $client, string $pathToDownLoadFolder):void{
		$BookThumbnailFolder = $pathToDownLoadFolder . $this->isbn . '/';
		$this->crateBookThumbnailDirectory($BookThumbnailFolder);
		$fullPath = $this->makeFullPathToFile($BookThumbnailFolder);
		$client->request('GET', $this->thumbnailUrl, ['sink' => $fullPath]);
	}
	private function crateBookThumbnailDirectory(string $path):void{
		\yii\helpers\FileHelper::createDirectory($path);
	}
	private function makeFullPathToFile(string $path):string{
		$fileName = $this->extractFilenameFromThumbnailUrl();
		$fullPath = $path . $fileName;
		return $fullPath;
	}
	private function extractFilenameFromThumbnailUrl():string{
		$url = \Guzzle\Http\Url::factory($this->thumbnailUrl)->getPath();
		$urlExploded = explode('/',$url);
		$fileName = $urlExploded[count($urlExploded)-1];
		$this->thumbnailFilePath = $fileName;
		return $fileName;
	}
	public function saveThumbnailPath():void{
		$this->book->thumbnail = $this->thumbnailFilePath;
		$this->book->save();
	}
	public function saveInfo(\GuzzleHttp\Client $client, string $pathToDownLoadFolder){
		$this->saveBook($client, $pathToDownLoadFolder);
		$this->saveAuthors();
		$this->linkBookAndAuthors();
		$this->saveCategories();
		$this->linkBookAndCategories();
		//$this->downLoadThumbnail($client, $pathToDownLoadFolder);
		//$this->saveThumbnailPath();
	}
	public static function tableName()
	{
		return 'books';
	}
}