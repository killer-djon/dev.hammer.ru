<!-- main section -->
<div role="main">
    <div id="wrapper" class="">
        <? echo View::factory('templates/second/sidebar_left')->render(); ?>

        <!-- Page content -->
        <div id="page-content-wrapper">
            <? echo (isset($breadcrumbs)?$breadcrumbs:''); ?>
            <!-- Keep all page content within the page-content inset div! -->
            <div class="container-fluid">
                <div class="row">

                    <div class="col-xs-12 col-sm-12 wow fadeInRight animated">
                        <h1><? echo $title;?></h1><img src="/assets/img/daag.png" alt="">
                        <? echo $category_view; ?>
                    </div>
                </div>
            </div>

            <!--
            <div class="page-content inset">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 wow fadeInLeft animated">

                            <div class="">
                                <h3>Детали двигателя Toyota</h3><img src="/assets/img/daag.png" alt="">
                                <p>Уже 3 марта на Женевском автосалоне будет представлена новая обновленная версия модели Тойота Аурис. У рестайлингового Ауриса изменится не только внешний вид, но и салон – центральная консоль будет увеличина, мультимедийная система будет работать быстрее. Аурис 2015 по словам японских разработчиков станет не только комфортнее, но и безопаснее.</p>
                                <p>Когда новинка появится в России не разглашается. Глядя на аналитику продаж Тойота Аурис 2014 модели данная модель не популярна в РФ. Всего за 2014г. было продано 1411 машин модели Аурис, за тот же период модель Тойта Королла купили 27 704 человека. Учитывая динамику подорожания цен и снижения продаж, потенциальных покупателей данной модели в России будет ещё меньше. Даже в текущей минимальной комплектации Тойта Аурис 2014 хэтчбек стоит чуть более 1млн. руб. Кроме Аурис 2015 на Женевском автосалоне будет и другая новинка от Тойота – модернизированная версия Тойта Авенсис.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            -->

            <!-- features details section -->
			<?=View::factory('pages/short_news_list')->render();?>
			<!-- end of features-detail section -->
        </div>
    </div>
</div>
<!-- main section -->