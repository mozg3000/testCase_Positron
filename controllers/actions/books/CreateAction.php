<?php
namespace app\controllers\actions\books;
class CreateAction extends \yii\base\Action{
	public $modelClass;
	public $checkAccess;
	public function run(){
		if($this->checkAccess){
			call_user_func($this->checkAccess, $this->id);
		}
		$model = new $this->modelClass();
		$status = new \app\models\Statuses();
		if(\Yii::$app->request->isPost){
			//$bookInfo = new \app\models\BookInfo();
			$bookInfo = \Yii::$app->request->Post();
		// var_dump($bookInfo['Books']['categoriesList']);die;
			$model->load($bookInfo);
			// var_dump($bookInfo['Statuses']['name']);die;
			$statusName = $bookInfo['Statuses']['name'];
			$statusFound = \app\models\Statuses::find()->byName($statusName)->one();
			$status->name = $statusName;
			// var_dump($statusFound);
			$category = null;
			if($statusFound){
				$model->id_statuses = $statusFound->id;
				if($model->save()){
					$categories = explode(',', $bookInfo['Books']['categoriesList']);
					if($categories){
						foreach($categories as $categoryName){
							$categoryFound = \app\models\Categories::find()->byName($categoryName);
							$booksCategories = new \app\models\BooksCategories();
							if(!$categoryFound){
								$category = new \app\models\Categoies();
								$category->name = $categoryName;
								if($category->save()){
									$booksCategories->categories_id = $category->id;
									$booksCategories->books_id = $model->id;
									$booksCategories->save();
								}
							}else{
								$booksCategories->categories_id = $categoryFound->id;
								$booksCategories->books_id = $model->id;
								$booksCategories->save();
							}
							
						}
					}
					}
					$authors = explode(',', $bookInfo['Books']['authorsList']);
					if($authors){
						foreach($authors as $authorName){
							$authorFound = \app\models\Authors::find()->byName($authorName)->one();
							$booksAuthors = new \app\models\BooksAuthors();
							if(!$authorFound){
								$author = new \app\models\Authors();
								$author->name = $authorName;
								if($author->save()){
									$booksAuthors->authors_id = $author->id;
									$booksAuthors->books_id = $model->id;
									$booksAuthors->save();
								}
							}else{
								$booksAuthors->authors_id = $authorFound->id;
								$booksAuthors->books_id = $model->id;
								$booksAuthors->save();
							}
						}
					}
			}else{
				$status->addError('name', 'Нет такого статуса');
			}
			
			//var_dump($categories);die;
		}
		// var_dump($status);
		// $status->addError('name', 'Нет такого статуса');
		return $this->controller->render('create', [
			'model' => $model,
			'status' => $status
		]);
	}
}