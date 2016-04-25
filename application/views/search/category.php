<? if( !empty($empty_categories) ): ?>
	<div class="alert alert-info text-center">
		<p><?=$empty_categories?></p>
	</div>
<? else: ?>
	<? if( !empty($parts) ): ?>
		<div class="table-responsive">
			<table class="table table-hover">
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
		</div>
	<? endif; ?>
<? endif; ?>


