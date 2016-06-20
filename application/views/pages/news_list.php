<? if(!empty($page)): ?>
<?
Breadcrumbs::clean();
Breadcrumbs::set([
    URL::base() => 'Главная',
    '/news' => $page['menutitle']
]);
?>
<!-- Keep all page content within the page-content inset div! -->
<div class="container-fluid">

    <div class="row">
        <div class="col-xs-12 col-sm-12 wow fadeInRight animated">

            <div class="panel panel-default">
				<div class="panel-heading">
				    <div class="container-fluid">
				        <div class="col-xs-12 col-sm-12 col-md-12">
				            <h1><?=$page['pagetitle']?></h1>
				        </div>
				    </div>
				</div>
				                            
				<div class="panel-body">
				    <div class="row" role="contentinfo">
				        <?=$page['pagecontent']?>
				        <? if(isset($page['children'])&&!empty($page['children'])): ?>
				        	<div class="container-fluid">
					        	<div class="row" id="news-list">
						        	<? foreach($page['children'] as $key => $item): ?>
						        		<div class="col-md-12 col-sm-12 col-xs-12 news-item" role="article">
							        		<div class="panel panel-default" role="article">
								        		<div class="panel-heading">
									        		<h4><?=$item['pagetitle']?></h4>
									        		<span class="label label-primary pull-right text-center news-date">
										        		<?if(is_array($item['datecreate'])):?>
									        				<? $timestamp = strtotime(date('d.m.Y', $item['datecreate']['sec'])); ?>
									        			<?else:?>
									        				<?$timestamp = strtotime($item['datecreate']);?>
									        			<?endif;?>
									        			
									        			<span class="day row">
								        					<?=date('d.m', $timestamp)?>
								        				</span>
								        				<span class="year row">
								        					<?=date('Y', $timestamp)?>
								        				</span>
									        		</span>
								        		</div>
								        		<div class="panel-body">
									        		<div class="row">
										        		<div class="col-md-4">
											        		<div class="col-md-12 text-center">
												        		<img class="img-responsive" src="/upload_images/<?=$item['description_img']?>" alt="<?=$item['pagetitle']?>" title="<?=$item['pagetitle']?>"/>
											        		</div>
											        		
										        		</div>
										        		<div class="col-md-8">
											        		<p><?=html_entity_decode($item['description'])?></p>
										        		</div>
									        		</div>
									        		<div class="panel pull-right">
										        		<?=HTML::anchor($item['pagealias'], 'Подробнее', [
											        		'class'	=> 'btn btn-primary'
											        	])?>
									        		</div>
								        		</div>
							        		</div>
						        		</div>
						        		<hr />
						        	<? endforeach; ?>
					        	</div>
				        	</div>
				        	
				        	<?=$pagination;?>
				        	
				        <? endif; ?>
				    </div>
				</div>
            </div>
        </div>
    </div>
</div>

<?endif;?>