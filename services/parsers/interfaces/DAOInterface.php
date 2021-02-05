<?php
namespace app\services\parsers\interfaces;
interface DAOInterface {
	public function getJson(array $param):?array;
}