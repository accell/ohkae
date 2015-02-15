<?php

namespace Ohkae;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelector;

class OhkaeTests extends Ohkae
{
    /**
     * Content should be marked with headings for structure/outlining purposes
     * @param string $test - The name of this test
     */
    public static function contentHasHeadings($test)
    {
        $priority   = parent::OHKAE_SUGGESTION;
        $noHeadings = true;

        parent::$dom->filter('body')->children()->each(function ($node, $i) use ($priority, $test, &$noHeadings) {
            if ($node->nodeName() === 'h1'
                || $node->nodeName() === 'h2'
                || $node->nodeName() === 'h3'
                || $node->nodeName() === 'h4'
                || $node->nodeName() === 'h5'
                || $node->nodeName() === 'h6') {
                $noHeadings = false;
                return;
            }
        });

        if ($noHeadings) {
            parent::addReportItem(null, $priority, $test);
        }
    }

    /**
     * Images need alternative text
     * @param string $test - The name of this test
     */
    public static function imgHasAlt($test)
    {
        $priority = parent::OHKAE_ERROR;

        parent::$dom->filter('img')->each(function ($node, $i) use ($priority, $test) {
            if (!$node->attr('alt') || $node->attr('alt') == '' || $node->attr('alt') == ' ') {
                parent::addReportItem($node, $priority, $test);
            }
        });
    }

    /**
     * Image alt text should be less than 100 characters
     * @param string $test - The name of this test
     */
    public static function imgAltTooLong($test)
    {
        $priority = parent::OHKAE_ERROR;

        parent::$dom->filter('img')->each(function ($node, $i) use ($priority, $test) {
            if (strlen($node->attr('alt')) > 100) {
                parent::addReportItem($node, $priority, $test);
            }
        });
    }

    /**
     * Don't use these obsolete HTML elements
     * @param string $test - The name of this test
     */
    public static function obsoleteElement($test)
    {
        $priority = parent::OHKAE_ERROR;
        $obsolete = [
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

        parent::$dom->filter('body')->children()->each(function($node, $i) use ($priority, $test, $obsolete) {
            foreach ($obsolete as $o) {
                if ($node->nodeName() == $o) {
                    parent::addReportItem($node, $priority, $test);
                }
            }
        });
    }

    /**
     * Tables need headings (<th> tags)
     * @param string $test - The name of this test
     */
    public static function tableHasHeader($test)
    {
        $priority = parent::OHKAE_ERROR;

        parent::$dom->filter('table')->each(function($node, $i) use ($priority, $test) {
            if ($node->children()->filter('tr')->first()->children()->first()->nodeName() !== 'th') {
                parent::addReportItem($node, $priority, $test);
            }
        });
    }

    /**
     * Table headers (<th>) need to have a scope
     * @param string $test - The name of this test
     */
    public static function tableHeaderHasScope($test)
    {
        $priority = parent::OHKAE_ERROR;

        parent::$dom->filter('table')->each(function($node, $i) use ($priority, $test) {
            $node->children()->filter('th')->each(function($node, $i) use ($priority, $test) {
                if (!($node->attr() == 'col' || $node->attr() == 'row')) {
                    parent::addReportItem($node, $priority, $test);
                }
            });
        });
    }

    /**
     * Text needs to have proper contrast against its background
     * @param string $test - The name of this test
     */
    public static function textHasContrast($test)
    {
        // coming soon to a theater near you
    }
}
