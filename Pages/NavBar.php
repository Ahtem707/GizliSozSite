<?php
    $allPages = ['home','dictionary','crosswords'];
    $page = 'home';

    function getTitle($allPages) {
        switch($allPages) {
            case 'home': return "Главная";
            case 'dictionary': return "Словарь";
            case 'crosswords': return "Таблица кроссворда";
        }
    }

    function getIsActive($item, $nowPage) {
        if($item == $nowPage) {
            return true;
        }
        return false;
    }

    function getLink($allPages) {
        switch($allPages) {
            case 'home': return "/home"; break;
            case 'dictionary': return "/dictionary"; break;
            case 'crosswords': return "/crosswords"; break;
            default: return "/".$link;
        }
    }
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="/"><?=gStore::$siteTitle?></a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <?php foreach($allPages as $item) { ?>
            <?php if(getIsActive($item, gStore::$nowPage)) { ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?=getLink($item)?>"><?=getTitle($item)?></a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=getLink($item)?>"><?=getTitle($item)?></a>
                </li>
            <?php } ?>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>