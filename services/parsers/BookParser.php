<?php
namespace app\services\parsers;
class BookParser extends AbstractParser{
	
	public function __construct(\app\services\parsers\interfaces\DAOInterface $DAO, array $params){
		parent::__construct($DAO, $params);
		$this->position = 0;
	}
	protected function getData(array $params){
		return $this->DAO->getJson(['url' => $params['url']??'']);
	}
	public function getIterator(){
		return $this->data->getIterator();
	}
}