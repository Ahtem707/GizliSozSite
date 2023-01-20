
<html>
    <head>
        <title><?=gStore::$siteTitle?></title>
        <?php include('modules/library.php'); ?>
    </head>
    <body>
        <header>
            <?php include(Pages::$NavBar); ?>
        </header>

        <div id="mainContainer">
            <?php include(Pages::getPage(gStore::$nowPage)); ?>
        </div>

        <footer>
            Автор сайта: Ситжалилов Ахтем
            <br>
            Почта: sitzhalilov.a.i.2.19gmail.com
        </footer>
    </body>
</html>