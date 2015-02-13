<?php

namespace Ohkae;

class Ohkae
{
    const OHKAE_ERROR      = 'Error',
          OHKAE_SUGGESTION = 'Suggestion';

    public $dom,
           $html,
           $report,
           $tests,
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

    public function addReportItem($element, $priority, $test)
    {
        if (is_object($element) and method_exists($element, 'getLineNo')) {
            $lineNo = $element->getLineNo();
        }

        $testItem = [
            'title' => $test,
            'description' => '$verbage',
            'prority' => $priority,
            'html' => $element ? htmlspecialchars($this->getHtml($element)) : '',
        ];

        switch ($priority) {
            case 'Error':
                $this->report['errors'][] = $testItem;
                break;
            case 'Suggestion':
                $this->report['suggestions'][] = $testItem;
                break;
        }

        dump($this->report);
    }

    public function buildReport()
    {

    }

    public function getHtml($element)
    {
        $temp_dom = new \DOMDocument();

        try {
            $problem_html = $temp_dom->createElement(utf8_encode($element->tagName));
        } catch (Exception $e) {

        }

        foreach ($element->attributes as $attribute) {
            $problem_html->setAttribute($attribute->name, $attribute->value);
        }

        $problem_html->nodeValue = htmlentities($element->nodeValue);

        $temp_dom->appendChild($problem_html);

        $problem_html = $temp_dom->saveHTML();

        return $problem_html;
    }

    /**
     * [beginReport description]
     * @return [type]
     */
    public function runReport()
    {
        $this->getTests();
    }

    public function getTests()
    {
        switch ($this->guideline) {
            case 'wcag':
                $this->tests = Guidelines\Wcag::$defined_tests;
                break;
        }

        $this->runTests();
    }

    /**
     * [parse description]
     * @return [type]
     */
    public function parseResults()
    {
        die(dump($this->report));
    }

    public function runTests()
    {
        if ($this->dom) {
            $testIterator = new OhKaeTests($this->html, $this->guideline);

            foreach ($this->tests as $test) {
                $testIterator->$test($this->dom, $test);
            }
        }
    }
}