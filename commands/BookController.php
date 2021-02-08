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
		$promise = null;
		$promises = (function() use (&$client, &$parser){
			foreach($parser as $bookData){
				yield $promise = new \GuzzleHttp\Promise\Promise(
					function() use (&$promise, &$bookData, &$client){
						$bookInfo = new \app\models\BookInfo();
						$bookInfo->load($bookData, '');
						if($bookInfo->validate()){
							$pathToDownLoadFolder = __DIR__ . '/../web/thumbnails/';
							try{
								$bookInfo->saveInfo($client, $pathToDownLoadFolder);
							}catch(\Throwable $e){
								echo 'catch'.PHP_EOL;
								$promise->reject($bookInfo->isbn);
							}
							$promise->resolve($bookInfo->isbn . 'done'.PHP_EOL);
						}else{
							
							$promise->resolve($bookInfo->errors . '    errors' );
						}
					}
				);
			}
		})();
		(new \GuzzleHttp\Promise\EachPromise($promises, [
			'concurrency' => 4,
		  'fulfilled' => function ($result) {
			  print_r($result);
			},
		  'rejected' => function ($reason) {
			  echo 'rejected'.PHP_EOL;
			  //print_r($reason);
		  }
		]))->promise()->wait(false);
	}
}