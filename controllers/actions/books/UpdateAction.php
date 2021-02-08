<?php
namespace app\controllers\actions\books;
class UpdateAction extends \yii\base\Action{
	public $modelClass;
	public $checkAccess;
	public function run($id){
		$model = $this->modelClass::findOne($id);
		$status = \app\models\Statuses::findOne($model->id_statuses);
		if($this->checkAccess){
			call_user_func($this->checkAccess, $this->id, $model);
		}
		$status = new \app\models\Statuses();
		if(\Yii::$app->request->isPost){
			//$bookInfo = new \app\models\BookInfo();
			$bookInfo = \Yii::$app->request->Post();
		// var_dump($bookInfo['Books']['categoriesList']);die;
			$model->load($bookInfo);
			//var_dump($model);die;
			// $model->published_date = $bookInfo['Books']['publishedDate']);
			$statusName = $bookInfo['Statuses']['name'];
			$statusFound = \app\models\Statuses::find()->byName($statusName)->one();
			$status->name = $statusName;
			$category = null;
			if($statusFound){
				$model->id_statuses = $statusFound->id;
				$model->setScenario($this->controller->updateScenario);
				$model->save();
				$newCategories = explode(',', $bookInfo['Books']['categoriesList']);
				$bookCategories  = $model->categoriesList;
				# я начал делать композитную форму как в файле для парсинга,
				# поэтому в update получается довольно запутанная логика, для обновления списка авторов и категорий
				# и я её не успеваю уже сделать....
		
				if($newCategories){
					foreach($newCategories as $categoryName){
						$categoryFound = \app\models\Categories::find()->byName($categoryName)->one();
						$booksCategories = new \app\models\BooksCategories();
						if(!$categoryFound){
							$category = new \app\models\Categories();
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
				}else{
					// foreach($bookCategories as $categoryToDelete){
						// $booksCategoriesRelation = \app\models\BooksCategories::find()->where(['books_id' => $model->id, 'categories_id' => $categoryToDelete->id]);
					// }
				}
				*/
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
		return $this->controller->render('update', [
			'model' => $model,
			'status' => $status
		]);
	}
}