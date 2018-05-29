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
        if (!count($headers)) return self::JSON;

        $headers = array_change_key_case($headers, CASE_LOWER);

        $contentType = $headers['content-type'][0];

        if (stripos($contentType, "application/atom+xml") !== false || stripos($contentType, "application/xml") !== false) {
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