<?php
function my_autoloader($class) {
	
	include "classes/".$class.".php";

}
spl_autoload_register('my_autoloader');

	$site = new site;
	
	$site->addHeader("header.php");
	
	$site->addFooter("footer.php");
	
	$page = new page;
	
?>