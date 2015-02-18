<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Ohkae\Ohkae;

$html   = file_get_contents('test.html');
$ignore = [
	'imgHasAlt',
	'obsoleteElement',
];

$report = (new Ohkae($html, 'wcag', null, null))->runReport();

die(dump(json_decode($report)));