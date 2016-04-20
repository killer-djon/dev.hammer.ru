<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title><?php echo $title;?></title>
    <meta name="keywords" content="<?php echo $meta_keywords;?>" />
    <meta name="description" content="<?php echo $meta_description;?>" />
    <meta name="copyright" content="<?php echo $meta_copywrite;?>" />
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
<div id="container">
    <?php echo $header;?>
    <?php echo $content;?>
    <?php echo $footer;?>
</div>

<? if( !empty($scripts['footer']) ): ?>
    <?php foreach($scripts['footer'] as $file) {
        echo HTML::script($file, NULL, NULL), "\n";
    }?>
<? endif; ?>
</body>

</html>