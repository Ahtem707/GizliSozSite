<?php

class RouterModule {
    protected Request $req;
    protected Request $res;

    function __construct($req,&$res) {
        $this->req = $req;
        $this->res = $res;
    }
}