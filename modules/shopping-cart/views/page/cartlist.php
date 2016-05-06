<div id="shopping-cart-list" class="panel-collapse collapse in">
    <div class="panel-body">
        <table class="table table-bordered table-condensed table-responsive cart_content_form">
            <col/>
            <col/>
            <col/>
            <col width="20%"/>
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
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <? $i = 1; ?>
            <? foreach ($cart['products'] as $key => $product): ?>
                <tr data-row="<?= $product['id'] ?>" class="row-item-detail table-hover">
                    <td><?= $i; ?></td>
                    <td><?= $product['name']; ?></td>
                    <td><?= $product['article']; ?></td>
                    <td class="text-center count-item">
                        <div class="form-group">
                            <input type="hidden" name="data-qty" value="<?= $product['qty']; ?>">
                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="name" value="<?= $product['name']; ?>">
                            <input type="hidden" name="article" value="<?= $product['article'] ?>">
                            <input type="hidden" name="price" value="<?= $product['price']; ?>">

                            <div class="input-group count-detail">
																		<span
                                                                            class="input-group-addon cart-qty cart-minus">
																			<i class="fa fa-minus"></i>
																		</span>
                                <input name="qty" type="text" class="form-control text-right btn-number"
                                       value="<?= $product['qty']; ?>">
																		<span
                                                                            class="input-group-addon cart-qty cart-plus">
																			<i class="fa fa-plus"></i>
																		</span>
																		<span
                                                                            class="input-group-addon cart-qty cart-refresh">
																			<i class="fa fa-refresh"></i>
																		</span>
                            </div>
                        </div>
                    </td>
                    <td class="text-right price-item">
                        <?= $product['price']; ?> руб.
                        <? if ((float)$product['price'] <= 0): ?>
                            <small class="clearfix text-info">под заказ</small>
                        <? endif; ?>
                    </td>
                    <td class="text-right subtotal-item">
                        <?= sprintf('%01.2f', ($product['price'] * $product['qty'])); ?> руб.
                    </td>
                    <td class="text-center">
                        <button data-id="<?= $product['id'] ?>" class="btn btn-danger remove-item"
                                title="Удалить деталь: <?= $product['article'] ?>" data-toggle="modal"
                                data-target="#removeProduct">
                            <i class="fa fa-remove"></i>
                        </button>
                    </td>
                </tr>
                <? $i++; ?>
            <? endforeach; ?>
            </tbody>
            <tfoot>
            <tr class="bg-info">
                <td colspan="5" class="text-right">
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
            <tr class="bg-success">
                <td colspan="7" class="text-right">

                    <button type="button" class="btn btn-info" id="refresh-cart">Пересчитать</button>
                    <button type="button" class="btn btn-primary">Оформить заказ</button>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>