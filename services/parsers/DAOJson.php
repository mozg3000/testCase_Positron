<?php
namespace app\services\parsers;
class DAOJson implements \app\services\parsers\interfaces\DAOInterface{
	public function getJson(array $param):?array{
		
		return $this->getJsonByUrl($param['url']??'');
	}
	private function getJsonByUrl(string $url){
		// return json_decode(file_get_contents($url), true);
		return json_decode(file_get_contents('/app/services/parsers/data.json'), true);
	}
}