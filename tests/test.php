<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Ohkae\Ohkae;

$html = file_get_contents('test.html');

$ignore = [
	'imgHasAlt',
	'obsoleteElement',
];

$ohkae = new Ohkae($html, 'wcag', null, null);
$report = $ohkae->runReport();

die(dump(json_decode($report)));