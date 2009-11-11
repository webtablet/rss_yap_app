<?php

//BEGIN: config

//the url of the feed to use
$feedUrl = 'http://news.discovery.com/rss/news/';

//the name of the template to use
$templatePath = 'templates/standard.php';

//END: config

//fetch data for template.  Note: template depends on this var
$feed = simplexml_load_file($feedUrl);

//render template
require $templatePath;

?>