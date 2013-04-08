#!/usr/bin/php -q
<?php

// just create from the proto file a pb_prot[NAME].php file
$base = dirname( __FILE__ ).'/';

require_once($base.'parser/pb_parser.php');

$test = new PBParser();
$test->parse($argv[1]);

echo "File parsing done!\n";

?>