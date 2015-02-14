<?php

namespace Ohkae\Guidelines;

class Section508
{
    public static $definedTests = [
        'contentHasHeadings',
        'imgHasAlt',
        'imgAltTooLong',
        'obsoleteElement',
        'tableHasHeader',
        'tableHeaderHasScope',
        'textHasContrast',
    ];
}
