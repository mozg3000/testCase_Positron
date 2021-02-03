<?php


namespace app\lib\parser;


use app\lib\parser\interfaces\DbInterface;

class HabrDb implements DbInterface
{

    public function getTableName(): string
    {
        return 'https://habr.com/ru/all/';
    }


}