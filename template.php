<?php

/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH; ?>/css/template.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH; ?>/css/custom-theme/jquery-ui-1.8.16.custom.css" media="screen" />
    <script type="text/javascript" src="<?php echo BASE_PATH; ?>/js/jquery-1.8.1.min.js" ></script>
	<script type="text/javascript" src="<?php echo BASE_PATH; ?>/js/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_PATH; ?>/js/jquery.ui.datepicker-it.js"></script>
    <script type="text/javascript" src="<?php echo BASE_PATH; ?>/js/library.js"></script>
    <script type="text/javascript" src="<?php echo BASE_PATH; ?>/js/library_table.js"></script>
    <script type="text/javascript" src="<?php echo BASE_PATH; ?>/js/library_province.js"></script>
    
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="robots" content="noindex" />
	<title></title>
    <script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-11396188-6']);
		  _gaq.push(['_trackPageview']);

		  (function() 
		  	{
		    	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			}
		  )();
	</script>
</head>
<body>
	<div> <!--style="position: fixed; width: 99%; top: 0; z-index: 2;"-->
		<div class="ui-tabs ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header" style="border: 1px solid grey; min-height: 60px;">
		   	<div style="background-image: url(<?php echo BASE_PATH; ?>/img/logo.png); background-repeat: no-repeat; min-height:80px; background-color: #FFF">
    			<?php include BASE_PATH."/modules/mod_userpanel.php" ?>
	        </div>
    	</div>
    </div>
    <div class="layout_container"><!--style="margin-top: 80px;"-->
	    <div style="margin-top: 20px;">
			<?php 
				if ($GLOBALS['offline'])
				{
					$result["statusMessage"] = "Il server è in aggiornamento!";
				}
				include_once BASE_PATH."/modules/mod_error.php" 
			?>
		</div>
        <div>
			<?php
                if (!$GLOBALS['offline'] && isset($page))
                {
                    include_once $page;
                }
            ?>
		</div>
	</div>
    <div id="dialog">
	</div>
    <p style="text-align: center; margin: 1px; "><span style="font-size: 8pt;">© 2011 Accademia Euromediterranea - P.IVA 03672840877 </span></p>
    <p style="text-align: center; margin: 1px;"><span style="font-size: 8pt;">Port v. 1.4 </span></p>
    <p style="text-align: center; margin: 1px;"><span style="font-size: 8pt;">Script Written by <a href="http://www.linkedin.com/in/christianrizza">Christian Rizza</a></span></p>
</body>
</html>