<div class="panel-heading">
    <div class="container-fluid">
        <div class="col-xs-12 col-sm-12 col-md-7">
            <h1><? echo $title;?></h1><img src="/assets/img/daag.png" alt="">
        </div>
        <div class="col-xs-12 col-sm-12 col-md-5 pull-right">
            <form class="" role="form">
                <label class="control-label ">Поиск по названию производителя</label>
                <div class="input-group">
                    <input type="text" placeholder="Поиск производителя" class="form-control">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default" title="Поиск производителя">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
                            
<div class="panel-body">
    <div class="row">
        <? if( !empty($categories) ): ?>
            <? foreach( $categories as $key => $category ): ?>
                <div class="col-xs-6 col-sm-4 col-md-3">
                    <? echo HTML::anchor("/categories/view/".$category['name'], $category['name']); ?>
                </div>
            <? endforeach; ?>
        <? endif; ?>
    </div>
</div>