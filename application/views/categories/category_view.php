<div class="panel-heading">
    <div class="container-fluid">
        <div class="col-xs-12 col-sm-12 col-md-7">
            <h1><? echo $title;?></h1><img src="/assets/img/daag.png" alt="">
        </div>
        <div class="col-xs-12 col-sm-12 col-md-5 pull-right">
            <form class="form" role="form">
                <label class="control-label ">Поиск по названию производителя</label>
                <div class="input-group">
                    <input id="search-view" type="text" placeholder="Поиск производителя" class="form-control">
                    
                    <span class="input-group-btn">
                        <button id="clear-search-input" type="button" class="btn btn-default" title="Сбросить значение">
                            <i class="fa fa-eraser"></i>
                        </button>
                    </span>
                    
                </div>
            </form>
        </div>
    </div>
</div>
                            
<div class="panel-body">
    <div class="row" id="category-list" role="list">
        <? if( !empty($categories) ): ?>
            <? foreach( $categories as $key => $category ): ?>
                <div class="col-xs-6 col-sm-4 col-md-3" role="listitem">
                    <? echo HTML::anchor("/categories/view/".$category['name'], $category['name']); ?>
                </div>
            <? endforeach; ?>
        <? endif; ?>
    </div>
</div>