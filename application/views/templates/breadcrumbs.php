<? $breadcrumbs = Breadcrumbs::get(); ?>
<? if( !empty($breadcrumbs) ): ?>
    <div id="breadcrumbs" class="well">
        <ol vocab="http://schema.org/" typeof="BreadcrumbList" class="breadcrumb">
            <? $i = 1; ?>
            <? foreach( $breadcrumbs as $link => $title ): ?>
                <li property="itemListElement" typeof="ListItem">
                    <a property="item" typeof="WebPage"
                       href="<? echo $link; ?>">
                        <span property="name"><? echo $title; ?></span></a>
                    <meta property="position" content="<? echo $i; ?>">
                </li>
                <? $i++; ?>
            <? endforeach; ?>
        </ol>
    </div>
<? endif; ?>