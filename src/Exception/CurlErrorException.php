<?php

declare(strict_types=1);

namespace Montonio\Exception;

class CurlErrorException extends \RuntimeException
{
    private \CurlHandle $ch;

    public function __construct(
        string $message = "",
        int $code = 0,
        \CurlHandle $ch = null,
        ?\Throwable $previous = null
    ) {
        $this->ch = $ch;
        parent::__construct($message, $code, $previous);
    }

    public function getCurlHandle(): \CurlHandle
    {
        return $this->ch;
    }
}
