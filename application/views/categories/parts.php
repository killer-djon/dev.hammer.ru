<? if( !empty($parts) ): ?>
    <? if( !empty($cross_products) ): ?>

    <? endif; ?>

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