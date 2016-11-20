<?php

namespace Phisch90\OAuth\Server\Exception;

use Exception;

class AuthorizationServerException extends \Exception
{
    /**
     * @var string
     */
    private $errorCode;

    /**
     * @param string $message
     * @param int $code
     * @param Exception $previous
     * @param string $errorCode
     */
    public function __construct($message = "", $code = 0, Exception $previous = null, $errorCode = "")
    {
        $this->errorCode = $errorCode;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }
}
