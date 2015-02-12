<?php

namespace Ohkae;

class Ohkae
{
    public $dom,
           $html,
           $theReport,
           $guideline;

    public function __construct($html, $guideline)
    {
        $this->dom       = new DOMDocument();
        $this->guideline = 'wcag';

        $this->dom->loadHtml($html);

        die(dump($this->dom));
    }

    public function beginReport()
    {
        $this->report = new OhKaeReport($guideline);
    }

    public function parse()
    {
        return json_encode($the_report);
    }
}