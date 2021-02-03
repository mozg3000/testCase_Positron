<?php


namespace app\lib\parser\repositories;


use app\lib\parser\HabrDb;
use app\lib\parser\HabrPostParser;
use app\lib\parser\interfaces\DbInterface;

class HabrPostsRepository extends AbstractRepository
{
    private $data = null;
    /**
     * HabrPostsRepository constructor.
     * @param HabrDb $db
     */
    public function __construct(DbInterface $db)
    {
        parent::__construct($db);
    }
}