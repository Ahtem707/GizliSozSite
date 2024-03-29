<?php

class Console {
    static private function filename() {
        return __DIR__."/output.log";
    }

    public static $enableGroups = [];
    public static $enableTime = False;

    static function fileWrire(String $text, Bool $lb=true) {
        if (!$handle = fopen(static::filename(), 'a')) {
            exit;
        }
        if ($lb == true) {
            if (fwrite($handle, $text . PHP_EOL) === FALSE) {
                exit;
            }
        } else {
            if (fwrite($handle, $text) === FALSE) {
                exit;
            }
        }
        fclose($handle);
    }
    static function clear() {
        if (is_writable(self::filename())) {
            if (!$handle = fopen(self::filename(), 'w')) {
                exit;
            }
            fclose($handle);
        }
    }

    static function log($text, String $prefix="", Int $level=0) {
        if(is_array($text)) {
            if($level == 0) {
                static::fileWrire($prefix."[");
            } else {
                static::fileWrire($prefix.": "."[");
            }
            $tmp = str_repeat("    ", $level+1);
            foreach ($text as $key => $value) {
                static::log($value, $tmp.$key, $level+1);
            };
            static::fileWrire(str_repeat("    ", $level)."]".(($level == 0)?'':','));
        } else if(is_object($text)){
            static::log(json_decode(json_encode($text),true));
        } else {
            if($level == 0 && $prefix != "") {
                $prefix = $prefix.": ";
            }
            if(gettype($text) == 'boolean') {
                if($text === true) $text = "true";
                else $text = "false";
            }
            static::fileWrire($prefix.$text);
        }
    }

    static function logRequest() {
        static::log(getallheaders(),"Headers: ");
        static::log($_GET,"GET: ");
        static::log($_POST,"POST: ");
        foreach (range(0,70) as $i) {
            static::fileWrire("-",false);
        }
        static::fileWrire("-");
    }
    static function breakLine() {
        foreach (range(0,70) as $i) {
            static::fileWrire("=",false);
        }
        static::fileWrire("\n",false);
    }

    static function logGroup($text, String $group = "") {
        if(in_array($group, Console::$enableGroups)) {
            if(Console::$enableTime) {
                Console::log(date("Y.m.d-h:m:s"));
            }
            $group = "Group $group";
            Console::log($text, $group);
        }
    }
}
?>