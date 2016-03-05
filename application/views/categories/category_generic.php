<a href="/">На главную</a>
<? if( !empty($categories) ): ?>

	<h2>Производитель <?=$current['name']?></h2>
	<table width="100%">
		<thead>
			<tr>
				<td width="50px">№</td>
				<td>Наименование модели</td>
			</tr>
		</thead>
		<tbody>
	<? foreach( $categories as $key => $category ): ?>
		<tr>
			<td><?=($key+1)?>.</td>
			<td><a href="/categories/generic/<?=$current['name']?>/<?=$category['name']?>"><?=$category['name']?></a></td>
			<!--<td><a href="/categories/generic/<?=$current['name']?>/<?=$category['name']?>"><?=$category['name']?></td>-->
		</tr>
	<? endforeach; ?>
		</tbody>
	</table>
<? endif; ?>