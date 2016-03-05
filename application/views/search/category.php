<a href="/">На главную</a>

<? if( !empty($empty_categories) ): ?>
	<p><?=$empty_categories?></p>
<? else: ?>
	<? if( !empty($parts) ): ?>
	
		<table width="100%">
			<thead>
				<tr>
					<th>Марка</th>
					<th>Код двигателя</th>
				</tr>
			</thead>
			<tbody>
				
		<? foreach($parts as $key => $category): ?>
			<tr>
				<td><?=$category['auto']?></td>
				<td><a href="/categories/<?=$category['auto']?>/<?=$category['name']?>"><?=$category['name']?></a></td>
			</tr>
		<? endforeach; ?>
			</tbody>
		</table>
	<? endif; ?>
<? endif; ?>


