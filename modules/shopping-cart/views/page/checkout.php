<!-- panel for checkout -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" data-target="#shopping-checkout">
                Контактные данные
            </a>
        </h3>
    </div>
    <div id="shopping-checkout" class="panel-collapse collapse">
        <div class="panel-body card">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a data-toggle="tab" data-target="#authorize" rel="nofollow">
                        Авторизация
                    </a>
                </li>
                <li role="presentation">
                    <a data-toggle="tab" data-target="#userdata" rel="nofollow">
                        Без авторизации
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- authorize panel body -->
                <div id="authorize" role="tabpanel" class="tab-pane fade in active">
                    <div class="row row-centered">
                        <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                            <div class="col-md-8 col-sm-12 col-xs-12 pull-right">
	                            <!--
	                            <p>
		                            Необходима авторизация на сайте, для завершения покупки. Если у Вас есть аккаунт на нашем сайте,
		                            пожалуйста введите его в соответствующие поля, или Вы можете зарегистрироваться на нашем сайте, что позволит 
		                            в дальнейшем использовать его.
	                            </p>
                                -->
                                <p>
                                    Если у Вас нет аккаунта в нашем интернет-магазине деталей, тогда Вы можете авторизоваться через один из предложенных способов
                                </p>
                                <!--
	                            <a rel="nofollow" href="<?=Request::factory('user/authorize/facebook')->execute()->body();?>" class="btn btn-default btn-lg">
                                    <i class="fa fa-facebook" title="Авторизация через сервис facebook.com" aria-hidden="true"></i>
                                </a>
                                <a rel="nofollow" href="<?=Request::factory('user/authorize/google')->execute()->body();?>" class="btn btn-default btn-lg">
                                    <i class="fa fa-google-plus" title="Авторизация через сервис google.com" aria-hidden="true"></i>
                                </a>
                                <a rel="nofollow" href="<?=Request::factory('user/authorize/linkedin')->execute()->body();?>" class="btn btn-default btn-lg">
                                    <i class="fa fa-linkedin" title="Авторизация через сервис linkedin.com" aria-hidden="true"></i>
                                </a>
                                -->
                                <a rel="nofollow" href="/user/authorize/vk<?=(isset($_REQUEST['code'])?'?code='.$_REQUEST['code'] : '')?>" class="btn btn-default btn-lg">
                                    <i class="fa fa-vk" title="Авторизация через сервис vk.com" aria-hidden="true"></i>
                                </a>
                                <a rel="nofollow" href="/user/authorize/facebook<?=(isset($_REQUEST['code'])?'?code='.$_REQUEST['code'] : '')?>" class="btn btn-default btn-lg">
                                    <i class="fa fa-facebook" title="Авторизация через сервис vk.com" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 col-centered">
                            <div class="col-md-8 col-sm-12 col-xs-12 pull-left">
                                <form role="form" class="form">
                                    <div class="form-group">
                                        <label for="useremail">Email:</label>
                                        <input type="email" class="form-control" id="useremail" name="useremail">
                                    </div>
                                    <div class="form-group">
                                        <label for="userpass">Password:</label>
                                        <input type="password" class="form-control" id="userpass" name="userpass">
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-primary">
                                            Войти
                                        </button>
                                        <button type="reset" class="btn btn-default">
                                            Сбросить
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- authorize panel body -->

                <!-- without auth panel body -->
                <div id="userdata" role="tabpanel" class="tab-pane fade in">
                </div>
                <!-- without auth panel body -->
            </div>
        </div>
    </div>
</div>
<!-- panel for checkout -->