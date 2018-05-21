<?php

namespace SaintSystems\OData;


class ODataXmlResponseProcessor implements IODataResponseProcessor
{
    /**
     * @param $responseBody
     * @return array|string
     */
    public function decodeResponseBody($responseBody)
    {
        return $this->xmlToArray($responseBody);
    }

    /**
     * @param $xml
     * @return array|string
     */
    private function xmlToArray($xml)
    {

        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        $root = $doc->documentElement;
        $output = $this->nodeToArray($root);
        $output['@root'] = $root->tagName;

        return $output;
    }

    /**
     * @param $node
     * @return array|string
     */
    private function nodeToArray($node)
    {
        $output = array();

        switch ($node->nodeType) {
            case XML_CDATA_SECTION_NODE:
            case XML_TEXT_NODE:

                $output = trim($node->textContent);
                break;
            case XML_ELEMENT_NODE:

                for ($i = 0, $m = $node->childNodes->length; $i < $m; $i++) {
                    $child = $node->childNodes->item($i);
                    $value = $this->nodeToArray($child);

                    if (isset($child->tagName)) {
                        $key = $child->tagName;
                        if (!isset($output[$key])) {
                            $output[$key] = array();
                        }
                        $output[$key][] = $value;
                    } elseif ($value || $value === '0') {
                        $output = (string)$value;
                    }
                }

                if ($node->attributes->length && !is_array($output)) {
                    $output = array('@content' => $output);
                }

                if (is_array($output)) {
                    if ($node->attributes->length) {
                        $array = array();
                        foreach ($node->attributes as $attrName => $attrNode) {
                            $array[$attrName] = (string)$attrNode->value;
                        }
                        $output['@attributes'] = $array;
                    }
                    foreach ($output as $key => $value) {
                        if (is_array($value) && count($value) == 1 && $key != '@attributes') {
                            $output[$key] = $value[0];
                        }
                    }
                }
                break;
        }
        return $output;
    }
}