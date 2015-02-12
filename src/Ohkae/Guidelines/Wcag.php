<?php

namespace Ohkae\Guidelines;

class Wcag extends OhkaeReport implements OhkaeGuidelineInterface
{
    public $defined_tests = [
        'imgHasAlt',
        'tableHasHeader',
        'tableHeaderHasScope',
        'contentHasHeadings',
        'textHasContrast'
    ];

    public function getVerbage()
    {

    }

    public function iterateTests()
    {
        foreach ($defined_tests as $test) {
            $test_result = OhkaeTests::$test.'()';
        }
    }

    public function addReport()
    {
        
    }
}