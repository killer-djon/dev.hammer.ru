<a href="/">На главную</a>
<? if( !empty($categories) ): ?>
	<table width="100%">
		<thead>
			<tr>
				<td width="50px">№</td>
				<td>Наименование производителя</td>
			</tr>
		</thead>
		<tbody>
	<? foreach( $categories as $key => $category ): ?>
		<tr>
			<td><?=($key+1)?>.</td>
			<td><a href="/categories/view/<?=$category['name']?>"><?=$category['name']?></a></td>
		</tr>
	<? endforeach; ?>
		</tbody>
	</table>
<? endif; ?>