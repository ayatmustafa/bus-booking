<?php

namespace App\Exceptions;

use Exception;
use App\Common\Response;

class ExceptionMessage extends Exception
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        return false;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return $this->message;
    }
}
