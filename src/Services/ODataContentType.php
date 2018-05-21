<?php

namespace SaintSystems\OData\Services;


use SaintSystems\OData\ODataJsonResponseProcessor;
use SaintSystems\OData\ODataXmlResponseProcessor;

class ODataContentType
{
    const JSON = 'json';
    const ATOMPUB_XML = 'xml';

    /**
     * @param $headers
     * @return string
     */
    private function getResponseContentType($headers)
    {
        if (!$headers || !count($headers)) return self::JSON;

        if (!isset($headers['content-type'])) {
            $contentType = $headers['Content-Type'][0];
        } else {
            $contentType = $headers['content-type'][0];
        }

        if (stripos($contentType, "application/atom+xml") !== false) {
            return self::ATOMPUB_XML;
        }
        if (stripos($contentType, "application/json") !== false) {
            return self::JSON;
        }
        return self::JSON;
    }

    /**
     * @param $headers
     * @return ODataJsonResponseProcessor|ODataXmlResponseProcessor
     */
    public function getType($headers)
    {
        switch ($this->getResponseContentType($headers)) {
            case self::JSON:
                return new ODataJsonResponseProcessor;
            case self::ATOMPUB_XML:
                return new ODataXmlResponseProcessor;
        }
        return new ODataJsonResponseProcessor;
    }
}