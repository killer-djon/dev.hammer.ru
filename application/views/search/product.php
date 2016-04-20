<a href="/">На главную</a>
<? if( !empty($empty_parts) ): ?>
	<p><?=$empty_parts?></p>
<? else: ?>
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
	<? if( !empty($parts) ): ?>
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
	<? endif; ?>
<? endif; ?>
