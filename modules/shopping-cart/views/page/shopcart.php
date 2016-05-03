<?
//echo '<pre>';
//print_r( $cart );

?>
<div class="container-fluid" id="shopping-cart-page">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-xs-12 wow fadeInRight animated">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h1><?=$title?></h1>
				</div>
				
				<div class="panel-body">
					<div class="row" role="contentinfo">
						<div class="col-md-12 col-xs-12 col-sm-12" id="cart-items">
							<? if(!empty($cart) && isset($cart['products']) && count($cart['products'])): ?>
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
						            <? $i=1; ?>
						            <?foreach($cart['products'] as $key => $product):?>
						            	<tr data-row="<?=$product['id']?>" class="row-item-detail table-hover">
							            	<td><?=$i;?></td>
							            	<td><?=$product['name'];?></td>
							            	<td><?=$product['article'];?></td>
							            	<td class="text-center count-item">
												<div class="form-group">
													<input type="hidden" name="data-qty" value="<?=$product['qty'];?>">
													<input type="hidden" name="id" value="<?=$product['id']?>">
													<input type="hidden" name="name" value="<?=$product['name'];?>">
													<input type="hidden" name="article" value="<?=$product['article']?>">
													<input type="hidden" name="price" value="<?=$product['price'];?>">
													
							                        <div class="input-group count-detail">
														<span class="input-group-addon cart-qty cart-minus">
															<i class="fa fa-minus"></i>
														</span>
							                            <input name="qty" type="text" class="form-control text-right btn-number" value="<?=$product['qty'];?>">
														<span class="input-group-addon cart-qty cart-plus">
															<i class="fa fa-plus"></i>
														</span>
														<span class="input-group-addon cart-qty cart-refresh">
															<i class="fa fa-refresh"></i>
														</span>
							                        </div>
							                    </div>
							            	</td>
							            	<td class="text-right price-item">
								            	<?=$product['price'];?> руб.
								            	<?if((float)$product['price'] <= 0):?>
								            	<small class="clearfix text-info">под заказ</small>
								            	<?endif;?>
							            	</td>
							            	<td class="text-right subtotal-item">
								            	<?=sprintf('%01.2f', ($product['price']*$product['qty']));?> руб.
								            </td>
							            	<td class="text-center">
								            	<button data-id="<?=$product['id']?>" class="btn btn-danger remove-item" title="Удалить деталь: <?=$product['article']?>" data-toggle="modal" data-target="#removeProduct">
								            		<i class="fa fa-remove"></i>
								            	</button>
							            	</td>
						            	</tr>
						            	<? $i++; ?>
						            <?endforeach;?>
						            </tbody>
						            <tfoot>
							            <tr class="bg-info">
								            <td colspan="5" class="text-right">
									            <span class="lead">Итого:</span>
								            </td>
								            <td colspan="2" class="text-left">
									            <div class="col-md-12">
										            Товаров: <span class="total-count">
										            	<strong><?=$cart['total']['count']?></strong>
										            </span>
									            </div>
									            <div class="col-md-12">
										            На сумму: <span class="total-cost">
										            	<strong><?=sprintf('%01.2f', $cart['total']['price'])?></strong> руб.
										            </span>
									            </div>
									            
								            </td>
							            </tr>
							            <tr class="bg-success">
								            <td colspan="4" class="text-right">
									            <button id="clear-cart" type="button" class="btn btn-danger">Очистить корзину</button>
								            </td>
								            <td colspan="3" class="text-right">
									            <button type="button" class="btn btn-info" id="refresh-cart">Пересчитать</button>
									            <button type="button" class="btn btn-primary">Оформить заказ</button>
								            </td>
							            </tr>
						            </tfoot>
								</table>
							
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

<!--noindex-->
<div id="removeProduct" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Удаление детали из корзины</h4>
            </div>
            <div class="modal-body">
                <div class="row">
	                <div class="col-md-12 col-xs-12 col-sm-12">
		                <input type="hidden" name="id" value="">
		                <p>
			                Вы действительно хотите удалить деталь из корзины? 
			                
			                <table class="table table-bordered table-condensed detail-info">
				                <tbody>
					                <tr>
						                <th>Название:</th>
						                <th><span class="text-info name"></span></th>
					                </tr>
					                <tr>
						                <th>Артикул:</th>
						                <th><span class="text-info article"></span></th>
					                </tr>
					                <tr>
						                <th>Цена:</th>
						                <th><span class="text-info price"></span></th>
					                </tr>
				                </tbody>
			                </table>
			            </p>
	                </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-danger" id="remove-product">
                    	<span class="glyphicon glyphicon-cog"></span>
                    	Удалить
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>

    </div>
</div>
<!--/noindex-->