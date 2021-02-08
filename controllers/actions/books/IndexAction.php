<?php
namespace app\controllers\actions\books;
class IndexAction extends \yii\base\Action{
	public $modelClass;
	public $checkAccess;
	public function run(){
		if($this->checkAccess){
			call_user_func($this->checkAccess, $this->id);
		}
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