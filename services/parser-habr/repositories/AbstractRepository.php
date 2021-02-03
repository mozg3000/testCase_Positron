<?php


namespace app\lib\parser\repositories;



use app\lib\parser\interfaces\DbInterface;

abstract class AbstractRepository
{
    private $db = null;

    /**
     * AbstractRepository constructor.
     * @param $db
     */
    public function __construct(DbInterface $db)
    {
        $this->db = $db;
    }

}