<?php

namespace Api\Exceptions;

class BadRequestException extends \Exception
{
    
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
        
    }
    
}
