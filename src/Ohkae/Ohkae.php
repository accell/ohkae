<?php

namespace Ohkae;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelector;

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
     * @param string $html        - The HTML retrieved from a file
     * @param string $guideline   - The guideline standard to be followed
     * @param array $ignoredTests - Any tests to be ignored
     */
    public function __construct($html, $guideline)
    {
        // $this->dom       = new \DOMDocument();
        $this->dom       = new Crawler($html);
        $this->html      = $html;
        $this->guideline = $guideline;
    }

    /**
     * Adds an item to the report list when a test fails
     * @param object $element  - The problem element
     * @param string $priority - The priority of the problem
     * @param string $test     - The name of the test that failed
     */
    public function addReportItem($element, $priority, $test)
    {
        $testItem = [
            'title'       => $test,
            'description' => '$verbage',
            'prority'     => $priority,
        ];

        // Sometimes we don't need to pass in an element
        if (is_object($element)) {
            $testItem['lineNo'] = $element->getNode(0)->getLineNo();
        }

        if (!$testItem['html'] = $element->html()) {
            $testItem['html'] = $element->getNode(0)->ownerDocument->saveHTML($element->getNode(0));
        }

        die(dump($testItem));

        switch ($priority) {
            case self::OHKAE_ERROR:
                $this->report['errors'][] = $testItem;
                break;
            case self::OHKAE_SUGGESTION:
                $this->report['suggestions'][] = $testItem;
                break;
        }
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
