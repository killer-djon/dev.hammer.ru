<!-- main section -->
<section role="main">
    <div id="wrapper" class="">
        <? echo View::factory('templates/second/sidebar_left')->render(); ?>

        <!-- Page content -->
        <div id="page-content-wrapper">
            <? echo (isset($breadcrumbs)?$breadcrumbs:''); ?>
            <!-- Keep all page content within the page-content inset div! -->
            <? echo $cart_view; ?>

            <!--
            <div class="page-content inset">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 wow fadeInLeft animated">

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
            <aside class="feature-detail well" id="news">
                <div class="container-fluid">

                    <div class="pricing-heading text-center">
                        <h3>Свежие новости мира авто</h3>
                    </div>

                    <div class="row row-centered">
                        <div class="col-centered col-xs-12 col-md-3 col-sm-4 wow zoomIn animated animated">
                            <div class="single-table panel">
                                <div class="table-heading">
                                    <h4>Компания Мерседес проведет ренейминг своих моделей</h4>
                                </div>
                                <div class="table-price">
                                    <p>
                                        <img class="img-responsive" src="/upload_images/tooyota-auris-2015.jpg" alt="Компания Мерседес проведет ренейминг своих моделей">
                                    </p>
                                </div>
                                <div class="table-description text-muted">
                                    <p>
                                        На Парижском автосалоне Сузуки показала кроссовер Витара – новинку в классе субкомпактных кроссоверов. Автомобиль представлен в переднемприводном  и заднеприводном варианте, с АКП и МКП на выбор, мотор на 1.6л на 120л.с. В базовом исполнении идет передний привод, с доплатой можно установить многодисковую муфту на заднюю ось.  Массовое производство запустят в г. Эштергоме в 2015 году на заводе Магуар Сузуки. Характеристики Сузуки Витара – 1775мм в ширину, 1610мм в высоту, сдвижная панорманая крыша 560мм, колесная база 2.5м, дорожный просвет 185мм, покрышки 16 или 17 радиуса.
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center btn-more">
                                        <a href="#" class="btn btn-info read-more" role="button">Подробнее...</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-centered col-xs-12 col-md-3 col-sm-4 wow zoomIn animated animated">
                            <div class="single-table panel">
                                <div class="table-heading">
                                    <h4>Компания Мерседес проведет ренейминг своих моделей</h4>
                                </div>
                                <div class="table-price">
                                    <p>
                                        <img class="img-responsive" src="/upload_images/tooyota-auris-2015.jpg" alt="Компания Мерседес проведет ренейминг своих моделей">
                                    </p>
                                </div>
                                <div class="table-description text-muted">
                                    <p>
                                        На Парижском автосалоне Сузуки показала кроссовер Витара – новинку в классе субкомпактных кроссоверов. Автомобиль представлен в переднемприводном  и заднеприводном варианте, с АКП и МКП на выбор, мотор на 1.6л на 120л.с. В базовом исполнении идет передний привод, с доплатой можно установить многодисковую муфту на заднюю ось.  Массовое производство запустят в г. Эштергоме в 2015 году на заводе Магуар Сузуки. Характеристики Сузуки Витара – 1775мм в ширину, 1610мм в высоту, сдвижная панорманая крыша 560мм, колесная база 2.5м, дорожный просвет 185мм, покрышки 16 или 17 радиуса.
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center btn-more">
                                        <a href="#" class="btn btn-info read-more" role="button">Подробнее...</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-centered col-xs-12 col-md-3 col-sm-4 wow zoomIn animated animated">
                            <div class="single-table panel">
                                <div class="table-heading">
                                    <h4>Компания Мерседес проведет ренейминг своих моделей</h4>
                                </div>
                                <div class="table-price">
                                    <p>
                                        <img class="img-responsive" src="/upload_images/tooyota-auris-2015.jpg" alt="Компания Мерседес проведет ренейминг своих моделей">
                                    </p>
                                </div>
                                <div class="table-description text-muted">
                                    <p>
                                        На Парижском автосалоне Сузуки показала кроссовер Витара – новинку в классе субкомпактных кроссоверов. Автомобиль представлен в переднемприводном  и заднеприводном варианте, с АКП и МКП на выбор, мотор на 1.6л на 120л.с. В базовом исполнении идет передний привод, с доплатой можно установить многодисковую муфту на заднюю ось.  Массовое производство запустят в г. Эштергоме в 2015 году на заводе Магуар Сузуки. Характеристики Сузуки Витара – 1775мм в ширину, 1610мм в высоту, сдвижная панорманая крыша 560мм, колесная база 2.5м, дорожный просвет 185мм, покрышки 16 или 17 радиуса.
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center btn-more">
                                        <a href="#" class="btn btn-info read-more" role="button">Подробнее...</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center col-md-12">
                        <a href="#" class="text-info" role="button">Все новости</a>
                    </div>

                </div>
            </aside><!-- end of features-detail section -->
        </div>

        <!-- contact section -->
		<section class="text-center hidden-xs">
			<div class="">
				<div id="map_canvas"></div>
			</div>
		</section><!-- end of contact section -->
    </div>
</section>
<!-- main section -->