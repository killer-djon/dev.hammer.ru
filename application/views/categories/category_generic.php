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
