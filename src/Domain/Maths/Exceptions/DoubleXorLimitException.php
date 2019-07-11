<?php

namespace App\Domain\Maths\Exceptions;

use Exception;
use Throwable;

class DoubleXorLimitException extends Exception
{
    /***
     * DoubleXorLimitException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
