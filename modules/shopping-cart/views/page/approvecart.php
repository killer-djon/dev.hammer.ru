<div class="container-fluid" id="shopping-cart-success">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-xs-12 wow fadeInRight animated">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1><?=$title?></h1>
                </div>

                <div class="panel-body">
                    <div class="row" role="contentinfo">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <? if(!empty($cart) && isset($cart['products']) && count($cart['products'])): ?>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 col-sm-12" id="cart-items">
                                        <table class="table table-bordered table-condensed table-responsive cart_content_form">
                                            <col/>
                                            <col/>
                                            <col/>
                                            <col width="5%"/>
                                            <col width="15%"/>
                                            <col width="15%"/>
                                            <col width="5%"/>
                                            <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Наименование</th>
                                                <th>Код детали</th>
                                                <th>Кол-во</th>
                                                <th>Цена (шт.)</th>
                                                <th>Итого</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <? $i = 1; ?>
                                            <? foreach ($cart['products'] as $key => $product): ?>
                                                <tr data-row="<?= $product['id'] ?>" class="row-item-detail table-hover">
                                                    <td><?= $i; ?></td>
                                                    <td><?= $product['name']; ?></td>
                                                    <td><?= $product['article']; ?></td>
                                                    <td class="text-center count-item"><?=$product['qty']?></td>
                                                    <td class="text-right price-item">
                                                        <?= $product['price']; ?> руб.
                                                        <? if ((float)$product['price'] <= 0): ?>
                                                            <small class="clearfix text-info">под заказ</small>
                                                        <? endif; ?>
                                                    </td>
                                                    <td class="text-right subtotal-item">
                                                        <?= sprintf('%01.2f', ($product['price'] * $product['qty'])); ?> руб.
                                                    </td>
                                                </tr>
                                                <? $i++; ?>
                                            <? endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                            <tr class="bg-info">
                                                <td colspan="4" class="text-right">
                                                    <span class="lead">Итого:</span>
                                                </td>
                                                <td colspan="2" class="text-left">
                                                    <div class="col-md-12">
                                                        Товаров: <span class="total-count">
														            	<strong><?= $cart['total']['count'] ?></strong>
														            </span>
                                                    </div>
                                                    <div class="col-md-12">
                                                        На сумму: <span class="total-cost">
														            	<strong><?= sprintf('%01.2f',
                                                                                $cart['total']['price']) ?></strong> руб.
														            </span>
                                                    </div>

                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-md-6 col-xs-12 col-sm-6">
                                        <h4>Способ доставки и оплаты</h4>
                                        <? if( $userdata['shipping_method'] == 'Самовывоз' ): ?>

                                            <div class="form-group">
                                                <label for="userphone">Способ доставки:</label>
                                                <div class="input-group">
                                                    <?=$userdata['shipping_method']?>
                                                </div>
                                            </div>
                                        <? else: ?>
                                            <div class="form-group">
                                                <label for="userphone">Способ доставки:</label>
                                                <span class="text-info"><?=$userdata['shipping_method']?></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="userphone">Адрес доставки:</label>
                                                <span class="text-info"><?=$userdata['shippingaddress']?></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="userphone">Город доставки:</label>
                                                <span class="text-info"><?=$userdata['shippingcity']?></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="userphone">Дополнительные пожелания:</label>
                                                <span class="text-info"><?=$userdata['shippingcomment']?></span>
                                            </div>
                                        <? endif; ?>

                                    </div>
                                    <div class="col-md-6 col-xs-12 col-sm-6">
                                        <h4>Контактные данные</h4>

                                        <div class="form-group">
                                            <label for="userphone">Ваше имя:</label>
                                            <span class="text-info"><?=$userdata['username']?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="userphone">Город:</label>
                                            <span class="text-info"><?=$userdata['usercity']?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="userphone">Email:</label>
                                            <span class="text-info"><?=$userdata['useremail']?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="userphone">Телефон:</label>
                                            <span class="text-info"><?=$userdata['userphone']?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="userphone">Комментарий:</label>
                                            <span class="text-info"><?=$userdata['usermessage']?></span>
                                        </div>
                                    </div>

                                    <br />
                                    <br />
                                    <div class="form-group text-center">
                                        <a href="<?=URL::site('cart/success')?>" class="btn btn-primary">Подтвердить заказ</a>
                                    </div>
                                </div>


                            <?else:?>
                                <div class="alert alert-info text-center">
                                    <p><?=$empty_cart?></p>
                                </div>
                            <? endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>