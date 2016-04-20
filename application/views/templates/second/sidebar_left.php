<div id="sidebar-wrapper">
    <ul id="sidebar_menu" class="sidebar-nav">
        <li class="sidebar-brand">
            <a id="menu-toggle" class="no-anchor" href="#" rel="nofollow">Навигация
                <span id="main_icon" class="fa fa-bars sub_icon"></span>
            </a>
        </li>
    </ul>
    <nav role="navigation">
        <ul class="sidebar-nav" id="sidebar">
            <? $uri = Request::detect_uri(); ?>
            <li><a href="/categories" <? echo ($uri =='categories'?'rel="nofollow"':''); ?> class="no-anchor">Каталог<span class="glyphicon glyphicon-list-alt pull-right sub_icon"></span></a></li>
            <li><a href="/offers" <? echo ($uri =='offers'?'rel="nofollow"':''); ?> class="no-anchor">Услуги<span class="fa fa-american-sign-language-interpreting pull-right sub_icon"></span></a></li>
            <li><a href="/delivery" <? echo ($uri =='delivery'?'rel="nofollow"':''); ?> class="no-anchor">Доставка<span class="fa fa-truck pull-right sub_icon"></span></a></li>
            <li><a href="/news" <? echo ($uri =='news'?'rel="nofollow"':''); ?> class="no-anchor">Автоновости<span class="fa fa-newspaper-o pull-right sub_icon"></span></a></li>
            <li><a href="/questions" <? echo ($uri =='questions'?'rel="nofollow"':''); ?> class="no-anchor">Вопрос-ответ<span class="fa fa-question-circle-o pull-right sub_icon"></span></a></li>
            <li><a href="/contacts" <? echo ($uri =='contacts'?'rel="nofollow"':''); ?> class="no-anchor">Контакты<span class="fa fa-phone pull-right sub_icon"></span></a></li>
        </ul>
    </nav>

    <ul class="sidebar-nav" id="shopping-cart">

        <li class="">
            <a class="no-anchor" rel="nofollow" href="#">Ваши заказы
                <span class="fa fa-shopping-basket sub_icon">
                    <span class="label label-info label-cart-count">5</span>
                </span>
            </a>
        </li>
    </ul>
</div>