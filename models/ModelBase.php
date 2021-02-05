<?php

namespace app\models;

use Yii;

abstract  class ModelBase extends \yii\db\ActiveRecord{
	public function behaviors(){
		$behaviors = parent::behaviors();
		$behaviors['timestamp'] = [
			'class' => \yii\behaviors\TimestampBehavior::className(),
			'attributes' => [
				\yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
			],
			'value' => new \yii\db\Expression('NOW()'),
		];
		return $behaviors;
	}
}