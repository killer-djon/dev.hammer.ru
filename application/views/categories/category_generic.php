<div class="panel-heading">
    <div class="container-fluid">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h1><? echo $title;?></h1><img src="/assets/img/daag.png" alt="">
        </div>
    </div>
</div>
<div class="panel-body">
    <div class="row">
        <? if( !empty($categories) ): ?>
            <? foreach( $categories as $key => $category ): ?>
                <div class="col-xs-6 col-sm-4 col-md-3">
                    <? echo HTML::anchor("/categories/generic/{$current['name']}/{$category['name']}", $category['name']); ?>
                </div>
            <? endforeach; ?>
        <? endif; ?>
    </div>
</div>
