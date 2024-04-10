<?php

namespace App\Exceptions;

use Exception;

class MissingAttributeException extends Exception
{
    public function __construct($attributeName)
    {
        $message = "The attribute '$attributeName' must be set in the model.";
        parent::__construct($message);
    }
}
