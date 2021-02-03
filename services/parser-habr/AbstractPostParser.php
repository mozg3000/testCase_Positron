<?php


namespace app\lib\parser;
use app\lib\parser\HabrPostsDAO;

abstract class AbstractPostParser
{
    protected $postsUrl = '';
    protected $postsUrlParser = '//';
    protected $postTitleParser = '//';
    protected $postBodyParser = '//';
    /**
     * @property \lib\parser\HabrPostsDAO|null
     */
    protected $habrPostDAO = null;

    /**
     * AbstractParser constructor.
     * @param string $postsUrl
     * @param string $postsUrlParser
     * @param string $titleParser
     * @param string $bodyParser
     * @param HabrPostsDAO $habrPostDAO
     */
    public function __construct(string $postsUrl, string $postsUrlParser, string $titleParser, string $bodyParser, HabrPostsDAO $habrPostDAO)
    {
        $this->postsUrl = $postsUrl;
        $this->postsUrlParser = $postsUrlParser;
        $this->postTitleParser = $titleParser;
        $this->postBodyParser = $bodyParser;
        $this->habrPostDAO = $habrPostDAO;
    }

    public function parsePosts()
    {
        $postUrls = $this->getLast5PostUrls($this->postsUrl);
        //$posts =[];
        $posts = [];
        foreach ($postUrls as $postUrl){

//            var_dump($postUrl);
            $singlePostData = $this->habrPostDAO->getRawData($postUrl);
            $postBody ='';
            $postTitle = '';
            $postTitle = $this->getPostTitle($singlePostData);
            $singlePostData = $this->habrPostDAO->getRawData($postUrl);
            $postBody = $this->getPostBody($singlePostData);

            $posts[] = [
                'url' => $postUrl,
                'title' =>$postTitle,
                'body' => $postBody
            ];
        }
       return $posts;
    }

    abstract protected function getLast5PostUrls(string $postsUrl):array ;

    abstract protected function getPostTitle(string $rawData):string;

    abstract protected function getPostBody(string $rawData);
}