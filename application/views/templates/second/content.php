<!-- main section -->
<section role="main">
    <div id="wrapper" class="">
        <? echo View::factory('templates/second/sidebar_left')->render(); ?>

        <!-- Page content -->
        <div id="page-content-wrapper">
            <? echo (isset($breadcrumbs)?$breadcrumbs:''); ?>
            <!-- Keep all page content within the page-content inset div! -->
            <div class="container-fluid">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 wow fadeInRight animated">

                        <div class="panel panel-default">
                            <div class="panel-heading">

                                <div class="container-fluid">
                                    <div class="col-xs-12 col-sm-12 col-md-7">
                                        <h1><? echo $title;?></h1>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-5 pull-right">
                                        <form class="" role="form">
                                            <label class="control-label ">Поиск по названию</label>
                                            <div class="input-group">
                                                <input type="text" placeholder="Поиск по номеру детали" class="form-control">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default" title="Начать поиск по номеру детали">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <? echo $category_view; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-content inset">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 wow fadeInLeft animated">

                            <div class="panel">
                                <h3>Детали двигателя Toyota</h3><img src="/assets/img/daag.png" alt="">
                                <p>Уже 3 марта на Женевском автосалоне будет представлена новая обновленная версия модели Тойота Аурис. У рестайлингового Ауриса изменится не только внешний вид, но и салон – центральная консоль будет увеличина, мультимедийная система будет работать быстрее. Аурис 2015 по словам японских разработчиков станет не только комфортнее, но и безопаснее.</p>
                                <p>Когда новинка появится в России не разглашается. Глядя на аналитику продаж Тойота Аурис 2014 модели данная модель не популярна в РФ. Всего за 2014г. было продано 1411 машин модели Аурис, за тот же период модель Тойта Королла купили 27 704 человека. Учитывая динамику подорожания цен и снижения продаж, потенциальных покупателей данной модели в России будет ещё меньше. Даже в текущей минимальной комплектации Тойта Аурис 2014 хэтчбек стоит чуть более 1млн. руб. Кроме Аурис 2015 на Женевском автосалоне будет и другая новинка от Тойота – модернизированная версия Тойта Авенсис.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- contact section -->
        <section class="contact text-center" id="contact">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="contact-heading">
                            <h4>оставайтесь с нами</h4>
                            <h2>Наши контакты</h2>
                            <img class="img-responsive" src="/assets/img/daag.png" alt="">
                        </div>
                        <div class="col-md-4">
                            <i class="fa fa-phone"></i>
                            <p>Phone: (415) 124-5678</p>
                            <p>Fax: (412) 123-8290</p>
                        </div>
                        <div class="col-md-4">
                            <i class="fa fa-map-marker"></i>
                            <p>1001 Brickell Bay Dr.</p>
                            <p>Suite 1900 </p>
                            <p>Miami, FL 33131</p>
                        </div>
                        <div class="col-md-4">
                            <i class="fa fa-envelope-o"></i>
                            <p>user@mail.com</p>
                        </div>
                        <div class="col-md-8 col-md-offset-2 col-xs-12 col-sm-12">

                            <article class="contact-form">
                                <h4>Написать нам</h4>
                                <form action="contact">
                                    <div class="col-md-5 col-md-offset-1 contact-form-left">
                                        <input class="name" type="text" placeholder="Ваше имя*">
                                        <input class="email" type="email" placeholder="Email*">
                                        <input class="subject" type="text" placeholder="Тема*">
                                    </div>
                                    <div class="col-md-5 contact-form-right text-right">
                                        <textarea class="message" name="message" id="message" cols="30" rows="10" placeholder="Сообщение"></textarea>
                                        <input type="submit" class="submit-btn" value="отправить">
                                    </div>
                                </form>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- end of contact section -->
    </div>
</section>
<!-- main section -->