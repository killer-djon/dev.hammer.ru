<a href="/">На главную</a>
<? if( !empty($empty_parts) ): ?>
	<p><?=$empty_parts?></p>
<? else: ?>
	<? if( !empty($parts) ): ?>
		<h3>Список возможных замен для детали: <?=$current['name']?>&mdash;<?=$current['article']?></h3>
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
			<? foreach($parts as $key => $detail): ?>
				<tr>
					<td width="50px"><?=$i;?></td>
					<td><?=$detail['name']?></td>
					<td>
						<a href="/products/?type=crosses&product=<?=$current['article']?>&article=<?=$detail['article']?>"><?=$detail['article']?></a>
					</td>
					<td><?=strtoupper($detail['manufacture'])?></td>
					<td>0</td>
					<td>0.00 руб.</td>
				</tr>
				<? $i++; ?>
			<? endforeach; ?>
			</tbody>
		</table>
	<? endif; ?>
<? endif; ?>
