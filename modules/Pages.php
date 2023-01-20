<?php
    Class Pages {
        public static $Main = "Pages/Main.php";
        public static $Error = "Pages/Error.php";
        public static $Home = "Pages/Home.php";
        public static $Dictionary = "Pages/Dictionary.php";
        public static $Crosswords = "Pages/Crosswords/crosswords.php";
        public static $NavBar = "Pages/NavBar.php";

        public static function getPage($page) {
            switch($page) {
                case 'home':            return Pages::$Home;
                case 'dictionary':      return Pages::$Dictionary;
                case 'crosswords':      return Pages::$Crosswords;
                default:                return Pages::$Error;
            }
        }
    }
?>