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
								<div id="accordion" class="panel-group">

									<!-- panel for shopping cart -->
									<div class="panel panel-default">
										<div class="panel-heading">
											<h3 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" data-target="#shopping-cart-list">
													Наличие деталей в корзине
												</a>
											<button data-toggle="modal" data-target="#clearCart" type="button" class="btn btn-danger pull-right fa fa-eraser" title="Очистить корзину"></button>
											<div class="clearfix"></div>
											</h3>

										</div>
										<?=View::factory('page/cartlist', ['cart'   => $cart])->render();?>

									</div>
								    <!-- panel for shopping cart -->
                                    <?=View::factory('page/checkout')->render();?>

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
                        </p>
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

<!--noindex-->
<!--clear cart modal form-->
<div id="clearCart" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Очистить корзину</h4>
            </div>
            <div class="modal-body">
                <div class="row">
	                <div class="col-md-12 col-xs-12 col-sm-12">
		                <input type="hidden" name="id" value="">
		                <p>
			                Вы действительно хотите удалить все товары в корзине и завершить покупки? 
			            </p>
	                </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-danger" id="clear-cart">
                    	<span class="glyphicon glyphicon-cog"></span>
                    	Очистить
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>

    </div>
</div>
<!--clear cart modal form-->
<!--/noindex-->

