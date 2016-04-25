<? if( !empty($empty_parts) ): ?>
	<div class="alert alert-info text-center">
		<p><?=$empty_parts?></p>
	</div>
<? else: ?>

		<? if( !empty($cross_products) ): ?>
			<h3>Возможные замены деталей двигателя <?=$current['name']?></h3>
			<div class="">
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
			            <tr class="info">
				            <td colspan="6">
					            <h4 class="header-toggle"><i class="fa fa-caret-down indicator fa-caret-up"></i>
					            Возможные замены деталей</h4>
					        </td>
			            </tr>
			            <? foreach($cross_products as $key => $detail): ?>
						<tr class="detail-row collapsed">
							<td><?=($key+1);?></td>
							<td><?=$detail['name']?></td>
							<td>
								<a href="/products/?type=products&article=<?=$detail['article']?>"><?=$detail['article']?></a>
							</td>
							<td><?=strtoupper($detail['manufacture'])?></td>
							<td>0.00 руб.</td>
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
									                    <div class="form-group">
									                        <label for="qty">Выберите кол-во</label>
									                        <div class="input-group count-detail">
																<span class="input-group-addon cart-qty cart-minus">
																	<i class="fa fa-minus"></i>
																</span>
									                            <input type="text" class="form-control text-right btn-number" placeholder="1" value="1">
																<span class="input-group-addon cart-qty cart-plus">
																	<i class="fa fa-plus"></i>
																</span>
																<span class="input-group-addon cart-qty cart-refresh">
																	<i class="fa fa-refresh"></i>
																</span>
									
									                        </div>
															
									                    </div>
									                    
									                    <div class="form-group text-right">
										                    <button type="button" class="btn btn-primary" id="add_to_cart">Добавить в корзину</button>
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
		            </tbody>
				</table>
			</div>
	    <? endif; ?>
	
		<?if( !empty($parts) ):?>
			<div class="">
				<h3>Детали двигателя <?=$current['name']?></h3>
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
		                        <td colspan="6"><h4 class="header-toggle"><i class="fa fa-caret-down indicator fa-caret-up"></i><?=$groupdetail['group']?></h4></td>
		                    </tr>
		                    <? foreach($groupdetail['children'] as $key => $detail): ?>
		                        <tr class="detail-row collapsed">
		                            <td><?=$i;?></td>
		                            <td><?=$detail['name']?></td>
		                            <td>
		                                <a href="/products/?type=products&article=<?=$detail['article']?>"><?=$detail['article']?></a>
		                            </td>
		                            <td><?=strtoupper($detail['manufacture'])?></td>
		                            <td>0.00 руб.</td>
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
											                    <div class="form-group">
											                        <label for="qty">Выберите кол-во</label>
											                        <div class="input-group count-detail">
																		<span class="input-group-addon cart-qty cart-minus">
																			<i class="fa fa-minus"></i>
																		</span>
											                            <input type="text" class="form-control text-right btn-number" placeholder="1" value="1">
																		<span class="input-group-addon cart-qty cart-plus">
																			<i class="fa fa-plus"></i>
																		</span>
																		<span class="input-group-addon cart-qty cart-refresh">
																			<i class="fa fa-refresh"></i>
																		</span>
											
											                        </div>
																	
											                    </div>
											                    
											                    <div class="form-group text-right">
												                    <button type="button" class="btn btn-primary" id="add_to_cart">Добавить в корзину</button>
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
		                        <? $i++; ?>
		                    <? endforeach; ?>
		                <? endif; ?>
		            <? endforeach; ?>
		            </tbody>
		        </table>
		    </div>
		<? endif; ?>
<? endif; ?>
    


<? /*if( !empty($parts) ): ?>

	<? if( !empty($cross_products) ): ?>
		<div style="background: #f0f0f0; padding: 15px;">
		<h3>Аналогичные детали</h3>
		<table width="100%">
			<thead>
				<tr>
					<td width="50px">№</td>
					<td>Наименование запчасти</td>
					<td>Код запчасти</td>
					<td>Производитель</td>
					<td>Кол-во</td>
					<td>Цена</td>
				</tr>
			</thead>
			<tbody>
				<? foreach($cross_products as $key => $detail): ?>
					<tr>
						<td width="50px"><?=($key+1);?></td>
						<td><?=$detail['name']?></td>
						<td>
							<a href="/products/?type=products&article=<?=$detail['article']?>"><?=$detail['article']?></a>
						</td>
						<td><?=strtoupper($detail['manufacture'])?></td>
						<td>0</td>
						<td>0.00 руб.</td>
					</tr>
				<? endforeach; ?>
			</tbody>
		</table>
		</div>
		
	<? endif; ?>
	<br><br>
	
	<table width="100%">
		<thead>
			<tr>
				<td width="50px">№</td>
				<td>Наименование запчасти</td>
				<td>Код запчасти</td>
				<td>Производитель</td>
				<td>Кол-во</td>
				<td>Цена</td>
			</tr>
		</thead>
		<tbody>
			
		<? $i = 1; ?>
		<? foreach($parts as $groupdetail): ?>
			<? if( isset($groupdetail['children']) && !empty($groupdetail['children']) ): ?>
				<tr>
					<td colspan="6"><h4><?=$groupdetail['group']?></h4></td>
				</tr>
				<? foreach($groupdetail['children'] as $key => $detail): ?>
					<tr>
						<td width="50px"><?=$i;?></td>
						<td><?=$detail['name']?></td>
						<td>
							<a href="/products/?type=products&article=<?=$detail['article']?>"><?=$detail['article']?></a>
						</td>
						<td><?=strtoupper($detail['manufacture'])?></td>
						<td>0</td>
						<td>0.00 руб.</td>
					</tr>
					<? $i++; ?>
				<? endforeach; ?>
			<? endif; ?>
		<? endforeach; ?>
		</tbody>
	</table>
<? endif;*/ ?>