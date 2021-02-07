<?php

namespace app\controllers;

use Yii;
use app\models\Books;
use app\models\searchmodels\BooksSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BooksController implements the CRUD actions for Books model.
 */
class BooksController extends Controller
{
	public $modelClass = \app\models\Books::class;
	public $updateScenario = \app\models\Books::SCENARIO_UPDATE;
	public $createScenario = \app\models\Books::SCENARIO_CREATE;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
	public function actions(){
		return [
			'create' => [
				'class' => \app\controllers\actions\books\CreateAction::class,
				'modelClass' => $this->modelClass,
				'checkAccess' => [$this, 'checkAccess'],
			],
			'view' => [
				'class' => \app\controllers\actions\books\ViewAction::class,
				'modelClass' => $this->modelClass,
				'checkAccess' => [$this, 'checkAccess']
			],
			'update' => [
				'class' => \app\controllers\actions\books\UpdateAction::class,
				'modelClass' => $this->modelClass,
				'checkAccess' => [$this, 'checkAccess']
			],
			'index' => [
				'class' => \app\controllers\actions\books\IndexAction::class,
				'modelClass' => $this->modelClass,
				'checkAccess' => [$this, 'checkAccess']
			]
		];
	}
    
    protected function findModel($id)
    {
        if (($model = Books::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	public function checkAccess($action, $model = null, $params = []){
		//print_r(\Yii::$app->user->getId());
		if(\Yii::$app->user->isGuest){
			throw new \yii\web\ForbiddenHttpException('only authenticated users can see books');
		}
		switch($action){
			case 'create':
				if(\Yii::$app->user->getId() !== '100'){
					throw new \yii\web\ForbiddenHttpException('only admin can create');
				}
				break;
			case 'update':
				if(\Yii::$app->user->getId() !== '100'){
					throw new \yii\web\ForbiddenHttpException('only admin can update');
				}
				break;
			
		}
		return true;
	}
	// public function befoaction($action){
		// if($action->id === 'create'){
			
		// }
	// }
}
