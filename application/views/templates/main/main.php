<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9,IE=edge,chrome=1" /><![endif]-->
    <title><?php echo $title;?></title>
    <meta name="keywords" content="<?php echo $meta_keywords;?>" />
    <meta name="description" content="<?php echo $meta_description;?>" />
    <meta name="copyright" content="<?php echo $meta_copywrite;?>" />

    <meta name="viewport" content="initial-scale=1.0" />
    <meta name="author" content="Hammerschmidt">
    <meta name='yandex-verification' content='579324aaff5279b8' />
    <link id="favicon" rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>

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

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-79581544-1', 'auto');
        ga('send', 'pageview');

    </script>


    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter15914218 = new Ya.Metrika({
                        id:15914218,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true,
                        webvisor:true,
                        trackHash:true,
                        ut:"noindex"
                    });
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
    </script>

    <!-- /Yandex.Metrika counter -->
</head>

<body>
<noscript><div><img src="https://mc.yandex.ru/watch/15914218?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>


<?php echo $header;?>
<?php echo $content;?>
<?php echo $footer;?>

<? if( !empty($scripts['footer']) ): ?>
    <?php foreach($scripts['footer'] as $file) {
        echo HTML::script($file, NULL, NULL), "\n";
    }?>
<? endif; ?>
<?=HTML::script('/assets/js/shopping_cart_main.js');?>
<?=HTML::script('/assets/js/validator.min.js');?>

</body>

</html>