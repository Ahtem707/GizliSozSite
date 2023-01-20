<?php

class WordSound {
    function __construct($req, &$res) {
        echo "hi";

        $wordId = $req->query['wordId'] ?? null;
        $voiceActor = $req->query['voiceActor'] ?? null;

        switch($wordId) {
            case 1:
                $data = [];
                $data["result"] = 0;
                $data["url"] = "/media/meraba.mp3";
                $res->body = $data;
                break;
        }
    }
}