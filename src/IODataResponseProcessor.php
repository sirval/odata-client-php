<?php

namespace SaintSystems\OData;

/**
 * Interface for decoding response body
 */
interface IODataResponseProcessor {

    /**
     * @return array
     */
    public function decodeResponseBody($responseBody);
}