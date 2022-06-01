<?php

namespace NiceOpeningLaravel\Exceptions;

/**
 * Class NiceException
 *
 * This is the class that NiceExternal is expected to throw, which the caller needs to handle properly.
 * It has the Nice specific errors which is useful for troubleshooting.
 *
 * @package NiceOpeningLaravel\Exceptions
 */
class NiceException extends \Exception
{
    private $details = array();

    function __construct($details)
    {
        if (is_array($details)) {
            $message = $details['errcode'] . ': ' . $details['message'];
            parent::__construct($message);
            $this->details = $details;
        } else {
            $message = $details;
            parent::__construct($message);
        }
    }

    public function getErrorCode()
    {
        return $this->details['errcode'] ?? '';
    }

    public function getErrorMessage()
    {
        return $this->details['message'] ?? '';
    }

    public function getDetails()
    {
        return $this->details['data'] ?? [];
    }
}
