<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title><?php echo $title;?></title>
    <meta name="keywords" content="<?php echo $meta_keywords;?>" />
    <meta name="description" content="<?php echo $meta_description;?>" />
    <meta name="copyright" content="<?php echo $meta_copywrite;?>" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, maximum-scale=1" /> 
    <script type="text/javascript" charset="utf-8" src="//api-maps.yandex.ru/services/constructor/1.0/js/?sid=eFnBnTDCnz2AffGQJhpuTjBira_BWco9&height=450&id=map_canvas"></script>
    <?php foreach($styles as $file => $type) { echo HTML::style($file, array('media' => $type)), "\n"; }?>

    <? if( !empty($scripts['header']) ): ?>
        <?php foreach($scripts['header'] as $file) {
            echo HTML::script($file, NULL, NULL), "\n";
        }?>
    <? endif; ?>

    <!--[if lt IE 9]>
	    <? echo HTML::script('assets/js/html5shiv.js', NULL, NULL), "\n"; ?>
	    <? echo HTML::script('assets/js/respond.min.js', NULL, NULL), "\n"; ?>
    <![endif]-->
</head>

<body>
<?php echo $header;?>
<?php echo $content;?>
<?php echo $footer;?>

<? if( !empty($scripts['footer']) ): ?>
    <?php foreach($scripts['footer'] as $file) {
        echo HTML::script($file, NULL, NULL), "\n";
    }?>
<? endif; ?>
<?=HTML::script('/assets/js/shopping_cart.js');?>
<?=HTML::script('/assets/js/validator.min.js');?>
</body>

</html>