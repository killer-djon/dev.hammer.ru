<?if( !empty($data) ):?>
	<? $items = $data['items']; ?>
	<? $limit = 3 ?>
	<? if( $data['pagination']['total_items'] > 0 && $data['pagination']['total_items'] > $limit ): ?>
	<? $item_per_page = round($data['pagination']['total_items']/$limit); ?>
	
	<div class="row">
		<div class="carousel-inner news-list-block" role="listbox">		
			<? for( $i = 0, $len = (int)$item_per_page; $i < $len; $i++ ): ?>
				<div class="item news-item <?=($i == 0)?'active':''?>">
					<div class="row row-centered">
					<? $start = $i * $limit; ?>	
					<? $end = ($i+1) * $limit; ?>
					
					<? for( $a = $start; $a < $end; $a++ ): ?>
						<? if(isset($items[$a])): ?>
							<? $item = $items[$a]; ?>
							<div class="col-centered col-xs-12 col-md-3 col-sm-4 wow zoomIn animated">
								<div class="single-table panel">
				                    <div class="table-heading">
				                        <h4><?=$item['pagetitle']?></h4>
				                    </div>
				                    <div class="table-price">
					                    <img class="img-responsive" src="/upload_images/<?=$item['description_img']?>" alt="<?=$item['pagetitle']?>">
				                    </div>
				                    <div class="table-description text-muted">
				                        <p>
					                        <?=Text::limit_chars($item['description'], 150, ' ', TRUE);?>...
				                        </p>
				                    </div>
				                    <div class="row">
				                        <div class="col-md-12 text-center btn-more">
				                            <?=HTML::anchor($item['pagealias'], 'Подробнее...', [
					                            'class'	=> 'btn btn-info read-more',
					                            'role'	=> 'button'
					                        ])?>
				                        </div>
				                    </div>
				                </div>
							</div>
						<? endif; ?>
					<? endfor; ?>
					</div>
				</div>
			<? endfor; ?>
		</div>
	</div>
	
	<!--
	<ol class="carousel-indicators">
	<? for( $i = 0, $len = (int)$item_per_page; $i < $len; $i++ ): ?>
		<?if($i==0):?>
			<li data-target="#carousel-news" data-slide-to="<?=$i?>" class="active"></li>
		<?else:?>
			<li data-target="#carousel-news" data-slide-to="<?=$i?>"></li>
		<?endif;?>
	<? endfor; ?>
	</ol>
	-->
	
	<nav class="" role="navigation">
		<ul class="pagination carousel-indicators row row-centered">
			<? for( $i = 0, $len = (int)$item_per_page; $i < $len; $i++ ): ?>
				<li data-target="#carousel-news" data-slide-to="<?=$i?>" class="page-item <?=($i==0)?'active':''?>">
					<a rel="nofollow" class="page-link" href="#"><?=$i?></a>
				</li>
			<? endfor; ?>
		</ul>
	</nav>	<?endif;?>
<? endif; ?>