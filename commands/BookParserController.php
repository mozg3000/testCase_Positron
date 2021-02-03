<?php
namespace app\commands;
class BookParserController extends \yii\console\Controller{
	public function __construct($id, $module, $config=[]){
		parent::__construct($id, $module, $config);
	}
}