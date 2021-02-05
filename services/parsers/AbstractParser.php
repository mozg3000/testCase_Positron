<?php


namespace app\services\parsers;
use app\services\parsers\DAOJson;

abstract class AbstractParser implements \IteratorAggregate
{
	
	protected $DAO = null;
	protected $data = null;

	/**
	 * AbstractParser constructor.
	 
	 * @param DAOInterface $DAO
	 */
	public function __construct(\app\services\parsers\interfaces\DAOInterface $DAO, array  $params)
	{
		$this->DAO = $DAO;
		$this->data =  new \ArrayObject($this->getData($params));
	}
	abstract protected function getData(array $params);
	
}