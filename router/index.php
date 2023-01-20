<?php

include 'Request.php';
include 'RouterModule.php';
include 'Api/crosswords.php';
include 'Api/wordSound.php';

class Router {
    function __construct() {

        $req = Request::Server();
        $res = new Request();

        $apiRouter = new ApiRouter($req, $res);
        $siteRouter = new SiteRouter($req, $res);
        
        // Для тестирования запросов
        // Console::logRequest();
        
        $pathArr = explode("/", $req->path);
        if($pathArr > 0 and $pathArr[0] == 'api') {
            $apiRouter->makeRouter();
        } else {
            $siteRouter->makeRouter();
        }

        // foreach($res->header as $key=>$value) {
        //     header($key.":".$value);
        // }

        if($res->body != []) {
            $result = json_encode($res->body, JSON_UNESCAPED_UNICODE);
            echo $result;
        }
    }
}

class SiteRouter extends RouterModule {

    function makeRouter() {
        $path = $this->req->path;
        gStore::$nowPage = $path;
        include Pages::$Main;
    }
}

class ApiPath {
    static $crossword = "/crosswords";
    static $dictionary = "/dictionary";
    static $wordSound = "/wordSound";
}

class ApiRouter extends RouterModule {

    function makeRouter() {
        $path = $this->req->path;
        $path = str_replace("api", "", $path);
        switch($path) {
            case ApiPath::$crossword:
                new Crosswords($this->req, $this->res);
                break;
            case ApiPath::$dictionary:
                Console::log("dic");
                break;
            case ApiPath::$wordSound:
                new WordSound($this->req, $this->res);
                break;
            default:
                Console::log("default");
        }
    }
}