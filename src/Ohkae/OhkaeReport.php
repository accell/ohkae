<?php

namespace Ohkae;

class OhkaeReport extends Ohkae
{
    public $results,
           $verbage;

    public static function getTests($dom, $html, $guideline)
    {
        dump($foo, $bar, $baz);

        switch ($this->guideline) {
            case 'wcag':
                $this->tests = Guidelines\Wcag::$defined_tests;

                die(dump('die', $this->tests));

                break;
        }
    }


    public function runTests($guideline)
    {
        if ('the guideline function exists' and $this->dom) {

        }
    }
}