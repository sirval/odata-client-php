<?php

namespace SaintSystems\OData;

/**
 * Interface for decoding response body
 */
interface IODataResponseProcessor {

    /**
     * @param $responseBody
     * @return array
     */
    public function decodeResponseBody($responseBody);
}