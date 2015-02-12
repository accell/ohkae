<?php

namespace Ohkae\Guidelines;

class Wcag extends OhkaeReport implements OhkaeGuidelineInterface
{
    public static $defined_tests = [
        'imgHasAlt',
        'tableHasHeader',
        'tableHeaderHasScope',
        'contentHasHeadings',
        'textHasContrast'
    ];

    // public function getVerbage()
    // {

    // }

    // public function addReport()
    // {
        
    // }
}