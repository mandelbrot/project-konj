<?php 
ob_start();

include 'functions.php';
session_start();

//slovo	  	numerical   hex
//Š 	  	&#352;      \u0160
//š 	  	&#353;      \u0161
//E 	  	&#268;      \u010C
//e 	  	&#269;      \u010D
//A 	  	&#262;      \u0106
//a 	  	&#263;      \u0107
//Ž 	  	&#381;      \u017D
//ž 	  	&#382;      \u017E
//? 	  	&#272;      \u0110
//? 	  	&#273;      \u0111

if (isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
	$loggedin = TRUE;
}
else $loggedin = FALSE;

echo "<head><title>$appname";
if ($loggedin) echo " ($user)";
echo "</title>";

echo '
	<meta name="description" 
	content="Konj Racing" />
	<meta name="description" content="Brdsko treanje">	
	<meta name="Target" 
	content="Konj Racing, orijentacija, brdsko treanje, planinsko treanje, mountain running
        fell running, orienteering, SRD 315 Sjeverozapad, Ivaneica, Ivanšaica, Ravna Gora, Eevo, 
        mjerenje vremena, analiza rezultata" />
	<meta name="keywords" 
	content="Konj Racing, orijentacija, brdsko treanje, planinsko treanje, mountain running
        fell running, orienteering, SRD 315 Sjeverozapad, Ivaneica, Ivanšaica, Ravna Gora, Eevo, 
        mjerenje vremena, analiza rezultata" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="author" 
	content="Marko Leljak" />
	<meta http-equiv="expires" 
	content="Fri, 04 Apr 2015 23:59:59 GMT" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="URL" content="http://konj.315-sjeverozapad.hr/">
	<meta name="language" content="Croatian">

    <link rel="stylesheet" type="text/css" href="assets/css/bootmetro.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootmetro-responsive.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootmetro-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootmetro-ui-light.css">
    <link rel="stylesheet" type="text/css" href="assets/css/datepicker.css">

    <!--  these two css are to use only for documentation -->
    <link rel="stylesheet" type="text/css" href="assets/css/docs.css">
    <link rel="stylesheet" type="text/css" href="assets/js/google-code-prettify/prettify.css" >

    <!-- Grab Google CDN\'s jQuery. fall back to local if necessary -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>window.jQuery || document.write("<script src=\'assets/js/jquery-1.8.3.min.js\'>\x3C/script>")</script>
    
    <!--[if IE 7]>
    <script type="text/javascript" src="scripts/bootmetro-icons-ie7.js">
    <![endif]-->
    
    <script type="text/javascript" src="assets/js/google-code-prettify/prettify.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/bootmetro-panorama.js"></script>
    <script type="text/javascript" src="assets/js/bootmetro-pivot.js"></script>
    <script type="text/javascript" src="assets/js/bootmetro-charms.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="assets/js/holder.js"></script>
    <script type="text/javascript" src="assets/js/Chart.min.js"></script>
    
    <script type="text/javascript" src="assets/js/docs.js"></script>
    
    <!-- All JavaScript at the bottom, except for Modernizr and Respond.
      Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
      For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
    <script src="assets/js/modernizr-2.6.2.min.js"></script>

    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push([\'_setAccount\', \'UA-3182578-6\']);
      _gaq.push([\'_trackPageview\']);
      (function() {
         var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
         ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
         var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>

</head>';
?>
