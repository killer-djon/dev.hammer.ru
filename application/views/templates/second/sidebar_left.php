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
            <li><a href="/categories" <? echo ($uri =='categories'?'rel="nofollow"':''); ?> class="no-anchor" title="Каталог производителей">Каталог<span class="glyphicon glyphicon-list-alt pull-right sub_icon"></span></a></li>
            <li><a href="/offers" <? echo ($uri =='offers'?'rel="nofollow"':''); ?> class="no-anchor" title="Предоставляемые услуги">Услуги<span class="fa fa-american-sign-language-interpreting pull-right sub_icon"></span></a></li>
            <li><a href="/delivery" <? echo ($uri =='delivery'?'rel="nofollow"':''); ?> class="no-anchor" title="Доставка и оплата">Доставка<span class="fa fa-truck pull-right sub_icon"></span></a></li>
            <li><a href="/news" <? echo ($uri =='news'?'rel="nofollow"':''); ?> class="no-anchor" title="Свежие новости мира авто">Автоновости<span class="fa fa-newspaper-o pull-right sub_icon"></span></a></li>
            <li><a href="/questions" <? echo ($uri =='questions'?'rel="nofollow"':''); ?> class="no-anchor" title="Часто задаваемые вопросы">Вопрос-ответ<span class="fa fa-question-circle-o pull-right sub_icon"></span></a></li>
            <li><a href="/contacts" <? echo ($uri =='contacts'?'rel="nofollow"':''); ?> class="no-anchor" title="Контактные данные">Контакты<span class="fa fa-phone pull-right sub_icon"></span></a></li>
        </ul>
    </nav>

    <ul class="sidebar-nav" id="shopping-cart">

        <li class="">
        	<?=HTML::anchor('/cart', 'Корзина заказов<span class="fa fa-shopping-basket sub_icon" id="cart-total"></span>', [
            	'class'	=> 'no-anchor',
            	'rel'	=> 'nofollow',
            ]);?>
					
        </li>
    </ul>
</div>