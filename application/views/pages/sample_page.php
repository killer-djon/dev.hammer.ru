<? if(!empty($page)): ?>
<?
Breadcrumbs::clean();
Breadcrumbs::set([
    URL::base() => 'Главная',
    '/'.$page['pagealias'] => $page['menutitle'],
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
						<div class="col-md-12 col-xs-12 col-sm-12">
							<?=html_entity_decode($page['pagecontent'])?>
						</div>
					</div>
				</div>
				
                
            </div>
        </div>
    </div>
</div>
<?endif;?>
<?=View::factory('pages/short_news_list')->render()?>