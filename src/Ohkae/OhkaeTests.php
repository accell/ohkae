<?php

namespace Ohkae;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelector;

class OhkaeTests extends Ohkae
{
    /**
     * Images need alternative text
     * @param  object $dom  - The DOMCrawler object being scanned
     * @param  string $test - The name of this test
     */
    public function imgHasAlt($dom, $test)
    {
        $priority = self::OHKAE_ERROR;

        $dom->filter('img')->each(function ($node, $i) use ($priority, $test) {
            if (!$node->attr('alt') || $node->attr('alt') == '' || $node->attr('alt') == ' ') {
                $this->addReportItem($node, $priority, $test);
            }
        });

        die();
    }

    /**
     * Tables need headings (<th> tags)
     * @param  object $dom  - The DOMCrawler object being scanned
     * @param  string $test - The name of this test
     */
    public function tableHasHeader($dom, $test)
    {
        $priority = self::OHKAE_ERROR;

        foreach ($dom->getElementsByTagName('table') as $table) {
            foreach ($table->childNodes as $child) {
                if($child->nodeName == 'tr') {
                    foreach($child->childNodes as $td) {
                        if($td->nodeName !== 'th') {
                            $this->addReportItem($table, $priority, $test);

                            break 2;
                        } else {
                            return;
                        }
                    }
                }
            }
        }
    }

    /**
     * Table headers (<th>) need to have a scope
     * @param  object $dom  - The DOMCrawler object being scanned
     * @param  string $test - The name of this test
     */
    public function tableHeaderHasScope($dom, $test)
    {
        $priority = self::OHKAE_ERROR;

        foreach ($dom->getElementsByTagName('table') as $table) {
            foreach ($table->childNodes as $child) {
                if($child->nodeName == 'tr') {
                    foreach($child->childNodes as $th) {
                        if($th->nodeName == 'th') {
                            if (!$th->hasAttribute('scope')) {
                                $this->addReportItem($th, $priority, $test);

                                break 2;
                            }
                        }
                    }
                }
            }
        }

        return;
    }

    /**
     * Content should be marked with headings for structure/outlining purposes
     * @param  object $dom  - The DOMCrawler object being scanned
     * @param  string $test - The name of this test
     */
    public function contentHasHeadings($dom, $test)
    {
        $priority = self::OHKAE_SUGGESTION;

        foreach ($dom->getElementsByTagName('body')->item(0)->childNodes as $child) {
            if ($child->nodeName == 'h1'
                || $child->nodeName == 'h2'
                || $child->nodeName == 'h3'
                || $child->nodeName == 'h4'
                || $child->nodeName == 'h5'
                || $child->nodeName == 'h6') {
                return;
            }
        }

        $this->addReportItem(null, $priority, $test);
    }

    /**
     * Don't use these obsolete HTML elements
     * @param  object $dom  - The DOMCrawler object being scanned
     * @param  string $test - The name of this test
     */
    public function obsoleteElement($dom, $test)
    {
        $priority = self::OHKAE_ERROR;

        $obsoleteElements = [
            'acronym',
            'applet',
            'basefont',
            'big',
            'blink',
            'center',
            'dir',
            'frame',
            'frameset',
            'isindex',
            'listing',
            'noembed',
            'plaintext',
            'spacer',
            'strike',
            'tt',
            'xmp',
        ];

        foreach ($dom->getElementsByTagName('body')->item(0)->childNodes as $child) {
            foreach ($obsoleteElements as $obsolete) {
                if ($child->nodeName == $obsolete) {
                    $this->addReportItem($child, $priority, $test);
                }
            }
        }
    }

    /**
     * Text needs to have proper contrast against its background
     * @param  object $dom  - The DOMCrawler object being scanned
     * @param  string $test - The name of this test
     */
    public function textHasContrast($dom, $test)
    {
        return;
    }
}
