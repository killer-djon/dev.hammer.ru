<div id="pagination" class="text-center">
	<nav>
		<ul class="pagination">
			<!-- first page link -->
			<?php if ($first_page !== FALSE): ?>
				<li class="page-item">
					<a class="page-link" href="<?=HTML::chars($page->url($first_page))?>" aria-label="First" rel="nofollow">
						<span aria-hidden="true"><?=__('First')?></span>
					</a>
				</li>
			<?php else: ?>
				<li class="page-item disabled">
					<a rel="nofollow" class="page-link" href="#" aria-label="First">
						<span aria-hidden="true"><?=__('First')?></span>
					</a>
				</li>
			<?php endif ?>
			<!-- first page link -->
			
			<!-- Previous page link -->
			<?php if ($previous_page !== FALSE): ?>
				<li class="page-item">
					<a class="page-link" href="<?=HTML::chars($page->url($previous_page))?>" aria-label="Previous" rel="nofollow">
						<span aria-hidden="true"><?=__('Previous')?></span>
					</a>
				</li>
			<?php else: ?>
				<li class="page-item disabled">
					<a class="page-link" href="#" aria-label="Previous" rel="nofollow">
						<span aria-hidden="true"><?=__('Previous')?></span>
					</a>
				</li>
			<?php endif ?>
			<!-- Previous page link -->
			
			<!-- pagination items -->
			<?php for ($i = 1; $i <= $total_pages; $i++): ?>
		
				<?php if ($i == $current_page): ?>
					<li class="page-item active">
						<a class="page-link" href="#"><?=$i?></a>
					</li>
				<?php else: ?>
					<li class="page-item"><a class="page-link" href="<?=HTML::chars($page->url($i))?>"><?=$i?></a></li>
				<?php endif ?>
		
			<?php endfor ?>
			<!-- pagination items -->
			
			<!-- next page link -->
			<?php if ($next_page !== FALSE): ?>
				<li class="page-item">
					<a class="page-link" href="<?=HTML::chars($page->url($next_page))?>" aria-label="Next" rel="nofollow">
						<span aria-hidden="true"><?=__('Next')?></span>
					</a>
				</li>
			<?php else: ?>
				<li class="page-item disabled">
					<a class="page-link" href="#" aria-label="Next" rel="nofollow">
						<span aria-hidden="true"><?=__('Next')?></span>
					</a>
				</li>
			<?php endif ?>
			<!-- next page link -->
		
			<!-- last page link -->
			<?php if ($last_page !== FALSE): ?>
				<li class="page-item">
					<a class="page-link" href="<?=HTML::chars($page->url($last_page))?>" aria-label="Last" rel="nofollow">
						<span aria-hidden="true"><?=__('Last')?></span>
					</a>
				</li>
			<?php else: ?>
				<li class="page-item disabled">
					<a class="page-link" href="#" aria-label="Last" rel="nofollow">
						<span aria-hidden="true"><?=__('Last')?></span>
					</a>
				</li>
			<?php endif ?>
			<!-- last page link -->
		</ul>
	</nav>
</div>