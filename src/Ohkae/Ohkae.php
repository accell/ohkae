<?php

namespace Ohkae;

class Ohkae
{
    const OHKAE_ERROR = 1,
          OHKAE_SUGGESTION = 2;

    public $dom,
           $html,
           $theReport,
           $guideline;

    /**
     * The class constructor
     * @param string $html      - The HTML retrieved from a file
     * @param string $guideline - The guideline standard to be followed
     */
    public function __construct($html, $guideline)
    {
        $this->dom       = new \DOMDocument();
        $this->html      = $html;
        $this->guideline = $guideline;

        $this->dom->loadHtml('<?xml encoding="utf-8" ?>'. $this->html);
    }

    /**
     * [beginReport description]
     * @return [type]
     */
    public function getReport()
    {
        $this->report = OhkaeReport::getTests();
    }

    /**
     * [parse description]
     * @return [type]
     */
    public function parse()
    {
        return json_encode($the_report);
    }
}