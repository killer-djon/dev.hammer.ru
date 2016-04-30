<!--header section -->
<header class="top-header">
	<div class="container-fluid">
		<div class="row">
			<!-- nav starts here -->
			<div class="col-md-12 col-sm-12 col-xs-12">					
				<nav class="navbar nav-bar">
					<div class="container-fluid">
					    <div class="row row-centered main-top-header">
						    <div class="col-md-10 col-sm-12 col-xs-12 col-centered top-logo">
							    <div class="navbar-header text-center">
								    
								    <!-- user toggle menu -->
								    <ul class="navbar-toggle toggle-menu">
									    <li>
									    	<a rel="nofollow" href="#" class="fa fa-shopping-basket no-anchor" id="shopping-cart">
							                    <span class="label label-info label-cart-count">5</span>
							                </a>
									    </li>
								    </ul>
								    <ul class="navbar-toggle toggle-menu">
									    <li>
									    	<span class="search-toggle fa fa-search" data-target=".search-main-header" data-toggle="collapse"></span>
									    </li>
									    
								    </ul>
								    
								    
								    <ul class="navbar-toggle toggle-menu">
						                <li class="dropdown">
						                    <a rel="nofollow" class="dropdown-toggle" data-toggle="dropdown" href="#">
						                        <span class="fa fa-user"></span>
						                        <span class="caret"></span>
						                    </a>
						                    <ul class="dropdown-menu dropdown-menu-right" role="navigation">
						                        <li><? echo HTML::anchor('/user/profile', 'Профиль'); ?></li>
						                        <li><? echo HTML::anchor('/cart', 'Корзина'); ?></li>
						                        <li><? echo HTML::anchor('#question', 'Задать вопрос'); ?></li>
						                        <li class="divider"></li>
						                        <li><? echo HTML::anchor('/user/?logout=yes', 'Выйти'); ?></li>
						                    </ul>
						                </li>
						            </ul>
						            
						            <!-- user toggle menu -->
						            
						            <!-- content toggle menu -->
							      	<ul class="navbar-toggle toggle-menu">
						                <li class="dropdown">
						                    <a rel="nofollow" class="dropdown-toggle" data-toggle="dropdown" href="#">
						                        <span class="fa fa-list"></span>
						                        <span class="caret"></span>
						                    </a>
						                    <ul class="dropdown-menu dropdown-menu-right" role="navigation">
						                        <li><a rel="nofollow" href="#about">О компании</a></li>
										        <li><a rel="nofollow" href="#categories">Категории</a></li>
										        <li><a rel="nofollow" href="#testimonials">Производители</a></li>
										        <li><a rel="nofollow" href="#delivery">Оплата/Доставка</a></li>
										        <li><a rel="nofollow" href="#news">Автоновости</a></li>
										        <li><a rel="nofollow" href="#contact">Контакты</a></li>
						                    </ul>
						                </li>
						            </ul>
						            
							        <!-- content toggle menu -->
							        
							        <!-- logo header -->
									<span class="logo-link" title="Интернет-магазин деталей">HAMMERSCHMIDT</span>
									<!-- logo header -->
							    </div>
						    </div>
						    <div class="col-md-12 col-sm-12 col-xs-12 col-centered">
							    <!-- displayed -md-* menu -->
							    <div class="collapse navbar-collapse">
								    <div class="navbar-primary navbar center">
									    <div class="navbar-inner">
										    <nav>
											    <ul class="nav navbar-nav" role="navigation">
											      	<li><a rel="nofollow" href="#about">О компании</a></li>
													<li><a rel="nofollow" href="#categories">Категории</a></li>
											        <li><a rel="nofollow" href="#testimonials">Производители</a></li>
											        <li><a rel="nofollow" href="#delivery">Оплата/Доставка</a></li>
											        <li><a rel="nofollow" href="#news">Автоновости</a></li>
											        <li><a rel="nofollow" href="#contact">Контакты</a></li>
										      	</ul>
										    </nav>
									    </div>
								    </div>
							    </div>
						      	<!-- displayed -md-* menu -->
						    </div>
						    
						    <!-- search forms -->
						    <div class="col-xs-12 col-sm-12 col-md-8 top-search col-centered collapse navbar-collapse search-main-header">
					            <div class="">
					                <div class="row"> 
					                    <div class="col-md-6 col-xs-12 col-sm-6">
					                        <form role="form" class="navbar-form" action="/products">
					                            <div class="input-group col-xs-12 navbar-right">
					                                <input type="text" class="form-control" placeholder="Поиск по номеру детали" name="search">
					                                <span class="input-group-btn">
					                                    <button type="submit" class="btn btn-default" title="Начать поиск по номеру детали">
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
					                                    <button type="submit" class="btn btn-default" title="Начать поиск по коду двигателя">
					                                        <i class="fa fa-search"></i>
					                                    </button>
					                                </span>
					                            </div>
					                        </form>
					                    </div>
					                </div>
					            </div>
					        </div>
						    <!-- search forms -->
					    </div>
					</div>
				</nav>
				
				<div class="shopping navbar-shopping">
					<!-- displayed -md-* menu -->
				    <div class="collapse navbar-collapse">
					    <div class="navbar center">
						    <div class="navbar-inner">
							    <nav>
								    <ul class="nav navbar-nav" role="navigation">
									    
								      	<li class="dropdown">
						                    <a class="dropdown-toggle no-anchor" data-toggle="dropdown" href="#">
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
						                <li>
						                	<a rel="nofollow" href="#" class="fa fa-shopping-basket no-anchor" id="shopping-cart">
							                    <span class="label label-info label-cart-count">5</span>
							                </a>
						                </li>
							      	</ul>
							    </nav>
						    </div>
					    </div>
				    </div>
			      	<!-- displayed -md-* menu -->
				</div>
			</div>
		</div>
	</div>
</header>
<!-- end of header section -->