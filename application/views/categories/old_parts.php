<? if( !empty($empty_parts) ): ?>
    <div class="alert alert-info text-center">
        <p><?=$empty_parts?></p>
    </div>
<? else: ?>

    <div class="panel card">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a data-toggle="tab" data-target="#products" rel="nofollow">
                    Список деталей двигателя <?=$current['name']?>
                </a>
            </li>
            <li role="presentation">
                <a data-toggle="tab" data-target="#cross-products" rel="nofollow">
                    Подходящие замены деталей - двигателя <?=$current['name']?>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="cross-products" role="tabpanel" class="tab-pane fade">
                <div class="">
                    <h3>Подходящие замены деталей - двигателя <?=$current['name']?></h3>
                    <? if( !empty($cross_products) ): ?>
                        <table class="table table-hover table-bordered">
                            <col width="50px"/>
                            <col/>
                            <col/>
                            <col/>
                            <col/>
                            <col width="100px"/>
                            <thead>
                            <tr>
                                <th>№</th>
                                <th>Наименование</th>
                                <th>Код детали</th>
                                <th>Производитель</th>
                                <th>Цена</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <? foreach($cross_products as $groupName => $item): ?>
                                <? if( is_array($item) && count($item) ): ?>
                                    <tr class="info">
                                        <td colspan="6">
                                            <h4 class="header-toggle">
                                                <i class="fa fa-caret-down indicator fa-caret-up"></i>
                                                Возможные замены детали: <b><?=$groupName?></b>
                                                <span class="label label-info"><?=count($item)?></span>
                                            </h4>
                                        </td>
                                    </tr>

                                    <? foreach($item as $key => $detail): ?>
                                        <? if( empty($detail['article']) ) continue; ?>

                                        <?$price = (isset($detail['price']) && 0!==$detail['price'] ? $detail['price'].' руб.' : 0);?>

                                        <tr class="detail-row <?=($price!==0?'bg-success':'bg-danger')?> collapsed">
                                            <td><?=($key+1);?></td>
                                            <td>
                                                <?=(!empty($detail['name'])?$detail['name']:'<img alt="" src="/assets/img/daag.png">')?>
                                            </td>
                                            <td>
                                                <a href="/products/?type=products&article=<?=$detail['article']?>"><?=$detail['article']?></a>
                                            </td>
                                            <td><?=strtoupper($detail['manufacture'])?></td>
                                            <td class="text-right">
                                                <?=($price!==0 ? $price : '<img alt="" src="/assets/img/daag.png">')?>
                                            </td>
                                            <td>
                                                <div class="btn-group dropdown">
                                                    <button href="#" class="btn btn-info no-anchor dropdown-toggle" data-toggle="dropdown">
                                                        <i class="fa fa-cart-plus"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                        <li role="menuitem">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <form role="form" class="form product-qty">
                                                                        <input type="hidden" name="id" value="<?=$detail['_id']['$id']?>">
                                                                        <input type="hidden" name="article" value="<?=$detail['article']?>">
                                                                        <input type="hidden" name="name" value="<?=(!empty($detail['name'])?$detail['name']:'--')?>">
                                                                        <input type="hidden" name="price" value="<?=($price!==0 ? $price : 0)?>">

                                                                        <div class="form-group">
                                                                            <label for="qty">Выберите кол-во</label>
                                                                            <div class="input-group count-detail">
																				<span class="input-group-addon cart-qty cart-minus">
																					<i class="fa fa-minus"></i>
																				</span>
                                                                                <input name="qty" type="text" class="form-control text-right btn-number" placeholder="1" value="1">
																				<span class="input-group-addon cart-qty cart-plus">
																					<i class="fa fa-plus"></i>
																				</span>
																				<span class="input-group-addon cart-qty cart-refresh">
																					<i class="fa fa-refresh"></i>
																				</span>

                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group text-right">
                                                                            <a role="button" class="btn btn-primary add_to_cart">Добавить в корзину</a>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <a href="#" class="btn btn-info no-anchor" data-toggle="modal" data-target="#sendMessage">
                                                        <i class="fa fa-envelope"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <? endforeach; ?>
                                <? endif; ?>
                            <? endforeach; ?>
                            </tbody>
                        </table>
                    <? else: ?>
                        <div class="alert alert-info text-center">
                            <p>
                                Подходящих замен не найдено
                            </p>
                        </div>
                    <? endif; ?>
                </div>
            </div>



            <div id="products" role="tabpanel" class="tab-pane fade  in active">

                <div class="">
                    <h3>Список деталей двигателя <?=$current['name']?></h3>
                    <?if( !empty($parts) ):?>
                        <table class="table table-hover table-bordered">
                            <col width="50px"/>
                            <col/>
                            <col/>
                            <col/>
                            <col/>
                            <col width="100px"/>
                            <thead>
                            <tr>
                                <th>№</th>
                                <th>Наименование</th>
                                <th>Код детали</th>
                                <th>Производитель</th>
                                <th>Цена</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $i = 1; ?>
                            <? foreach($parts as $groupdetail): ?>
                                <? if( isset($groupdetail['children']) && !empty($groupdetail['children']) ): ?>
                                    <tr class="info">
                                        <td colspan="6">
                                            <h4 class="header-toggle">
                                                <i class="fa fa-caret-down indicator fa-caret-up"></i>
                                                <?=$groupdetail['group']?>
                                                <span class="label label-info"><?=count($groupdetail['children'])?></span>
                                            </h4>
                                        </td>
                                    </tr>
                                    <? foreach($groupdetail['children'] as $key => $detail): ?>
                                        <?$price = (isset($detail['price']) && 0!==$detail['price'] ? $detail['price'].' руб.' : 0);?>

                                        <tr class="detail-row <?=($price!==0?'bg-success':'bg-danger')?> collapsed">
                                            <td><?=$i;?></td>
                                            <td>
                                                <?=(!empty($detail['name'])?$detail['name']:'<img alt="" src="/assets/img/daag.png">')?>

                                            </td>
                                            <td>
                                                <!-- <a href="/products/?type=products&article=<?=$detail['article']?>"><?=$detail['article']?></a> -->
                                                <a rel="nofollow" href="#" data-toggle="collapse" data-target="#<?=$detail['article']?>"><?=$detail['article']?>
                                                    <? if( !empty($cross_products) ): ?>
                                                        <? if( isset($cross_products[$detail['article']]) ): ?>
                                                            <small class="clearfix text-info">аналоги детали</small>
                                                        <?endif?>
                                                    <?endif?>
                                                </a>

                                            </td>
                                            <td><?=strtoupper($detail['manufacture'])?></td>
                                            <td class="text-right">
                                                <?=($price!==0 ? $price : '<img alt="" src="/assets/img/daag.png">')?>
                                            </td>
                                            <td>
                                                <div class="btn-group dropdown">
                                                    <button href="#" class="btn btn-info no-anchor dropdown-toggle" data-toggle="dropdown">
                                                        <i class="fa fa-cart-plus"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                        <li role="menuitem">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <form role="form" class="form product-qty">
                                                                        <input type="hidden" name="id" value="<?=$detail['_id']['$id']?>">
                                                                        <input type="hidden" name="article" value="<?=$detail['article']?>">
                                                                        <input type="hidden" name="name" value="<?=(!empty($detail['name'])?$detail['name']:'--')?>">
                                                                        <input type="hidden" name="price" value="<?=($price!==0 ? $price : 0)?>">

                                                                        <div class="form-group">
                                                                            <label for="qty">Выберите кол-во</label>
                                                                            <div class="input-group count-detail">
																				<span class="input-group-addon cart-qty cart-minus">
																					<i class="fa fa-minus"></i>
																				</span>
                                                                                <input name="qty" type="text" class="form-control text-right btn-number" placeholder="1" value="1">
																				<span class="input-group-addon cart-qty cart-plus">
																					<i class="fa fa-plus"></i>
																				</span>
																				<span class="input-group-addon cart-qty cart-refresh">
																					<i class="fa fa-refresh"></i>
																				</span>

                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group text-right">
                                                                            <a role="button" class="btn btn-primary add_to_cart">Добавить в корзину</a>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <a href="#" class="btn btn-info no-anchor" data-toggle="modal" data-target="#sendMessage">
                                                        <i class="fa fa-envelope"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <? if( !empty($cross_products) ): ?>
                                            <? if( isset($cross_products[$detail['article']]) ): ?>
                                                <tr class="collapse" id="<?=$detail['article']?>">
                                                    <td colspan="6" class="well">
                                                        <div class="panel panel-default col-md-offset-1 col-sm-offset-1">
                                                            <div class="panel-heading"><h5>Подходящие замены детали</h5></div>
                                                            <div class="panel-body">
                                                                <table class="table table-hover table-bordered">
                                                                    <col width="50px"/>
                                                                    <col/>
                                                                    <col/>
                                                                    <col/>
                                                                    <col/>
                                                                    <col width="100px"/>
                                                                    <thead>
                                                                    <tr>
                                                                        <th>№</th>
                                                                        <th>Наименование</th>
                                                                        <th>Код детали</th>
                                                                        <th>Производитель</th>
                                                                        <th>Цена</th>
                                                                        <th></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <? foreach($cross_products[$detail['article']] as $crossKey => $crossItem): ?>
                                                                        <? if( empty($crossItem['article']) ) continue; ?>

                                                                        <?$crossPrice = (isset($crossItem['price']) && 0!==$crossItem['price'] ? $crossItem['price'].' руб.' : 0);?>

                                                                        <tr class="detail-row <?=($crossPrice!==0?'bg-success':'bg-danger')?>">
                                                                            <td><?=($crossKey+1);?></td>
                                                                            <td>
                                                                                <?=(!empty($crossItem['name'])?$crossItem['name']:'<img alt="" src="/assets/img/daag.png">')?>
                                                                            </td>
                                                                            <td>
                                                                                <a href="/products/?type=products&article=<?=$crossItem['article']?>"><?=$crossItem['article']?></a>
                                                                            </td>
                                                                            <td><?=strtoupper($crossItem['manufacture'])?></td>
                                                                            <td class="text-right">
                                                                                <?=($crossPrice!==0 ? $crossPrice : '<img alt="" src="/assets/img/daag.png">')?>
                                                                            </td>
                                                                            <td>
                                                                                <div class="btn-group dropdown">
                                                                                    <button href="#" class="btn btn-info no-anchor dropdown-toggle" data-toggle="dropdown">
                                                                                        <i class="fa fa-cart-plus"></i>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                                                        <li role="menuitem">
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <form role="form" class="form product-qty">
                                                                                                        <input type="hidden" name="id" value="<?=$crossItem['_id']['$id']?>">
                                                                                                        <input type="hidden" name="article" value="<?=$crossItem['article']?>">
                                                                                                        <input type="hidden" name="name" value="<?=(!empty($crossItem['name'])?$crossItem['name']:'--')?>">
                                                                                                        <input type="hidden" name="price" value="<?=($crossPrice!==0 ? $crossPrice : 0)?>">

                                                                                                        <div class="form-group">
                                                                                                            <label for="qty">Выберите кол-во</label>
                                                                                                            <div class="input-group count-detail">
																				<span class="input-group-addon cart-qty cart-minus">
																					<i class="fa fa-minus"></i>
																				</span>
                                                                                                                <input name="qty" type="text" class="form-control text-right btn-number" placeholder="1" value="1">
																				<span class="input-group-addon cart-qty cart-plus">
																					<i class="fa fa-plus"></i>
																				</span>
																				<span class="input-group-addon cart-qty cart-refresh">
																					<i class="fa fa-refresh"></i>
																				</span>

                                                                                                            </div>

                                                                                                        </div>

                                                                                                        <div class="form-group text-right">
                                                                                                            <a role="button" class="btn btn-primary add_to_cart">Добавить в корзину</a>
                                                                                                        </div>
                                                                                                    </form>
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                    </ul>
                                                                                    <a href="#" rel="nofollow" class="btn btn-info no-anchor" data-toggle="modal" data-target="#sendMessage">
                                                                                        <i class="fa fa-envelope"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    <? endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?endif;?>
                                        <?endif;?>

                                        <? $i++; ?>
                                    <? endforeach; ?>
                                <? endif; ?>
                            <? endforeach; ?>
                            </tbody>
                        </table>
                    <?else:?>
                        <div class="alert alert-info text-center">
                            <p>
                                Деталей двигателя не найдено
                            </p>
                        </div>
                    <? endif; ?>
                </div>
            </div>

        </div>
    </div>
<? endif; ?>
    