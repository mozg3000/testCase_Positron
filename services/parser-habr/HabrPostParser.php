<?php


namespace app\lib\parser;


use app\lib\parser\HabrPostsDAO;
use app\lib\parser\interfaces\ParserInterface;

class HabrPostParser extends AbstractPostParser implements ParserInterface
{

    /**
     * HabrPostParser constructor.
     * @param string $postsUrl
     * @param string $urlParser
     * @param string $titleParser
     * @param string $bodyParser
     * @param HabrPostsDAO $habrPostDAO
     */
    public function __construct(string $postsUrl, string $urlParser, string $titleParser, string $bodyParser,  HabrPostsDAO $habrPostDAO)
    {
        parent::__construct($postsUrl, $urlParser, $titleParser, $bodyParser, $habrPostDAO);
    }

    protected function getLast5PostUrls(string $postsUrl):array  {

        $postUrls = [];
        $rawData = $this->habrPostDAO->getRawData($postsUrl);
        preg_match_all($this->postsUrlParser, $rawData, $postUrls);
        $postUrls = array_splice($postUrls[1], 0, 5);

        return $postUrls;
    }

    protected function getPostTitle(string $rawData):string {

        $postTitle = [];

        $r = preg_match($this->postTitleParser, $rawData, $postTitle);

        return $r ===0 ? '':$postTitle[1];
    }

    protected function getPostBody(string $rawData) {

        $postBody = [];
        $r = preg_match($this->postBodyParser, $rawData, $postBody,PREG_OFFSET_CAPTURE);
//        preg_match('/' . $this->postBodyParser .'/iuU', $rawData, $postBody,PREG_OFFSET_CAPTURE);
//var_dump($r);
        return $r ===0 ? '':$postBody[1][0];
    }
}