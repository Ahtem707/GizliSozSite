<?php

gStore::$share = new gStore();

class gStore {

    public static $share;

    public $siteTitle = "GizlySöz";
    public $nowPage = "home";
};

// $page = (isset($_GET['page']) ? $_GET['page'] : 'home');
// $allPages = ["home","dictionary","crosswords"];
// if(!in_array($page, $allPages)) {
//     $page = $allPages[0];
// }
