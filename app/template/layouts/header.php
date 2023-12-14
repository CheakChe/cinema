<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= SITENAME ?></title>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <?php if (!empty($vars['styles'])): ?>
        <?php foreach ($vars['styles'] as $key => $item): ?>
            <link rel="stylesheet" href="/app/public/css/<?= $item ?>.css">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
<header class="header font-family">
    <div class="header__content position">
        <div class="header__object">
            <div class="header__left">
                <div class="header__logo">
                    <a href="/">
                        <img src="/app/public/img/logo-new.png" alt="Лого">
                    </a>
                </div>
                <nav class="header__menu">
                    <?php foreach($vars['menu'] as $key => $item):?>
                        <a href="/<?=$item['name']?>"><?=$item['value']?></a>
                    <?php endforeach;?>
                </nav>
            </div>
            <div class="header__right">
                <div class="header__search">
                    <button>
                        <img src="/app/public/img/svg/search.svg" alt="loupe photo" title="loupe photo">
                    </button>
                </div>
                <div class="header__auth">
                    <?php if(!$_SESSION['user']):?>
                    <a href="/auth" title="Авторизироваться">Вход</a>
                    <span>|</span>
                    <a href="/auth" title="Загеристрироваться"> Регистрация </a>
                    <?php else:?>
                    <a class="m-0" href="/account"><?=$_SESSION['user']['login']?></a>
                        <a href="/auth/logout">Выйти</a>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</header>

