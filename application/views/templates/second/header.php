<!-- header section -->
<header class="top-header-second" id="top-header-second">
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header col-xs-12 col-sm-12 col-md-4">
            <ul class="navbar-toggle user-profile">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="fa fa-user"></span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><? echo HTML::anchor('/user/profile', 'Профиль'); ?></li>
                        <li><? echo HTML::anchor('/cart', 'Корзина'); ?></li>
                        <li><? echo HTML::anchor('#question', 'Задать вопрос'); ?></li>
                        <li class="divider"></li>
                        <li><? echo HTML::anchor('/user/?logout=yes', 'Выйти'); ?></li>
                    </ul>
                </li>
            </ul>

            <div class="dropdown hidden-xs">
                <ul class="pull-left navbar-nav nav ">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-user"></span><span class="caret"></span></a>

                        <ul class="dropdown-menu" role="menu">
                            <li><? echo HTML::anchor('/user/profile', 'Профиль'); ?></li>
                            <li><? echo HTML::anchor('/cart', 'Корзина'); ?></li>
                            <li><? echo HTML::anchor('#question', 'Задать вопрос'); ?></li>
                            <li class="divider"></li>
                            <li><? echo HTML::anchor('/user/?logout=yes', 'Выйти'); ?></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <a class="navbar-brand no-anchor pull-left" href="<? echo URL::base(); ?>">HAMMERSCHMIDT</a>
            <button class="navbar-toggle fa fa-search " type="button" data-target=".navbar-collapse" data-toggle="collapse"></button>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-8 top-search">
            <div class="collapse navbar-collapse">
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <form role="form" class="navbar-form" action="/products">
                            <div class="input-group col-xs-12 navbar-right">
                                <input type="text" class="form-control" placeholder="Поиск по номеру детали" name="search">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" title="Начать поиск по номеру детали">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <form role="form" class="navbar-form" action="/categories">
                            <div class="input-group col-xs-12 navbar-right">
                                <input type="text" class="form-control" placeholder="Поиск по коду двигателя" name="search">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" title="Начать поиск по коду двигателя">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header section -->