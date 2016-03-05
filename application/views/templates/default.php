<!DOCTYPE html>
<html lang="ru">
	
	<head>
	    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	    <title><?php echo $title;?></title>
	    <meta name="keywords" content="<?php echo $meta_keywords;?>" />
	    <meta name="description" content="<?php echo $meta_description;?>" />
	    <meta name="copyright" content="<?php echo $meta_copywrite;?>" />
	    
	    <?php foreach($styles as $file => $type) { echo HTML::style($file, array('media' => $type)), "\n"; }?>
	    <?php foreach($scripts as $file) { echo HTML::script($file, NULL, TRUE), "\n"; }?>
	  </head>
	
<body>
	<div id="container">
	    <?php echo $header;?>
	    <table width="100%">
		    <tr valign="top">
			    <td width="50%">
				    <?php echo $content;?>
			    </td>
			    <td width="50%">
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
</body>
	
</html>