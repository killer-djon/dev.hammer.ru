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
	    <table width="100%">
		    <tr valign="top">
			    <td width="70%">
				    <?php echo $content;?>
			    </td>
			    <td width="30%">
				    <h3>Поиск</h3>
				    <h4>1. По коду двигателя</h4>
				    <form action="/categories" method="get">
					    <input placeholder="Наименование двигателя" type="type" name="search" value=""/>
					    <input type="submit" value="Искать">
				    </form>
				    
				    <h4>2. По коду запчасти</h4>
				    <form action="/products" method="get">
					    <input placeholder="Код запчасти" type="type" name="search" value=""/>
					    <input type="submit" value="Искать">
				    </form>
			    </td>
		    </tr>
		    
	    </table>
	    <?php echo $footer;?>
    </div>

    <!-- script footer tags -->
	<? if( !empty($scripts['footer']) ): ?>
		<?php foreach($scripts['footer'] as $file) {
			echo HTML::script($file, NULL, NULL), "\n";
		}?>
	<? endif; ?>
    <!-- script footer tags -->
</body>
	
</html>