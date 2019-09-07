<?php

namespace SaintSystems\OData;

class ODataJsonResponseProcessor implements IODataResponseProcessor
{
    /**
     * @param $responseBody
     * @return array|mixed
     */
    public function decodeResponseBody($responseBody)
    {
        return json_decode($responseBody , true);
    }
}