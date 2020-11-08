<?php

require 'vendor/autoload.php';

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);


dump($uri);
// check uri if user is accessing post or page


echo '322';
