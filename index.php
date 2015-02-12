<?php

require 'vendor/autoload.php';
require 'src/Ohkae/Ohkae.php';

$html = file_get_contents('test.html');

$dong = new Ohkae($html, 'wcag');
$dong->beginReport();