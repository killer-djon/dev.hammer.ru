<!-- main section -->
<div role="main">
    <div id="wrapper" class="">
        <? echo View::factory('templates/second/sidebar_left')->render(); ?>

        <!-- Page content -->
        <div id="page-content-wrapper">
            <? echo (isset($breadcrumbs)?$breadcrumbs:''); ?>
            
			<? echo $category_view; ?>
            <!-- news list -->
        </div>

        <!-- contact section -->
		<aside class="text-center hidden-xs">
			<div class="row">
				<div id="map_canvas"></div>
			</div>
		</aside><!-- end of contact section -->
    </div>
</div>
<!-- main section -->