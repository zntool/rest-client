<?php

namespace ZnTool\RestClient\Yii\Web\formatters;

use DOMDocument;

class XmlFormatter extends RawFormatter
{

    public function getName(): string
    {
        return 'xml';
    }

    public function format(string $content): string
    {
        $dom = new DOMDocument;
        $dom->formatOutput = true;
        $dom->loadXML($content);
        $xmlContent = $dom->saveXML();
        return $xmlContent;
    }
}