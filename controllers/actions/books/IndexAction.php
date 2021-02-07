<?php
namespace app\controllers\actions\books;
class IndexAction extends \yii\base\Action{
	public $modelClass;
	public $checkAccess;
	public function run(){
		$dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $this->modelClass::find(),
        ]);
		$searchModel = new \app\models\searchModels\BooksSearch();
        return $this->controller->render('index', [
            'dataProvider' => $dataProvider,
			'searchModel' => $searchModel
        ]);
	}
}