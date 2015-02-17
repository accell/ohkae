<?php

namespace Ohkae;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelector;

class Ohkae
{
    const OHKAE_ERROR      = 'error',
          OHKAE_SUGGESTION = 'suggestion';

    /**
     * @var object $dom       - A DOMCrawler object created from the HTML
     * @var array $report     - The completed results of the Ohkae scan
     * @var array $tests      - A list of accessibility guideline tests to be run
     * @var string $guideline - Which standard to follow
     * @var object $verbage   - Names and descriptions for each accessibility test
     */
    public static $dom,
                  $guideline,
                  $ignored,
                  $report,
                  $tests,
                  $verbage;

    /**
     * The class constructor
     * @param string $html      - The HTML retrieved from a file
     * @param string $guideline - The guideline standard to be followed
     * @param array $ignored    - Array of tests to be ignored
     * @param string $verbage   - File path to your customized verbage file
     */
    public function __construct($html, $guideline, $ignored = null, $verbage = null)
    {
        self::$dom       = new Crawler($html);
        self::$guideline = $guideline;

        if ($ignored) {
            self::$ignored = $ignored;
        }

        if ($verbage) {
            self::$verbage   = json_decode(utf8_encode(file_get_contents($verbage)));
        } else {
            self::$verbage   = json_decode(utf8_encode(file_get_contents(__DIR__ . '/verbage.json')));
        }
    }

    /**
     * Determines which tests to load and runs them against the DOMCrawler object
     * @return array - The complete results of the Ohkae scan
     */
    public function runReport()
    {
        switch (self::$guideline) {
            case 'wcag':
                self::$tests = Guidelines\Wcag::$definedTests;
                break;
            case 'section508':
                self::$tests = Guidelines\Section508::$definedTests;
                break;
        }

        if (self::$dom) {
            // filter out ignored tests
            if (self::$ignored) {
                self::$tests = array_diff(self::$tests, self::$ignored);
            }

            foreach (self::$tests as $test) {
                OhKaeTests::$test($test);
            }
        }

        return self::$report;
    }

    /**
     * Adds an item to the report list when a test fails
     * @param object $element  - The problem element
     * @param string $priority - The priority of the problem
     * @param string $test     - The name of the test that failed
     */
    protected static function addReportItem($element, $priority, $test)
    {
        $testItem = [
            'name'        => $test,
            'title'       => self::$verbage->$test->title,
            'description' => self::$verbage->$test->desc,
            'prority'     => $priority,
        ];

        if (is_object($element)) {
            $testItem['lineNo'] = $element->getNode(0)->getLineNo();
            $testItem['html']   = $element->getNode(0)->ownerDocument->saveHTML($element->getNode(0));
        }

        // Special case for the obsolete element test
        if ($test == 'obsoleteElement') {
            $testItem['title'] .= ' '.$element->nodeName();
        }

        switch ($priority) {
            case self::OHKAE_ERROR:
                self::$report[self::OHKAE_ERROR][] = $testItem;
                break;
            case self::OHKAE_SUGGESTION:
                self::$report[self::OHKAE_SUGGESTION][] = $testItem;
                break;
        }
    }
}
