<!-- panel for checkout -->
<? //echo '<pre>'; print_r( $userdata ); exit; ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" data-target="#shipping-methods">
                Выбрать способ доставки и оплаты
            </a>
        </h3>
    </div>
    
    <div id="shipping-methods" class="panel-collapse collapse">
	    <div class="panel-body card">
		    <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a data-toggle="tab" data-target="#shipping-method-panel" rel="nofollow">
                        Способ доставки
                    </a>
                </li>
                <li role="presentation">
                    <a data-toggle="tab" data-target="#payment-method-panel" rel="nofollow">
                        Способ оплаты
                    </a>
                </li>
            </ul>
            
            <div class="tab-content">
	            
	            <!-- shipping method selector -->
	            <div id="shipping-method-panel" role="tabpanel" class="tab-pane fade in active">
		            <div class="row row-centered">
					    <div class="col-md-5 col-sm-8 col-xs-12 col-centered clearfix">
						    Необходимо выбрать способ доставки заказанных товаров:
					    </div>
				    </div>
				    <div class="row row-centered">
					    <div class="col-md-5 col-sm-8 col-xs-12 col-centered clearfix">
						    
						    <div id="accordion-shipping" class="panel-group">
							    <div class="panel">
								    <div class="form-group">
									    <select name="shipping-method" class="form-control">
											<? if( empty($userdata) ): ?>
												<option data-toggle="collapse" data-parent="#accordion-shipping" data-target="#shipping-empty" value="1" selected>Самовывоз</option>
												<option data-toggle="collapse" data-parent="#accordion-shipping" data-target="#shipping-form" value="2">Доставка</option>
											<? else: ?>
												<option data-toggle="collapse" data-parent="#accordion-shipping" data-target="#shipping-empty" value="1" <?=($userdata['shipping_method']=='Самовывоз'?'selected':'')?>>Самовывоз</option>
												<option data-toggle="collapse" data-parent="#accordion-shipping" data-target="#shipping-form" value="2" <?=($userdata['shipping_method']=='Доставка'?'selected':'')?>>Доставка</option>
											<? endif; ?>
									    </select>
								    </div>
								    
								    <div id="shipping-empty" class="panel-collapse collapse <?=($userdata['shipping_method']=='Самовывоз'?'in':'')?>">
									    <p>Для того чтобы забрать заказ, необходимо приехать в пункт выдачи заказов.</p>
									    <p>Мы находимся по адресу:</p>
										<p>    
										    <div class="row">
											    <div class="col-md-3 col-sm-6 col-xs-12">
												    <i class="fa fa-map-marker"></i>
												    <b>Адрес:</b>
											    </div>
											    <div class="col-md-9 col-sm-6 col-xs-12">
												    <span class="address">127486, г. Москва, ул. Горбунова 14,</span>
											    </div>
											    
										    </div>
											<div class="row">
												<div class="col-md-3 col-sm-6 col-xs-12"></div>
												<div class="col-md-9 col-sm-6 col-xs-12">
													<span class="build">ТК "Автомолл", Южная сторона, пав. 1/46</span>
													<a href="#" data-target="#map-address" data-toggle="modal" class="hidden-xs">Посмотреть на карте</a>
												</div>
												
											</div>
											
											<br />
											
											<div class="row">
												<div class="col-md-3 col-sm-6 col-xs-12">
													<i class="fa fa-phone"></i>
													<b>Телефоны:</b>
												</div>
												<div class="col-md-9 col-sm-6 col-xs-12">
													<span class="tel">(495) 748-70-28</span>, <span class="tel">(495) 799-00-21</span>
												</div>
											</div>
									    </p>
								    </div> 
								    <div id="shipping-form" class="panel-collapse collapse <?=($userdata['shipping_method']=='Доставка'?'in':'')?>">
									    <form data-toggle="validator" role="form" class="form" id="shipping-method-form">
										    <div class="form-group">
											    <label for="shippingcity">Город доставки: <span class="text-danger"><strong>*</strong></span></label>
											    <input value="<?=(!empty($userdata['shippingcity'])?$userdata['shippingcity']:'')?>" type="text" class="form-control" name="shippingcity" id="shippingcity" placeholder="Например: Москва" data-error="Вы не указали город доставки" required />
											    <div class="help-block with-errors"></div>
										    </div>
										    
										    <div class="form-group">
											    <label for="shippingaddress">Адрес доставки: <span class="text-danger"><strong>*</strong></span></label>
											    <textarea rows="3" name="shippingaddress" id="shippingaddress" class="form-control" placeholder="Укажите адрес доставки, желательно полный адрес" data-error="Вы не указали адрес доставки" required><?=(!empty($userdata['shippingaddress'])?$userdata['shippingaddress']:'')?></textarea>
											    <div class="help-block with-errors"></div>
										    </div>
										    
										    <div class="form-group">
											    <label for="shippingcomment">Дополнительная информация к доставке:</label>
											    <textarea rows="3" name="shippingcomment" id="shippingcomment" class="form-control" placeholder="Вы можете указать дополнительную информацию по поводу адреса доставки"><?=(!empty($userdata['shippingcomment'])?$userdata['shippingcomment']:'')?></textarea>
										    </div>
									    </form>
								    </div>
							    </div>
						    </div>
					    </div>
				    </div>
	            </div>
	            <!-- shipping method selector -->
	            
	            <!-- payment method -->
	            <div id="payment-method-panel" role="tabpanel" class="tab-pane fade in">
		            <div class="row row-centered">
			            <div class="col-md-6 col-sm-10 col-xs-12 col-centered text-center">
				            <p>
					            Уважаемые посетители интернет-магазина деталей <b>ФКТ "Авто"</b>, на данный момент оплата заказанных деталей
					            в нашем интернет-магазине производится только наличными при доставке заказа, или наличными при самовывозе
					            из пункта выдачи заказов.
				            </p>
				            <p>
					            В скором времени, мы сможем предоставить Вам способы оплаты заказов при помощи электронных платежей, а так же при помощи
					            банковских карт и банковских переводов.
				            </p>
				            
				            <p class="text-info">
					            Приносим Вам извенения в связи с временными неудобствами, и надеемся на понимание с Вашей стороны. Мы делаем все чтобы Вам было удобно и комфортно осуществлять покупку деталей в нашем интернет-магазине <b>ФКТ "Авто"</b>. 
				            </p>
				            
				            <h4>Спасибо что воспользовались нашими услугами.</h4>
			            </div>
		            </div>
	            </div>
	            <!-- payment method -->
	            
            </div>
	    </div>
	    
    </div>
</div>