<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Ohkae\Ohkae;

$html = file_get_contents('test.html');

$dong = new Ohkae($html, 'wcag');
$dong->getReport();