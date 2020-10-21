<?php

namespace Likemusic\DbColumnsUpdater\Processors\Html;

use DOMDocument;
use DOMXPath;
use Likemusic\DbColumnsUpdater\Processors\Base\BaseProcessor;

class HtmlRemoveAttributes extends BaseProcessor
{
    public function process(string $text, array $args, array $context = [])
    {
        $resultEncoding = isset($args['encoding']) ? $args['encoding'] : 'UTF-8';
        $dom = new DOMDocument('1.0', $resultEncoding);
        $dom->loadHTML('<?xml encoding="' . $resultEncoding . '">' . $text, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOBLANKS | LIBXML_NOENT | LIBXML_NONET | LIBXML_NOXMLDECL | LIBXML_NSCLEAN);
        $xpath = new DOMXPath($dom);
        $nodes = $xpath->query('//@*');

        foreach ($nodes as $node) {
            $node->parentNode->removeAttribute($node->nodeName);
        }

        return $dom->saveHTML($dom->documentElement);
    }
}
