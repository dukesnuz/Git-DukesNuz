<?php
/***************************This is the home page for dukesnuz******************************/
/******I have split the site pages up into sections*****************************************/
/*******Header, main section, footer*******************************************************/
/******************ALso uses pages  clock-php-javascript.php.php, date-time.inc.html, time.js********/

$title = "Clock";

include('../views/header.inc.html');


//Get current year
//http://www.w3schools.com/php/func_date_date.asp
	$now = new DateTime();
	$date = $now->format('l F d, Y');
	
	$now = new DateTime();
	$dayofyear = $now->format('z');
	
	$daysleft = 365-$dayofyear;




include('../views/date_time.inc.html');

include('../views/footer.inc.html');

?>
     