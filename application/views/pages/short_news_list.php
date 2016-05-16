
<section class="feature-detail well" id="news">
    <div class="container-fluid">

        <div class="pricing-heading text-center">
            <h3>Свежие новости мира авто</h3>
        </div>

		<div id="carousel-news" class="carousel slide" data-load="ajax" data-href="/api/v1/html/news" data-view="short_news">
		</div>
    </div>
    
    <div class="text-center col-md-12">
        <?
	        echo HTML::anchor('news', 'Все новости', [
		        'class'	=> 'text-info',
		        'role'	=> 'button'
			]);
	    ?>
    </div>
</section>