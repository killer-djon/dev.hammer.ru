
<? if( !empty($empty_parts) ): ?>
	<div class="alert alert-info text-center">
		<p><?=$empty_parts?></p>
	</div>
<? else: ?>
	<? if( !empty($cross_products) ): ?>
		<h3>Список возможных замен для детали: <?=$current['name']?>&mdash;<?=$current['article']?></h3>
		<div class="table-responsive">
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
			            <td colspan="6"><h4>Возможные замены деталей</h4></td>
		            </tr>
		            <? foreach($cross_products as $key => $detail): ?>
					<tr class="detail-row">
						<td><?=($key+1);?></td>
						<td><?=$detail['name']?></td>
						<td>
							<a href="/products/?type=products&article=<?=$detail['article']?>"><?=$detail['article']?></a>
						</td>
						<td><?=strtoupper($detail['manufacture'])?></td>
						<td>0.00 руб.</td>
						<td>
							<div class="btn-group">
                                <button type="button" data-toggle="modal" data-target="#shopCount" class="btn btn-info">
                                    <i class="fa fa-cart-plus"></i>
                                </button>
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
	
	<? if( !empty($parts) ): ?>
		<h4>Подходящие детали по условию поиска</h4>
		<div class="table-responsive">
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
		                                <div class="btn-group">
		                                    <button type="button" data-toggle="modal" data-target="#shopCount" class="btn btn-info">
		                                        <i class="fa fa-cart-plus"></i>
		                                    </button>
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
