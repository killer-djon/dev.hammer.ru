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
                                    Если у Вас нет аккаунта в нашем интернет-магазине деталей, тогда Вы можете авторизоваться через один из предложенных способов
                                </p>-->
	                            <p>
		                            Необходима авторизация на сайте, для завершения покупки. Если у Вас есть аккаунт на нашем сайте,
		                            пожалуйста введите его в соответствующие поля, или Вы можете зарегистрироваться на нашем сайте, что позволит 
		                            в дальнейшем использовать его.
	                            </p>
                                <p class="text-info">Так же вы можете войти одним из способов:</p>
                                <?
	                                echo HTML::anchor('user/authorize/facebook', 
	                                	'<i class="fa fa-facebook" aria-hidden="true"></i>', 
										[
			                                'rel'	=> 'nofollow',
			                                'class'	=> 'btn btn-default',
			                                'title'	=> 'Войти через Facebook'
										]
									);
									echo '&nbsp;';
									echo HTML::anchor('user/authorize/vk', 
	                                	'<i class="fa fa-vk" aria-hidden="true"></i>', 
										[
			                                'rel'	=> 'nofollow',
			                                'class'	=> 'btn btn-default',
			                                'title'	=> 'Войти через Vkontakte'
										]
									);
									echo '&nbsp;';
									echo HTML::anchor('user/authorize/instagram', 
	                                	'<i class="fa fa-instagram" aria-hidden="true"></i>', 
										[
			                                'rel'	=> 'nofollow',
			                                'class'	=> 'btn btn-default',
			                                'title'	=> 'Войти через Instagram'
										]
									);
									echo '&nbsp;';
									echo HTML::anchor('user/authorize/linkedin', 
	                                	'<i class="fa fa-linkedin" aria-hidden="true"></i>', 
										[
			                                'rel'	=> 'nofollow',
			                                'class'	=> 'btn btn-default',
			                                'title'	=> 'Войти через LinkedIn'
										]
									);
									echo '&nbsp;';
									echo HTML::anchor('user/authorize/yandex', 
	                                	'<i class="fa fa-yc" aria-hidden="true"></i>', 
										[
			                                'rel'	=> 'nofollow',
			                                'class'	=> 'btn btn-default',
			                                'title'	=> 'Войти через Yandex'
										]
									);
									echo '&nbsp;';
									echo HTML::anchor('user/authorize/google', 
	                                	'<i class="fa fa-google" aria-hidden="true"></i>', 
										[
			                                'rel'	=> 'nofollow',
			                                'class'	=> 'btn btn-default',
			                                'title'	=> 'Войти через Google'
										]
									);
									echo '&nbsp;';
									echo HTML::anchor('user/authorize/dropbox', 
	                                	'<i class="fa fa-dropbox" aria-hidden="true"></i>', 
										[
			                                'rel'	=> 'nofollow',
			                                'class'	=> 'btn btn-default',
			                                'title'	=> 'Войти через DropBox'
										]
									);
									echo '&nbsp;';
                                ?>
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