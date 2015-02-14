<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Ohkae\Ohkae;

$html = file_get_contents('test.html');

$ohkae = new Ohkae($html, 'wcag');
$report = $ohkae->runReport();

die(dump($report));