<a href="/">На главную</a>
<? if( !empty($categories) ): ?>

	<h2>Модель <?=$current['name']?></h2>
	<table width="100%">
		<thead>
			<tr>
				<td width="50px">№</td>
				<td>Коды двигателей</td>
			</tr>
		</thead>
		<tbody>
	<? foreach( $categories as $key => $category ): ?>
		<tr>
			<td><?=($key+1)?>.</td>
			<td><a href="/categories/<?=$current['parentName']?>/<?=$category['name']?>"><?=$category['name']?></a></td>
		</tr>
	<? endforeach; ?>
		</tbody>
	</table>
<? endif; ?>