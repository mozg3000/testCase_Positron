<?php
namespace app\controllers\actions\books;
class ViewAction extends \yii\base\Action{
	public $modelClass;
	public $checkAccess;
	public function run($id){
		$model = $this->modelClass::findOne($id);
		if($this->checkAccess){
			call_user_func($this->checkAccess, $this->id, $model);
		}
		if($model){
			return $this->controller->render('view', ['model' => $model]);
		}else{
			throw new \yii\web\NotFoundHttpException('Wrong book\'s id');
		}
	}
}