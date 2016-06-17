<? if(!empty($page)): ?>
<?

Breadcrumbs::clean();
Breadcrumbs::set([
    URL::base() => 'Главная',
    '/news' => 'Автомобильные новости',
    $page['pagealias'] => $page['menutitle']
]);
?>

<!-- Keep all page content within the page-content inset div! -->
<div class="container-fluid">

    <div class="row">
        <div class="col-xs-12 col-sm-12 wow fadeInRight animated">

            <div class="panel panel-default" id="news-item" role="article">
				<div class="panel-heading">
				    <div class="container-fluid">
				        <div class="col-xs-12 col-sm-12 col-md-12">
				            <h1><?=$page['pagetitle']?></h1>
				        </div>
				    </div>
				    
				    <span class="label label-primary pull-right text-center news-date">
	        			<?if(is_array($page['datecreate'])):?>
	        				<? $timestamp = strtotime(date('d.m.Y', $page['datecreate']['sec'])); ?>
	        			<?else:?>
	        				<?$timestamp = strtotime($$page['datecreate']);?>
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
					<div class="row" role="contentinfo">
						<div class="col-md-12 col-xs-12 col-sm-12">
							<?=html_entity_decode($page['pagecontent'])?>
						</div>
					</div>
				</div>
				
               
            </div>
            
            <div class="well text-center">
                <?=HTML::anchor('news', 'К списку новостей', ['class'	=> 'btn btn-primary']);?>
            </div>
        </div>
    </div>
</div>
<?endif;?>
<?=View::factory('pages/short_news_list')->render()?>