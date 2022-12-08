<?php

class Crosswords {

    function __construct($req, &$res) {

        $whereList = [];

        $level = $req->query['level'] ?? null;
        if($level) $whereList['level'] = $level;

        $queryString = 'SELECT * FROM `Crosswords`';

        // Учитывает не все кейсы, правил поиска, могу вызывается ошибки при других параметрах
        if(!count($whereList) == 0) {
            $queryString = $queryString.' WHERE ';
            foreach($whereList as $key => $value) {
                if(str_contains($value, '...')) {
                    $v = explode('...', $value);
                    $queryString = $queryString.$key.' BETWEEN '.$v[0].' AND '.$v[1].' & ';
                } else {
                    $queryString = $queryString.$key.' IN ('.$value.') & ';
                }
            }
            $queryString = substr($queryString, 0, -3);
        }

        $result = SqlManager::$share->request($queryString);
        
        if($result->error) {
            Console::logGroup($result->error, "crosswords");
        } else {
            foreach($result->data as &$item) {
                $item['words'] = json_decode($item['words']);
            }
            $res->body = $result->data;
        }
    }
}