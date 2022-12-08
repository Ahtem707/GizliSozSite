<?php

class Request {

    // $path int;
    public string $protocol = "";
    public string $method = "";
    public array $header = [];
    public array $query = [];
    public array $body = [];

    function __construct() {}

    static function Server(): Request {

        $request = new Request();

        $url = $_SERVER['REQUEST_URI'];
        $url = preg_replace('/^\//i', '', $url);

        $request->path = preg_replace('/\?.*$/i', '', $url);

        $request->method = $_SERVER['REQUEST_METHOD'];

        $request->protocol = $_SERVER['SERVER_PROTOCOL'];

        foreach($_SERVER as $key => $value) {
            if(preg_match("/^HTTP.*_/i",$key)) {
                $key = preg_replace('/^HTTP.*_/i', '', $key);
                $request->header[$key] = $value;
            }
        }
        
        $request->query = $_GET;
        $request->body = $_POST;

        return $request;
    }
}