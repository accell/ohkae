<?php

namespace Ohkae;

class OhkaeTests extends Ohkae
{
    public function imgHasAlt($dom, $test)
    {
        $priority = 'Error';

        foreach ($dom->getElementsByTagName('img') as $img) {
            if (!$img->hasAttribute('alt') or $img->getAttribute('alt') == '') {
                $this->addReportItem($img, $priority, $test);
            }
        }
    }

    public function tableHasHeader($dom, $test)
    {
        $priority = 'Error';

        foreach ($dom->getElementsByTagName('table') as $table) {
            foreach ($table->childNodes as $child) {
                if($child->nodeName == 'tr') {
                    foreach($child->childNodes as $td) {
                        if($td->nodeName !== 'th') {
                            $this->addReportItem($table, $priority, $test);

                            break 2;
                        }
                    }
                }
            }
        }
    }

    public function tableHeaderHasScope($dom, $test)
    {
        return;
    }

    public function contentHasHeadings($dom, $test)
    {
        $priority = 'Suggestion';

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

    public function textHasContrast($dom, $test)
    {
        return;
    }
}