<?php
namespace app\commands;
class BookController extends \yii\console\Controller{
	private $parser = null;
	private $client = null;
	/**
	 *
	 *  @param \app\services\parsers\BookParser $parser 
	 */
	public function __construct($id, $module, \app\services\parsers\AbstractParser $parser, $config=[]){
		parent::__construct($id, $module, $config);
		$this->parser = $parser;
		$this->client = new \GuzzleHttp\Client();
	}
	public function actionParse(){
		$client = $this->client;
		$parser = $this->parser;
		$promises = [];
		$promise = null;
		foreach($this->parser as $bookData){
			var_dump('proccessed', $bookData['isbn']);
			$promise = new \GuzzleHttp\Promise\Promise(
				function() use (&$promise, &$bookData, &$client){
					$bookInfo = new \app\models\BookInfo();
					$bookInfo->load($bookData, '');
					if($bookInfo->validate()){
						$pathToDownLoadFolder = __DIR__ . '/../web/thumbnails/';
						$bookInfo->saveInfo($client, $pathToDownLoadFolder);
						$promise->resolve($bookInfo->isbn . 'done');
					}else{
						//$promise->reject($bookInfo->isbn);
						// print_r($bookInfo->errors);
						$promise->resolve($bookInfo->isbn . 'пропущена' . 'потому, что' );
					}
				}
			);
			//*
			$res = $promise->then(
				function($value){
					echo $value.PHP_EOL;
				},
				function($reason){
					// echo 'error for ' . $reason->title . PHP_EOL;
					//print_r($reason);
					print_r($reason);
				}
			);
			//var_dump($res);
			//*/
		}
		$promises[] = $promise;
		// Wait for the requests to complete, even if some of them fail
		// var_dump('1',$res->getState());
		// $promise->wait();
		// var_dump('2',$res->getState());
		$responses = \GuzzleHttp\Promise\Utils::settle($promises)->wait(false);
		// var_dump('3',$res->getState());
	}
}